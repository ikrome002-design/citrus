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
        Schema::table('merchant_balance_transactions', function (Blueprint $table) {
            $table->foreign(['merchant_id'], 'merchant_balance_transactions_ibfk_2')->references(['id'])->on('merchants');
            $table->foreign(['deleted_by'], 'merchant_balance_transactions_ibfk_4')->references(['id'])->on('users');
            $table->foreign(['order_item_id'], 'merchant_balance_transactions_ibfk_1')->references(['id'])->on('order_items');
            $table->foreign(['created_by'], 'merchant_balance_transactions_ibfk_3')->references(['id'])->on('users');
            $table->foreign(['updated_by'], 'merchant_balance_transactions_ibfk_5')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_balance_transactions', function (Blueprint $table) {
            $table->dropForeign('merchant_balance_transactions_ibfk_2');
            $table->dropForeign('merchant_balance_transactions_ibfk_4');
            $table->dropForeign('merchant_balance_transactions_ibfk_1');
            $table->dropForeign('merchant_balance_transactions_ibfk_3');
            $table->dropForeign('merchant_balance_transactions_ibfk_5');
        });
    }
};
