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
        Schema::create('wishlist', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('user_id');
            $table->unsignedInteger('product_id')->index('product_id');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index('fk_wishlist_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_wishlist_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_wishlist_updated_by');
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
        Schema::dropIfExists('wishlist');
    }
};
