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
        Schema::create('vendors', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('business_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('business_type')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('business_location')->nullable();
            $table->string('phone_number')->nullable();
            $table->integer('country')->nullable();
            $table->text('business_about')->nullable();
            $table->enum('role', ['0', '1', '2'])->default('0');
            $table->enum('agree', ['0', '1'])->default('1');
            $table->enum('account_type', ['0', '1', '2'])->default('0');
            $table->enum('user_type', ['0', '1'])->default('0');
            $table->string('citrus_merchant_id')->nullable();
            $table->unsignedInteger('staff_id')->nullable()->index('vendors_staff_id_foreign');
            $table->integer('status')->default(0);
            $table->integer('payment_status')->default(1);
            $table->softDeletes();
            $table->string('short_description')->nullable();
            $table->text('company_overview')->nullable();
            $table->string('business_year')->nullable();
            $table->text('location')->nullable();
            $table->text('cover_image')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('otp')->nullable();
            $table->dateTime('otp_expires_at')->nullable();
            $table->enum('verify_status', ['0', '1'])->default('0');
            $table->text('shop_image')->nullable();
            $table->string('citrus_shop_id')->nullable();
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
        Schema::dropIfExists('vendors');
    }
};
