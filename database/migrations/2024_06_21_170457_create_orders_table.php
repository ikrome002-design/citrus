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
            $table->increments('id');
            $table->string('order_no')->unique('orders_reference_unique');
            $table->unsignedInteger('courier_id')->nullable()->index();
            $table->unsignedInteger('user_id')->index('orders_customer_id_index');
            $table->unsignedInteger('address_id')->index('orders_address_id_foreign');
            $table->string('order_status')->nullable();
            $table->date('order_date')->nullable();
            $table->decimal('discounts')->default(0);
            $table->text('total_products');
            $table->decimal('total_shipping')->default(0);
            $table->decimal('tax')->default(0);
            $table->decimal('total');
            $table->decimal('total_paid')->default(0);
            $table->string('tracking_number')->nullable();
            $table->text('coupon')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index('fk_orders_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_orders_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_orders_updated_by');
            $table->softDeletes();

            $table->unique(['order_no'], 'order_no');
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
