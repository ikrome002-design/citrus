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
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique('user_id');
            $table->boolean('is_super_admin')->default(false);
            $table->string('role')->default('sub_admin');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_admins_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_admins_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_admins_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
