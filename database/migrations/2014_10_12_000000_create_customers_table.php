<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('country')->nullable();
            $table->enum('agree',['0','1'])->default(1);
            $table->enum('user_type',['0','1'])->default(0);
            $table->string('national_id')->nullable();
            $table->text('dob')->nullable();
            $table->enum('gender',['0','1'])->default(0);
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('status')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('newsletter')->default(0);
            $table->string('citrus_customer_id')->nullable();
            $table->integer('merchant_id')->nullable();
            $table->integer('staff_id')->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
}
