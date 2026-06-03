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
        Schema::table('refunds', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_refunds_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['payment_id'], 'refunds_ibfk_1')->references(['id'])->on('payments');
            $table->foreign(['created_by'], 'fk_refunds_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_refunds_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refunds', function (Blueprint $table) {
            $table->dropForeign('fk_refunds_deleted_by');
            $table->dropForeign('refunds_ibfk_1');
            $table->dropForeign('fk_refunds_created_by');
            $table->dropForeign('fk_refunds_updated_by');
        });
    }
};
