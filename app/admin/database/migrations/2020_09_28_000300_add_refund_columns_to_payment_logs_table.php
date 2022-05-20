<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddRefundColumnsToPaymentLogsTable extends Migration
{
    public function up()
    {
        Schema::table('payment_logs', function (Blueprint $table) {
            $table->string('payment_code');
            $table->boolean('is_refundable')->default(false);
            $table->dateTime('refunded_at')->nullable();
        });

        DB::table('payment_logs')->get()->each(function ($log) {
            $payment = DB::table('payments')->where('name', $log->payment_name)->first();
            if (!$payment)
                return true;

            DB::table('payment_logs')->where('payment_log_id', $log->payment_log_id)->update([
                'payment_code' => $payment->code,
            ]);
        });
    }
}
