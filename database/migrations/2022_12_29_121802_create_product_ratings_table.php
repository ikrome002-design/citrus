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
            $table->comment('');
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('product_id')->nullable()->index();
            $table->unsignedInteger('vendor_id')->nullable()->index();
            $table->integer('rating');
            $table->string('review');
            $table->string('image')->nullable();
            $table->integer('status');
            $table->timestamps();
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
