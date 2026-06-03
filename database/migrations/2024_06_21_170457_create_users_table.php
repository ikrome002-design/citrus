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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('phone_number')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->unique('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_users_created_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_users_updated_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_users_deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
