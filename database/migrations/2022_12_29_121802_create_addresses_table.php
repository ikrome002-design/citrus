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
        Schema::create('addresses', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->enum('address_type', ['billing', 'shipping']);
            $table->string('alias');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('company_name')->nullable();
            $table->string('zip')->nullable();
            $table->string('state_code')->nullable();
            $table->string('city')->nullable();
            $table->integer('province_id')->nullable();
            $table->unsignedInteger('country_id')->index();
            $table->unsignedInteger('customer_id')->index();
            $table->integer('status')->default(0);
            $table->string('phone')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('addresses');
    }
};
