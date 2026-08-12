<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Tables;

use Illuminate\Support\Facades\DB;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Models\BillRequest;
use Naxas\RestaurantOps\Models\BillSplit;
use Naxas\RestaurantOps\Models\BillSplitItem;
use Naxas\RestaurantOps\Models\Floor;
use Naxas\RestaurantOps\Models\PosOrder;
use Naxas\RestaurantOps\Models\RestaurantTable;
use Naxas\RestaurantOps\Models\TableMerge;
use Naxas\RestaurantOps\Models\TableSession;
use Naxas\RestaurantOps\Models\TableSessionEvent;
use Naxas\RestaurantOps\Models\TableTransfer;
use Naxas\RestaurantOps\Pos\Contracts\PosOrderServiceContract;
use Naxas\RestaurantOps\Pos\PosOrderStatus;
use Naxas\RestaurantOps\Tables\Events\TableClosed;

final class TableManagementService
{
    public function __construct(private readonly LocationContextContract $locations, private readonly PosOrderServiceContract $orders, private readonly AuditLogger $audit) {}

    public function saveFloor(mixed $actor, array $data, ?Floor $floor = null): Floor
    {
        $actorId = (int) $actor->getAuthIdentifier(); $locationId = $this->locationId();
        if ($floor && (int) $floor->location_id !== $locationId) throw TableException::forbidden('table_location_forbidden', 'Cross-location floor access is prohibited.');
        $payload = ['location_id'=>$locationId,'name'=>trim((string)$data['name']),'code'=>trim((string)$data['code']),'description'=>$data['description']??null,'sort_order'=>(int)($data['sort_order']??0),'is_active'=>(bool)($data['is_active']??true),'updated_by'=>$actorId];
        if (!$payload['name'] || !$payload['code']) throw new TableException('floor_invalid', 'Floor name and code are required.');
        $floor ? $floor->forceFill($payload)->save() : $floor = Floor::create($payload + ['created_by'=>$actorId]);
        $this->audit->info('restaurant_ops.floor_saved', ['floor_id'=>$floor->getKey(),'location_id'=>$locationId,'actor_id'=>$actorId]);
        return $floor;
    }

    public function saveTable(mixed $actor, array $data, ?RestaurantTable $table = null): RestaurantTable
    {
        $actorId = (int) $actor->getAuthIdentifier(); $locationId = $this->locationId();
        if ($table && (int)$table->location_id !== $locationId) throw TableException::forbidden('table_location_forbidden','Cross-location table access is prohibited.');
        $floor = Floor::where('location_id',$locationId)->findOrFail((int)$data['floor_id']);
        $capacity = max(1, (int)($data['capacity'] ?? 1));
        $payload = ['location_id'=>$locationId,'floor_id'=>$floor->getKey(),'name'=>trim((string)$data['name']),'code'=>trim((string)$data['code']),'table_number'=>trim((string)($data['table_number'] ?? $data['code'])),'capacity'=>$capacity,'shape'=>(string)($data['shape']??'rectangle'),'position_x'=>(int)($data['position_x']??0),'position_y'=>(int)($data['position_y']??0),'width'=>max(40,(int)($data['width']??120)),'height'=>max(40,(int)($data['height']??90)),'rotation'=>(int)($data['rotation']??0),'status'=>(string)($data['status']??TableStatus::AVAILABLE),'is_active'=>(bool)($data['is_active']??true),'sort_order'=>(int)($data['sort_order']??0),'updated_by'=>$actorId];
        if (!$payload['name'] || !$payload['code']) throw new TableException('table_invalid','Table name and code are required.');
        if (!in_array($payload['status'], [TableStatus::AVAILABLE,TableStatus::OCCUPIED,TableStatus::BILLING,TableStatus::RESERVED,TableStatus::BLOCKED], true)) throw new TableException('table_status_invalid','Invalid table status.');
        $table ? $table->forceFill($payload)->save() : $table = RestaurantTable::create($payload + ['created_by'=>$actorId]);
        $this->audit->info('restaurant_ops.table_saved', ['table_id'=>$table->getKey(),'location_id'=>$locationId,'actor_id'=>$actorId]);
        return $table;
    }

    public function open(RestaurantTable $table, mixed $actor, array $data): TableSession
    {
        return DB::transaction(function () use ($table,$actor,$data) {
            $actorId=(int)$actor->getAuthIdentifier(); $locationId=$this->locationId();
            $locked=RestaurantTable::lockForUpdate()->findOrFail($table->getKey()); $this->assertTable($locked,$locationId);
            if (!$locked->is_active || $locked->status !== TableStatus::AVAILABLE) throw TableException::conflict('table_not_available','Table is not available.');
            $guests=$this->guestCount($data, $locked);
            $order=$this->orders->createDraft($actor, ['service_type'=>'dine_in','guest_count'=>$guests,'customer_id'=>$data['customer_id']??null,'order_note'=>$data['note']??null], (string)($data['idempotency_key'] ?? request()->header('Idempotency-Key') ?: 'table-open-'.$locked->getKey().'-'.uniqid()));
            $session=TableSession::create(['location_id'=>$locationId,'table_id'=>$locked->getKey(),'active_table_id'=>$locked->getKey(),'pos_order_id'=>$order->getKey(),'official_order_id'=>$order->order_id,'guest_count'=>$guests,'opened_by'=>$actorId,'opened_at'=>now(),'status'=>TableSessionStatus::OPEN]);
            $order->forceFill(['table_session_id'=>$session->getKey()])->save(); $locked->forceFill(['status'=>TableStatus::OCCUPIED])->save();
            $this->event($session,'table_opened',$actorId, ['previous_state'=>TableStatus::AVAILABLE,'new_state'=>TableStatus::OCCUPIED]);
            return $session->fresh(['table','posOrder']);
        }, 3);
    }

    public function updateGuestCount(TableSession $session, mixed $actor, int $guestCount, int $version): TableSession
    { return DB::transaction(function () use ($session,$actor,$guestCount,$version) { $locked=$this->lockSession($session,$version); $table=RestaurantTable::lockForUpdate()->findOrFail($locked->active_table_id ?: $locked->table_id); $previous=$locked->guest_count; $count=$this->guestCount(['guest_count'=>$guestCount],$table); $locked->forceFill(['guest_count'=>$count,'version'=>$locked->version+1])->save(); PosOrder::whereKey($locked->pos_order_id)->update(['guest_count'=>$count]); $this->event($locked,'guest_count_changed',(int)$actor->getAuthIdentifier(),['previous'=>$previous,'new'=>$count]); return $locked->fresh(); }, 3); }

    public function requestBill(TableSession $session, mixed $actor, int $version): BillRequest
    { return DB::transaction(function () use ($session,$actor,$version) { $locked=$this->lockSession($session,$version); $table=RestaurantTable::lockForUpdate()->findOrFail($locked->active_table_id); $order=PosOrder::lockForUpdate()->findOrFail($locked->pos_order_id); $locked->forceFill(['status'=>TableSessionStatus::BILLING,'version'=>$locked->version+1])->save(); $table->forceFill(['status'=>TableStatus::BILLING])->save(); $bill=BillRequest::create(['table_session_id'=>$locked->getKey(),'location_id'=>$locked->location_id,'table_id'=>$table->getKey(),'pos_order_id'=>$order->getKey(),'outstanding_total'=>$order->outstanding_total ?: $order->order_total,'status'=>'requested','requested_by'=>(int)$actor->getAuthIdentifier(),'requested_at'=>now()]); $this->event($locked,'bill_requested',(int)$actor->getAuthIdentifier(),['outstanding_total'=>$bill->outstanding_total]); return $bill; }, 3); }

    public function transfer(TableSession $session, RestaurantTable $to, mixed $actor, int $version, ?string $reason=null): TableSession
    { return DB::transaction(function () use ($session,$to,$actor,$version,$reason) { $locked=$this->lockSession($session,$version); $ids=[$locked->active_table_id,$to->getKey()]; sort($ids); $tables=RestaurantTable::whereIn('id',$ids)->orderBy('id')->lockForUpdate()->get()->keyBy('id'); $from=$tables[$locked->active_table_id]; $dest=$tables[$to->getKey()]; $this->assertTable($dest,(int)$locked->location_id); if($dest->status!==TableStatus::AVAILABLE || !$dest->is_active) throw TableException::conflict('table_transfer_destination_unavailable','Destination table is not available.'); $from->forceFill(['status'=>TableStatus::AVAILABLE])->save(); $dest->forceFill(['status'=>TableStatus::OCCUPIED])->save(); $locked->forceFill(['active_table_id'=>$dest->getKey(),'table_id'=>$dest->getKey(),'version'=>$locked->version+1])->save(); TableTransfer::create(['table_session_id'=>$locked->getKey(),'location_id'=>$locked->location_id,'from_table_id'=>$from->getKey(),'to_table_id'=>$dest->getKey(),'pos_order_id'=>$locked->pos_order_id,'transferred_by'=>(int)$actor->getAuthIdentifier(),'reason'=>$reason,'transferred_at'=>now()]); $this->event($locked,'table_transferred',(int)$actor->getAuthIdentifier(),['from_table_id'=>$from->getKey(),'to_table_id'=>$dest->getKey()]); return $locked->fresh(['table','posOrder']); }, 3); }

    public function merge(TableSession $primary, TableSession $secondary, mixed $actor, int $version): TableMerge
    { return DB::transaction(function () use ($primary,$secondary,$actor,$version) { $p=$this->lockSession($primary,$version); $s=TableSession::lockForUpdate()->findOrFail($secondary->getKey()); $this->assertSessionOpen($s); if((int)$p->location_id !== (int)$s->location_id) throw TableException::forbidden('table_merge_location_mismatch','Cannot merge across locations.'); foreach([$p->pos_order_id,$s->pos_order_id] as $orderId){ $o=PosOrder::lockForUpdate()->findOrFail($orderId); if(in_array($o->status,[PosOrderStatus::PAID,PosOrderStatus::CANCELLED],true) || (float)$o->outstanding_total <= 0 && (float)$o->order_total > 0) throw TableException::conflict('table_merge_paid_order','Only unpaid/open orders may be merged.'); } RestaurantTable::whereKey($s->active_table_id)->lockForUpdate()->update(['status'=>TableStatus::AVAILABLE]); $s->forceFill(['active_table_id'=>null,'status'=>TableSessionStatus::MERGED,'version'=>$s->version+1])->save(); $merge=TableMerge::create(['location_id'=>$p->location_id,'primary_table_session_id'=>$p->getKey(),'merged_table_session_id'=>$s->getKey(),'primary_table_id'=>$p->active_table_id,'merged_table_id'=>$s->table_id,'merged_by'=>(int)$actor->getAuthIdentifier(),'merged_at'=>now()]); $this->event($p,'table_merged',(int)$actor->getAuthIdentifier(),['merged_session_id'=>$s->getKey()]); return $merge; }, 3); }

    public function split(TableSession $session, mixed $actor, array $allocations, string $type, int $version): array
    { return DB::transaction(function () use ($session,$actor,$allocations,$type,$version) { $locked=$this->lockSession($session,$version); $order=PosOrder::with('items')->lockForUpdate()->findOrFail($locked->pos_order_id); if ((float)$order->outstanding_total <= 0 && (float)$order->order_total > 0) throw TableException::conflict('bill_split_paid_order','Paid orders cannot be split.'); $total=round((float)$order->order_total,4); $sum=round(array_sum(array_map(fn($a)=>(float)($a['amount']??0),$allocations)),4); if(abs($sum-$total)>0.0001) throw new TableException('bill_split_total_mismatch','Split allocations must equal the authoritative order total.'); $created=[]; foreach(array_values($allocations) as $i=>$allocation){ $split=BillSplit::create(['table_session_id'=>$locked->getKey(),'pos_order_id'=>$order->getKey(),'split_number'=>'S'.($i+1).'-'.$locked->getKey(),'allocation_type'=>$type,'status'=>'open','total'=>(float)$allocation['amount'],'outstanding'=>(float)$allocation['amount'],'created_by'=>(int)$actor->getAuthIdentifier()]); foreach(($allocation['items']??[]) as $item){ BillSplitItem::create(['bill_split_id'=>$split->getKey(),'pos_order_item_id'=>$item['pos_order_item_id']??null,'quantity'=>$item['quantity']??null,'amount'=>(float)($item['amount']??0),'allocation_payload'=>$item]); } $created[]=$split->fresh('items'); } $this->event($locked,'bill_split',(int)$actor->getAuthIdentifier(),['allocation_type'=>$type,'split_count'=>count($created)]); return $created; },3); }

    public function close(TableSession $session, mixed $actor, int $version): TableSession
    { return DB::transaction(function () use ($session,$actor,$version) { $locked=$this->lockSession($session,$version); $order=PosOrder::lockForUpdate()->findOrFail($locked->pos_order_id); if((float)$order->outstanding_total > 0) throw TableException::conflict('table_close_unpaid','Table cannot close with outstanding balance.'); if(BillSplit::where('table_session_id',$locked->getKey())->where('status','open')->exists()) throw TableException::conflict('table_close_pending_split','Table cannot close with pending bill split.'); $table=RestaurantTable::lockForUpdate()->findOrFail($locked->active_table_id); $locked->forceFill(['status'=>TableSessionStatus::CLOSED,'active_table_id'=>null,'closed_by'=>(int)$actor->getAuthIdentifier(),'closed_at'=>now(),'version'=>$locked->version+1])->save(); $table->forceFill(['status'=>TableStatus::AVAILABLE])->save(); $this->event($locked,'table_closed',(int)$actor->getAuthIdentifier()); event(new TableClosed(['table_session_id'=>$locked->getKey(),'table_id'=>$table->getKey()])); return $locked->fresh(); },3); }

    public function bill(TableSession $session): array { $this->assertLocation((int)$session->location_id); $session->load(['table.floor','posOrder.items']); $orders=collect([$session->posOrder]); foreach(TableMerge::where('primary_table_session_id',$session->getKey())->where('status','active')->get() as $merge){ $orders->push(TableSession::find($merge->merged_table_session_id)?->posOrder); } $orders=$orders->filter(); $total=(float)$orders->sum('order_total'); $paid=(float)$orders->sum(fn($o)=>max(0,(float)$o->order_total-(float)$o->outstanding_total)); return ['session'=>$session,'orders'=>$orders->values(),'grand_total'=>$total,'payment_received'=>$paid,'outstanding'=>$total-$paid,'payment_state'=>$total-$paid<=0?'paid':'unpaid']; }

    private function lockSession(TableSession $session, int $version): TableSession { $locked=TableSession::lockForUpdate()->findOrFail($session->getKey()); $this->assertLocation((int)$locked->location_id); $this->assertSessionOpen($locked); if($locked->version !== $version) throw TableException::conflict('table_session_version_conflict','The table session changed by another request.'); return $locked; }
    private function assertSessionOpen(TableSession $session): void { if(!in_array($session->status,[TableSessionStatus::OPEN,TableSessionStatus::BILLING],true) || !$session->active_table_id) throw TableException::conflict('table_session_immutable','Closed, transferred, or merged sessions cannot be mutated.'); }
    private function guestCount(array $data, RestaurantTable $table): int { $count=(int)($data['guest_count']??0); if($count<1) throw new TableException('guest_count_invalid','Guest count must be at least 1.'); if($count > (int)$table->capacity) throw new TableException('guest_count_exceeds_capacity','Guest count exceeds table capacity.'); return $count; }
    private function assertTable(RestaurantTable $table, int $locationId): void { if((int)$table->location_id!==$locationId) throw TableException::forbidden('table_location_forbidden','Cross-location table access is prohibited.'); }
    private function assertLocation(int $locationId): void { if($locationId !== $this->locationId()) throw TableException::forbidden('table_location_forbidden','Cross-location table access is prohibited.'); }
    private function locationId(): int { if($this->locations->isGlobal()) throw TableException::forbidden('table_location_required','Select a concrete branch.'); return (int)$this->locations->requireCurrent()->getKey(); }
    private function event(TableSession $session, string $type, int $actorId, array $payload=[]): void { TableSessionEvent::create(['table_session_id'=>$session->getKey(),'location_id'=>$session->location_id,'floor_id'=>RestaurantTable::find($session->active_table_id ?: $session->table_id)?->floor_id,'table_id'=>$session->active_table_id ?: $session->table_id,'pos_order_id'=>$session->pos_order_id,'event_type'=>$type,'actor_id'=>$actorId,'payload'=>$payload,'correlation_id'=>request()->header('X-Correlation-ID') ?: request()->header('Idempotency-Key'),'occurred_at'=>now()]); $this->audit->info('restaurant_ops.'.$type, ['table_session_id'=>$session->getKey(),'actor_id'=>$actorId]+$payload); }
}
