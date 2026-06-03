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
        Schema::table('products', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_products_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['category_id'], 'products_ibfk_1')->references(['id'])->on('categories')->onDelete('SET NULL');
            $table->foreign(['created_by'], 'fk_products_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_products_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['merchant_id'], 'products_vendor_id_foreign')->references(['id'])->on('merchants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('fk_products_deleted_by');
            $table->dropForeign('products_ibfk_1');
            $table->dropForeign('fk_products_created_by');
            $table->dropForeign('fk_products_updated_by');
            $table->dropForeign('products_vendor_id_foreign');
        });
    }
};
