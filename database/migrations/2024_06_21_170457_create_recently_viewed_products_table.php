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
        Schema::create('recently_viewed_products', function (Blueprint $table) {
            $table->unsignedInteger('id')->default(0);
            $table->unsignedInteger('user_id');
            $table->text('cart_details')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recently_viewed_products');
    }
};
