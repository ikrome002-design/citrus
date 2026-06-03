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
        Schema::create('product_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('product_id')->nullable()->index();
            $table->integer('rating');
            $table->string('review');
            $table->string('image')->nullable();
            $table->integer('status');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index('fk_product_ratings_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_product_ratings_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_product_ratings_updated_by');
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
        Schema::dropIfExists('product_ratings');
    }
};
