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
        Schema::create('order_product', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->unsignedInteger('order_id')->index();
            $table->integer('product_id')->nullable();
            $table->unsignedInteger('product_attribute_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->integer('shop_id')->nullable();
            $table->integer('shipping')->nullable();
            $table->integer('order_status')->nullable();
            $table->date('date');
            $table->string('product_name')->nullable();
            $table->string('product_sku')->nullable();
            $table->text('product_description')->nullable();
            $table->decimal('product_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
    }
};
