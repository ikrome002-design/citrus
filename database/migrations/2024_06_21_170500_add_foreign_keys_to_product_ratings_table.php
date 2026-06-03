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
        Schema::table('product_ratings', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_product_ratings_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['product_id'])->references(['id'])->on('products');
            $table->foreign(['created_by'], 'fk_product_ratings_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_product_ratings_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['user_id'])->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_ratings', function (Blueprint $table) {
            $table->dropForeign('fk_product_ratings_deleted_by');
            $table->dropForeign('product_ratings_product_id_foreign');
            $table->dropForeign('fk_product_ratings_created_by');
            $table->dropForeign('fk_product_ratings_updated_by');
            $table->dropForeign('product_ratings_user_id_foreign');
        });
    }
};
