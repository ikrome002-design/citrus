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
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign(['town_id'], 'addresses_ibfk_3')->references(['id'])->on('towns');
            $table->foreign(['deleted_by'], 'fk_addresses_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['user_id'], 'addresses_ibfk_2')->references(['id'])->on('users');
            $table->foreign(['created_by'], 'fk_addresses_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_addresses_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('addresses_ibfk_3');
            $table->dropForeign('fk_addresses_deleted_by');
            $table->dropForeign('addresses_ibfk_2');
            $table->dropForeign('fk_addresses_created_by');
            $table->dropForeign('fk_addresses_updated_by');
        });
    }
};
