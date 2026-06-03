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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand', 50)->nullable();
            $table->unsignedInteger('category_id')->nullable()->index('category_id');
            $table->string('sku')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('show_product')->default(true);
            $table->decimal('length')->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('height')->nullable();
            $table->string('length_unit')->nullable();
            $table->decimal('weight')->nullable()->default(0);
            $table->string('weight_unit')->nullable();
            $table->timestamps();
            $table->enum('product_type', ['physical', 'digital', 'subscription'])->nullable();
            $table->unsignedInteger('merchant_id')->nullable()->index('products_vendor_id_foreign');
            $table->unsignedInteger('created_by')->nullable()->index('products_created_by_foreign');
            $table->unsignedInteger('updated_by')->nullable()->index('products_updated_by_foreign');
            $table->integer('tarrif_id');
            $table->softDeletes();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_products_deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
