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
        Schema::create('product_attribute_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('show_product_attribute')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('quantity_in _stock');
            $table->decimal('original_price', 10)->nullable();
            $table->string('selling_price')->nullable();
            $table->unsignedInteger('product_id')->index('product_attributes_product_id_foreign');
            $table->unsignedInteger('product_attribute_id')->nullable();
            $table->unsignedInteger('subscription_attribute_id')->nullable();
            $table->string('attribute_value')->nullable();
            $table->text('digital_link')->nullable();
            $table->enum('digital_link_type', ['external', 'internal'])->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index('fk_product_attribute_prices_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_product_attribute_prices_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_product_attribute_prices_updated_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_prices');
    }
};
