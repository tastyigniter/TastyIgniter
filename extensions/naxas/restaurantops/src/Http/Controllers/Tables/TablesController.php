<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers\Tables;

use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Http\Controllers\AdminPageController;
use Naxas\RestaurantOps\Models\Floor;
use Naxas\RestaurantOps\Models\RestaurantTable;
use Naxas\RestaurantOps\Models\TableSession;
use Naxas\RestaurantOps\Tables\TableException;
use Naxas\RestaurantOps\Tables\TableManagementService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class TablesController extends AdminPageController
{
    public function __construct(private readonly TableManagementService $tables) { parent::__construct(); }
    public function index(): Response { return response($this->renderAdminPage('Naxas.RestaurantOps::tables.index', ['floors'=>Floor::where('location_id', app(LocationContextContract::class)->currentId())->orderBy('sort_order')->get(), 'tables'=>RestaurantTable::with('floor','activeSession.posOrder')->where('location_id', app(LocationContextContract::class)->currentId())->orderBy('sort_order')->get()], 'Restaurant Tables', 'restaurant-ops-tables')); }
    public function map(): Response { return response($this->renderAdminPage('Naxas.RestaurantOps::tables.map', ['floors'=>Floor::with('tables.activeSession.posOrder')->where('location_id', app(LocationContextContract::class)->currentId())->orderBy('sort_order')->get()], 'Table Map', 'restaurant-ops-table-map')); }
    public function store(): Response { return $this->respond(fn()=> $this->tables->saveTable($this->user(), request()->all()), 201); }
    public function update(string $table): Response { return $this->respond(fn()=> $this->tables->saveTable($this->user(), request()->all(), RestaurantTable::findOrFail($table))); }
    public function open(string $table): Response { return $this->respond(fn()=> $this->tables->open(RestaurantTable::findOrFail($table), $this->user(), request()->all()), 201); }
    public function guestCount(string $session): Response { return $this->respond(fn()=> $this->tables->updateGuestCount(TableSession::findOrFail($session), $this->user(), (int)request('guest_count'), $this->version())); }
    public function bill(string $session): Response { return response($this->renderAdminPage('Naxas.RestaurantOps::tables.detail', $this->tables->bill(TableSession::findOrFail($session)), 'Running Bill', 'restaurant-ops-table-map')); }
    public function billRequest(string $session): Response { return $this->respond(fn()=> $this->tables->requestBill(TableSession::findOrFail($session), $this->user(), $this->version()), 201); }
    public function transfer(string $session): Response { return $this->respond(fn()=> $this->tables->transfer(TableSession::findOrFail($session), RestaurantTable::findOrFail((int)request('to_table_id')), $this->user(), $this->version(), request('reason'))); }
    public function merge(string $session): Response { return $this->respond(fn()=> $this->tables->merge(TableSession::findOrFail($session), TableSession::findOrFail((int)request('merge_session_id')), $this->user(), $this->version()), 201); }
    public function split(string $session): Response { return $this->respond(fn()=> $this->tables->split(TableSession::findOrFail($session), $this->user(), (array)request('allocations', []), (string)request('allocation_type','amount'), $this->version()), 201); }
    public function close(string $session): Response { return $this->respond(fn()=> $this->tables->close(TableSession::findOrFail($session), $this->user(), $this->version())); }
    private function version(): int { $v=filter_var(request('version'), FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]); if(!$v) throw TableException::conflict('table_session_version_required','A valid table session version is required.'); return $v; }
    private function respond(callable $cb, int $status=200): Response { try { return response()->json(['data'=>$cb()], $status); } catch(TableException $e){ return response()->json(['error'=>['code'=>$e->errorCode,'message'=>$e->getMessage()]], $e->status); } catch(Throwable $e){ report($e); return response()->json(['error'=>['code'=>'table_operation_failed','message'=>'The table operation could not be completed safely.']],409); } }
    private function user(): mixed { return app('admin.auth')->user(); }
}
