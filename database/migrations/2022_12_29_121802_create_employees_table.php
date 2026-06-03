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
        Schema::create('employees', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('status')->default(1);
            $table->integer('merchant_id')->nullable();
            $table->string('citrus_merchant_id')->nullable();
            $table->enum('role', ['0', '1'])->default('0');
            $table->softDeletes();
            $table->rememberToken();
            $table->integer('type')->default(0);
            $table->integer('shop_id')->nullable();
            $table->timestamps();
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
