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
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_invoices_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['user_id'], 'invoices_ibfk_1')->references(['id'])->on('users');
            $table->foreign(['created_by'], 'fk_invoices_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_invoices_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['order_item_id'], 'invoices_ibfk_2')->references(['id'])->on('order_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('fk_invoices_deleted_by');
            $table->dropForeign('invoices_ibfk_1');
            $table->dropForeign('fk_invoices_created_by');
            $table->dropForeign('fk_invoices_updated_by');
            $table->dropForeign('invoices_ibfk_2');
        });
    }
};
