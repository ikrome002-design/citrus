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
        Schema::table('wishlist', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_wishlist_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['product_id'], 'wishlist_ibfk_1')->references(['id'])->on('products');
            $table->foreign(['created_by'], 'fk_wishlist_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_wishlist_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['user_id'], 'wishlist_ibfk_2')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wishlist', function (Blueprint $table) {
            $table->dropForeign('fk_wishlist_deleted_by');
            $table->dropForeign('wishlist_ibfk_1');
            $table->dropForeign('fk_wishlist_created_by');
            $table->dropForeign('fk_wishlist_updated_by');
            $table->dropForeign('wishlist_ibfk_2');
        });
    }
};
