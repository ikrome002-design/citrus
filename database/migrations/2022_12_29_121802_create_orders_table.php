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
        Schema::create('orders', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->string('reference')->unique();
            $table->unsignedInteger('courier_id')->index();
            $table->string('courier')->nullable();
            $table->unsignedInteger('customer_id')->index();
            $table->unsignedInteger('address_id')->index('orders_address_id_foreign');
            $table->unsignedInteger('delivery_address')->nullable();
            $table->unsignedInteger('order_status_id')->index();
            $table->integer('payouts')->default(0);
            $table->date('release_date')->nullable();
            $table->text('vendor_id');
            $table->string('payment');
            $table->decimal('discounts')->default(0);
            $table->text('total_products');
            $table->decimal('total_shipping')->default(0);
            $table->decimal('tax')->default(0);
            $table->decimal('total');
            $table->decimal('total_paid')->default(0);
            $table->string('invoice')->nullable();
            $table->string('label_url')->nullable();
            $table->string('tracking_number')->nullable();
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
};
