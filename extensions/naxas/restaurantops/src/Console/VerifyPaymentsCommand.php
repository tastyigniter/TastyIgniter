<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Naxas\RestaurantOps\Payments\Contracts\OfficialPaymentAdapter;
use Naxas\RestaurantOps\Payments\Contracts\ReceiptNumberProvider;
use Naxas\RestaurantOps\Payments\Contracts\ShiftTenderRecorder;
use Naxas\RestaurantOps\Support\PermissionDefinitions;

final class VerifyPaymentsCommand extends Command
{
    protected $signature = 'restaurant-ops:verify-payments';

    protected $description = 'Read-only verification of RestaurantOps payment integration';

    public function handle(): int
    {
        $fail = [];
        $tables = ['naxas_restaurant_ops_pos_payments', 'naxas_restaurant_ops_pos_payment_tenders', 'naxas_restaurant_ops_pos_payment_events', 'naxas_restaurant_ops_pos_receipts', 'naxas_restaurant_ops_receipt_sequences', 'naxas_restaurant_ops_pos_payment_reversals'];
        foreach ($tables as $table) {
            if (! Schema::hasTable($table)) {
                $fail[] = "Missing table {$table}";
            }
        }foreach (['Restaurant.POS.Payment.Create', 'Restaurant.POS.Payment.View', 'Restaurant.POS.Payment.ReprintReceipt', 'Restaurant.POS.Payment.Reverse.Request', 'Restaurant.POS.Payment.Reverse.Approve', 'Restaurant.Shifts.PaymentSummary.View'] as $code) {
            if (! isset(PermissionDefinitions::all()[$code])) {
                $fail[] = "Missing permission {$code}";
            }
        }foreach ([OfficialPaymentAdapter::class, ReceiptNumberProvider::class, ShiftTenderRecorder::class] as $binding) {
            if (! app()->bound($binding)) {
                $fail[] = "Missing binding {$binding}";
            }
        }foreach (['naxas.restaurantops.pos.payments.store', 'naxas.restaurantops.pos.receipt.show'] as $route) {
            if (! Route::has($route)) {
                $fail[] = "Missing route {$route}";
            }
        }if (! view()->exists('Naxas.RestaurantOps::payments.receipt')) {
            $fail[] = 'Missing receipt view';
        }if (Schema::hasTable('naxas_restaurant_ops_pos_payments')) {
            $duplicates = \DB::table('naxas_restaurant_ops_pos_payments')->select('pos_order_id')->where('status', 'paid')->groupBy('pos_order_id')->havingRaw('COUNT(*) > 1')->count();
            if ($duplicates) {
                $fail[] = "{$duplicates} orders have duplicate paid payments";
            }$orphans = \DB::table('naxas_restaurant_ops_pos_payment_tenders as t')->leftJoin('naxas_restaurant_ops_pos_payments as p', 'p.id', '=', 't.pos_payment_id')->whereNull('p.id')->count();
            if ($orphans) {
                $fail[] = "{$orphans} orphan tenders";
            }
        }foreach ($fail as $message) {
            $this->error($message);
        }if ($fail) {
            return self::FAILURE;
        }$this->info('RestaurantOps payment verification passed without mutating data.');

        return self::SUCCESS;
    }
}
