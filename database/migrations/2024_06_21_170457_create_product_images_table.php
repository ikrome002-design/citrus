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
        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->index();
            $table->string('image_url')->nullable();
            $table->integer('product_attribute_price_id')->nullable();
            $table->integer('subscription_attribute_price_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_product_images_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_product_images_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_product_images_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_images');
    }
};
