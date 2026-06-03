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
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_tickets_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['user_id'], 'tickets_ibfk_1')->references(['id'])->on('users');
            $table->foreign(['created_by'], 'fk_tickets_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_tickets_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('fk_tickets_deleted_by');
            $table->dropForeign('tickets_ibfk_1');
            $table->dropForeign('fk_tickets_created_by');
            $table->dropForeign('fk_tickets_updated_by');
        });
    }
};
