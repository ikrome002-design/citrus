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
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id')->index('permission_role_role_id_foreign');
            $table->unsignedInteger('created_by')->nullable()->index('fk_permission_role_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_permission_role_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_permission_role_updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_role');
    }
};
