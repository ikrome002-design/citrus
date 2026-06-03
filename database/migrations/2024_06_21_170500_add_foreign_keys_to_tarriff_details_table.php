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
        Schema::table('tarriff_details', function (Blueprint $table) {
            $table->foreign(['updated_by'], 'tarriff_details_ibfk_2')->references(['id'])->on('users');
            $table->foreign(['deleted_by'], 'tarriff_details_ibfk_4')->references(['id'])->on('users');
            $table->foreign(['tarrif_id'], 'tarriff_details_ibfk_1')->references(['id'])->on('tarriffs');
            $table->foreign(['created_by'], 'tarriff_details_ibfk_3')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarriff_details', function (Blueprint $table) {
            $table->dropForeign('tarriff_details_ibfk_2');
            $table->dropForeign('tarriff_details_ibfk_4');
            $table->dropForeign('tarriff_details_ibfk_1');
            $table->dropForeign('tarriff_details_ibfk_3');
        });
    }
};
