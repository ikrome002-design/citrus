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
        Schema::table('role_user', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_role_user_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['role_id'])->references(['id'])->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['created_by'], 'fk_role_user_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_role_user_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign('fk_role_user_deleted_by');
            $table->dropForeign('role_user_role_id_foreign');
            $table->dropForeign('fk_role_user_created_by');
            $table->dropForeign('fk_role_user_updated_by');
        });
    }
};
