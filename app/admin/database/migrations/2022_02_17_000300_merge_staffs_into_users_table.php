<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MergeStaffsIntoUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('user_role_id')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->boolean('status')->default(0);
            $table->tinyInteger('sale_permission')->default(0);
        });

        $this->copyValuesFromStaffsToUsers();

        $this->updateStaffIdValueToUserIdOnStaffsGroups();

        Schema::table('staffs_groups', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropForeign(['staff_group_id']);

            $table->renameColumn('staff_id', 'user_id');
            $table->renameColumn('staff_group_id', 'user_group_id');
        });

        Schema::table('staff_groups', function (Blueprint $table) {
            $table->renameColumn('staff_group_id', 'user_group_id');
            $table->renameColumn('staff_group_name', 'user_group_name');
        });

        Schema::table('staff_roles', function (Blueprint $table) {
            $table->renameColumn('staff_role_id', 'user_role_id');
        });

        Schema::rename('staffs_groups', 'users_groups');
        Schema::rename('staff_groups', 'user_groups');
        Schema::rename('staff_roles', 'user_roles');

        $this->replaceLocationableTypeStaffsWithUsers();

        Schema::table('assignable_logs', function (Blueprint $table) {
            $table->dropForeign(['assignee_id']);
        });

        $this->updateAssigneeIdValueToUserIdOnAssignableLogs();

        $this->updateAssigneeIdValueToUserIdOnOrders();

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['assignee_id']);
        });

        $this->updateAssigneeIdValueToUserIdOnReservations();

        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['assignee_id']);
        });

        $this->updateStaffIdValueToUserIdOnStatusHistory();

        Schema::table('status_history', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->renameColumn('staff_id', 'user_id');
        });

        $this->updateStaffIdValueToUserIdOnStockHistory();

        Schema::table('stock_history', function (Blueprint $table) {
            $table->renameColumn('staff_id', 'user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropColumn('staff_id');
        });

        Schema::dropIfExists('staffs');
    }

    public function down()
    {
    }

    protected function replaceLocationableTypeStaffsWithUsers(): void
    {
        DB::table('locationables')
            ->where('locationable_type', 'staffs')
            ->get()
            ->each(function ($model) {
                if (!$user = DB::table('users')->where('staff_id', $model->locationable_id)->first())
                    return TRUE;

                DB::table('locationables')->insert([
                    'location_id' => $model->location_id,
                    'locationable_id' => $user->user_id,
                    'locationable_type' => 'users',
                ]);
            });

        DB::table('locationables')->where('locationable_type', 'staffs')->delete();
    }

    protected function updateAssigneeIdValueToUserIdOnAssignableLogs(): void
    {
        DB::table('assignable_logs')
            ->whereNotNull('assignee_id')
            ->get()
            ->each(function ($model) {
                if (!$user = DB::table('users')->where('staff_id', $model->assignee_id)->first())
                    return TRUE;

                DB::table('assignable_logs')
                    ->where('id', $model->id)
                    ->update([
                        'assignee_id' => $user->user_id,
                    ]);
            });
    }

    protected function updateAssigneeIdValueToUserIdOnOrders(): void
    {
        DB::table('orders')
            ->whereNotNull('assignee_id')
            ->get()
            ->each(function ($model) {
                if (!$user = DB::table('users')->where('staff_id', $model->assignee_id)->first())
                    return TRUE;

                DB::table('orders')
                    ->where('order_id', $model->order_id)
                    ->update([
                        'assignee_id' => $user->user_id,
                    ]);
            });
    }

    protected function updateAssigneeIdValueToUserIdOnReservations(): void
    {
        DB::table('reservations')
            ->whereNotNull('assignee_id')
            ->get()
            ->each(function ($model) {
                if (!$user = DB::table('users')->where('staff_id', $model->assignee_id)->first())
                    return TRUE;

                DB::table('reservations')
                    ->where('reservation_id', $model->reservation_id)
                    ->update([
                        'assignee_id' => $user->user_id,
                    ]);
            });
    }

    protected function updateStaffIdValueToUserIdOnStatusHistory(): void
    {
        DB::table('status_history')
            ->whereNotNull('staff_id')
            ->get()
            ->each(function ($model) {
                if (!$user = DB::table('users')->where('staff_id', $model->staff_id)->first())
                    return TRUE;

                DB::table('status_history')
                    ->where('status_history_id', $model->status_history_id)
                    ->update([
                        'staff_id' => $user->user_id,
                    ]);
            });
    }

    protected function updateStaffIdValueToUserIdOnStockHistory(): void
    {
        DB::table('stock_history')
            ->whereNotNull('staff_id')
            ->get()
            ->each(function ($model) {
                if (!$user = DB::table('users')->where('staff_id', $model->staff_id)->first())
                    return TRUE;

                DB::table('stock_history')
                    ->where('id', $model->id)
                    ->update([
                        'staff_id' => $user->user_id,
                    ]);
            });
    }

    protected function updateStaffIdValueToUserIdOnStaffsGroups(): void
    {
        DB::table('staffs_groups')
            ->whereNotNull('staff_id')
            ->get()
            ->each(function ($model) {
                if (!$user = DB::table('users')->where('staff_id', $model->staff_id)->first())
                    return TRUE;

                DB::table('staffs_groups')
                    ->where('staff_id', $model->staff_id)
                    ->where('staff_group_id', $model->staff_group_id)
                    ->update([
                        'staff_id' => $user->user_id,
                    ]);
            });
    }

    protected function copyValuesFromStaffsToUsers(): void
    {
        DB::table('users')->get()->each(function ($model) {
            if (!$staff = DB::table('staffs')->where('staff_id', $model->staff_id)->first())
                return TRUE;

            DB::table('users')->where('user_id', $model->user_id)->update([
                'name' => $staff->staff_name,
                'email' => $staff->staff_email,
                'user_role_id' => $staff->staff_role_id,
                'language_id' => $staff->language_id,
                'status' => $staff->staff_status,
                'sale_permission' => $staff->sale_permission,
            ]);
        });
    }
}
