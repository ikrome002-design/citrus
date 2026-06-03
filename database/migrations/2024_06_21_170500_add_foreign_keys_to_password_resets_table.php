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
        Schema::table('password_resets', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_password_resets_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['created_by'], 'fk_password_resets_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_password_resets_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropForeign('fk_password_resets_deleted_by');
            $table->dropForeign('fk_password_resets_created_by');
            $table->dropForeign('fk_password_resets_updated_by');
        });
    }
};
