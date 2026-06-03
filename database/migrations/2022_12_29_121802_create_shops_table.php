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
        Schema::create('shops', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('location')->nullable();
            $table->string('citrus_shop_id')->nullable();
            $table->unsignedInteger('merchant_id')->index('shops_merchant_id_foreign');
            $table->text('shop_image')->nullable();
            $table->string('type')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
};
