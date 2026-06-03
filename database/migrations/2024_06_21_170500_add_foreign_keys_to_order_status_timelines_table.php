<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_status_timelines', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_order_statuses_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['order_id'], 'order_status_timelines_ibfk_1')->references(['id'])->on('orders');
            $table->foreign(['created_by'], 'fk_order_statuses_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_order_statuses_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_status_timelines', function (Blueprint $table) {
            $table->dropForeign('fk_order_statuses_deleted_by');
            $table->dropForeign('order_status_timelines_ibfk_1');
            $table->dropForeign('fk_order_statuses_created_by');
            $table->dropForeign('fk_order_statuses_updated_by');
        });
    }
};
