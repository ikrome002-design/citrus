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
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->foreign(['order_item_id'], 'withdrawals_ibfk_2')->references(['id'])->on('order_items');
            $table->foreign(['updated_by'], 'withdrawals_ibfk_4')->references(['id'])->on('users');
            $table->foreign(['merchant_id'], 'withdrawals_ibfk_1')->references(['id'])->on('users');
            $table->foreign(['created_by'], 'withdrawals_ibfk_3')->references(['id'])->on('users');
            $table->foreign(['deleted_by'], 'withdrawals_ibfk_5')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropForeign('withdrawals_ibfk_2');
            $table->dropForeign('withdrawals_ibfk_4');
            $table->dropForeign('withdrawals_ibfk_1');
            $table->dropForeign('withdrawals_ibfk_3');
            $table->dropForeign('withdrawals_ibfk_5');
        });
    }
};
