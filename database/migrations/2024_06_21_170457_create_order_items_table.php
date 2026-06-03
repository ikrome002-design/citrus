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
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->index('order_product_order_id_index');
            $table->integer('product_id')->nullable();
            $table->unsignedInteger('product_attribute_price_id')->nullable();
            $table->integer('subscription_attribute_price_id')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->unsignedInteger('branch_id')->nullable();
            $table->string('branch_name')->nullable();
            $table->integer('shipping_cost')->default(0);
            $table->string('order_item_status')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->string('clearing_status')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_sku')->nullable();
            $table->text('product_description')->nullable();
            $table->decimal('original_price', 10)->nullable();
            $table->decimal('selling_price', 10);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_order_items_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_order_items_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_order_items_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
