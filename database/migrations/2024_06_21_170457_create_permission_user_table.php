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
        Schema::create('permission_user', function (Blueprint $table) {
            $table->unsignedInteger('permission_id')->index('permission_user_permission_id_foreign');
            $table->unsignedInteger('user_id');
            $table->string('user_type');
            $table->unsignedInteger('created_by')->nullable()->index('fk_permission_user_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_permission_user_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_permission_user_updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['user_id', 'permission_id', 'user_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_user');
    }
};
