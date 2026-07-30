<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::rename('user_groups', 'admin_user_groups');
        Schema::rename('user_preferences', 'admin_user_preferences');
        Schema::rename('user_roles', 'admin_user_roles');
        Schema::rename('users_groups', 'admin_users_groups');
    }

    public function down()
    {
        Schema::dropIfExists('admin_user_roles');
        Schema::dropIfExists('admin_user_groups');
        Schema::dropIfExists('admin_users_groups');
        Schema::dropIfExists('admin_user_preferences');
        Schema::dropIfExists('admin_users');
    }
};
