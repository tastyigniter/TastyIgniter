<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Add columns to morph messages and message_meta table
 * Add columns to categories table to support nestedset
 * Add sender_type, parent_id, date_updated to message table
 * Add recipient_id, recipient_type to message_meta table
 */
class AddColumnsOnMessagesTable extends Migration
{
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('sender_type')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('layout_id')->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->dateTime('date_deleted')->nullable();
        });

        Schema::table('message_meta', function (Blueprint $table) {
            $table->integer('messageable_id');
            $table->string('messageable_type', 128);
            $table->dateTime('date_deleted');
            $table->unique(['message_id', 'messageable_id', 'messageable_type']);
        });
    }

    public function down()
    {
        //
    }
}