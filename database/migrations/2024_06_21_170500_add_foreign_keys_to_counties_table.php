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
        Schema::table('counties', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_counties_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['created_by'], 'fk_counties_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_counties_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counties', function (Blueprint $table) {
            $table->dropForeign('fk_counties_deleted_by');
            $table->dropForeign('fk_counties_created_by');
            $table->dropForeign('fk_counties_updated_by');
        });
    }
};
