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
            $table->comment('');
            $table->increments('id');
            $table->unsignedInteger('brand_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('cover')->nullable();
            $table->integer('quantity');
            $table->decimal('price');
            $table->decimal('sale_price')->nullable();
            $table->integer('status')->default(0);
            $table->decimal('length')->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('height')->nullable();
            $table->string('distance_unit')->nullable();
            $table->decimal('weight')->nullable()->default(0);
            $table->string('mass_unit')->nullable();
            $table->decimal('tax')->nullable();
            $table->integer('tax_id');
            $table->integer('shop_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->string('product_type')->nullable();
            $table->string('taxable')->nullable();
            $table->string('flat_rate')->nullable();
            $table->string('flat_amount')->nullable();
            $table->unsignedInteger('vendor_id')->nullable()->index('products_vendor_id_foreign');
            $table->unsignedInteger('created_by')->nullable()->index('products_created_by_foreign');
            $table->unsignedInteger('updated_by')->nullable()->index('products_updated_by_foreign');
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
