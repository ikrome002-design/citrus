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
        Schema::create('customers', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->text('display_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('country')->nullable();
            $table->enum('agree', ['0', '1'])->default('1');
            $table->enum('user_type', ['0', '1'])->default('0');
            $table->string('national_id')->nullable();
            $table->text('dob')->nullable();
            $table->enum('gender', ['0', '1'])->default('0');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('status')->default(1);
            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('newsletter')->default(0);
            $table->string('citrus_customer_id')->nullable();
            $table->integer('merchant_id')->nullable();
            $table->integer('staff_id')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->string('avatar')->nullable();
            $table->string('phone_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
