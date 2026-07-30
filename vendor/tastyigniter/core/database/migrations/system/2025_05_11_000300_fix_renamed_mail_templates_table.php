<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::table('mail_templates')
            ->where('code', 'igniter.admin::_mail.order_update')
            ->update(['code' => 'igniter.cart::mail.order_update']);

        DB::table('mail_templates')
            ->where('code', 'igniter.admin::_mail.reservation_update')
            ->update(['code' => 'igniter.reservation::mail.reservation_update']);

        if (DB::table('mail_templates')->where('code', 'igniter.admin::_mail.password_reset')->doesntExist()) {
            DB::table('mail_templates')
                ->where('code', 'igniter.admin::_mail.password_reset')
                ->update(['code' => 'igniter.user::mail.password_reset']);
        } else {
            DB::table('mail_templates')
                ->where('code', 'igniter.admin::_mail.password_reset')
                ->delete();
        }

        if (DB::table('mail_templates')->where('code', 'igniter.admin::_mail.password_reset_request')->doesntExist()) {
            DB::table('mail_templates')
                ->where('code', 'igniter.admin::_mail.password_reset_request')
                ->update(['code' => 'igniter.user::mail.password_reset_request']);
        } else {
            DB::table('mail_templates')
                ->where('code', 'igniter.admin::_mail.password_reset_request')
                ->delete();
        }

        DB::table('mail_templates')
            ->where('code', 'igniter.admin::_mail.invite')
            ->update(['code' => 'igniter.user::mail.invite']);

        DB::table('mail_templates')
            ->where('code', 'igniter.admin::_mail.invite_customer')
            ->update(['code' => 'igniter.user::mail.invite_customer']);

        DB::table('mail_templates')
            ->where('code', 'igniter.admin::_mail.low_stock_alert')
            ->update(['code' => 'igniter.cart::mail.low_stock_alert']);
    }

    public function down()
    {
        //
    }
};
