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
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique('user_id');
            $table->text('cart_details')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_shopping_cart_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_shopping_cart_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_shopping_cart_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopping_cart');
    }
};
