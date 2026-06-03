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
        Schema::table('tarriffs', function (Blueprint $table) {
            $table->foreign(['updated_by'], 'tarriffs_ibfk_2')->references(['id'])->on('users');
            $table->foreign(['created_by'], 'tarriffs_ibfk_1')->references(['id'])->on('users');
            $table->foreign(['deleted_by'], 'tarriffs_ibfk_3')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarriffs', function (Blueprint $table) {
            $table->dropForeign('tarriffs_ibfk_2');
            $table->dropForeign('tarriffs_ibfk_1');
            $table->dropForeign('tarriffs_ibfk_3');
        });
    }
};
