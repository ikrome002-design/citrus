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
        Schema::table('courier_orders', function (Blueprint $table) {
            $table->foreign(['order_id'], 'courier_orders_ibfk_2')->references(['id'])->on('orders');
            $table->foreign(['deleted_by'], 'fk_courier_orders_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['courier_id'], 'courier_orders_ibfk_1')->references(['id'])->on('couriers');
            $table->foreign(['created_by'], 'fk_courier_orders_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_courier_orders_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courier_orders', function (Blueprint $table) {
            $table->dropForeign('courier_orders_ibfk_2');
            $table->dropForeign('fk_courier_orders_deleted_by');
            $table->dropForeign('courier_orders_ibfk_1');
            $table->dropForeign('fk_courier_orders_created_by');
            $table->dropForeign('fk_courier_orders_updated_by');
        });
    }
};
