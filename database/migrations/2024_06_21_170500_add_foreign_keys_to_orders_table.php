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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_orders_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['address_id'])->references(['id'])->on('addresses');
            $table->foreign(['user_id'])->references(['id'])->on('users');
            $table->foreign(['created_by'], 'fk_orders_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_orders_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['courier_id'])->references(['id'])->on('couriers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('fk_orders_deleted_by');
            $table->dropForeign('orders_address_id_foreign');
            $table->dropForeign('orders_user_id_foreign');
            $table->dropForeign('fk_orders_created_by');
            $table->dropForeign('fk_orders_updated_by');
            $table->dropForeign('orders_courier_id_foreign');
        });
    }
};
