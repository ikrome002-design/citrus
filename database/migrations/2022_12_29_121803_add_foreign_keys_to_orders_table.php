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
            $table->foreign(['address_id'])->references(['id'])->on('addresses');
            $table->foreign(['customer_id'])->references(['id'])->on('customers');
            $table->foreign(['courier_id'])->references(['id'])->on('couriers');
            $table->foreign(['order_status_id'])->references(['id'])->on('order_statuses');
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
            $table->dropForeign('orders_address_id_foreign');
            $table->dropForeign('orders_customer_id_foreign');
            $table->dropForeign('orders_courier_id_foreign');
            $table->dropForeign('orders_order_status_id_foreign');
        });
    }
};
