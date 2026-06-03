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
        Schema::create('feature_settings', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->string('banner_image')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->integer('order')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_text')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('feature_settings');
    }
};
