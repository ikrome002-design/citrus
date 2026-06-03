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
        Schema::table('permission_role', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_permission_role_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['permission_id'])->references(['id'])->on('permissions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['created_by'], 'fk_permission_role_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_permission_role_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['role_id'])->references(['id'])->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropForeign('fk_permission_role_deleted_by');
            $table->dropForeign('permission_role_permission_id_foreign');
            $table->dropForeign('fk_permission_role_created_by');
            $table->dropForeign('fk_permission_role_updated_by');
            $table->dropForeign('permission_role_role_id_foreign');
        });
    }
};
