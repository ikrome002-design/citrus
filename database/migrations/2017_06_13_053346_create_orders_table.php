<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference')->unique();
            $table->integer('courier_id')->unsigned()->index();
            $table->foreign('courier_id')->references('id')->on('couriers');
            $table->integer('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->integer('delivery_address')->nullable()->unsigned();
            $table->integer('order_status_id')->unsigned()->index();
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
            $table->integer('payouts')->default(0);
            $table->date('release_date')->nullable();
            $table->text('vendor_id');
            $table->string('payment');
            $table->decimal('discounts')->default(0.00);
            $table->text('total_products');
            $table->decimal('tax')->default(0.00);
            $table->decimal('total');
            $table->decimal('total_paid')->default(0.00);
            $table->string('invoice')->nullable();
            $table->string('add_info')->nullable();
            $table->date('date');
            $table->text('token')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
