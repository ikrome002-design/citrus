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
        Schema::table('branch_subscriptions', function (Blueprint $table) {
            $table->foreign(['merchant_id'], 'branch_subscriptions_ibfk_2')->references(['id'])->on('merchants');
            $table->foreign(['deleted_by'], 'fk_branch_subscriptions_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['branch_plan_id'], 'branch_subscriptions_ibfk_1')->references(['id'])->on('branch_plans');
            $table->foreign(['created_by'], 'fk_branch_subscriptions_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_branch_subscriptions_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_subscriptions', function (Blueprint $table) {
            $table->dropForeign('branch_subscriptions_ibfk_2');
            $table->dropForeign('fk_branch_subscriptions_deleted_by');
            $table->dropForeign('branch_subscriptions_ibfk_1');
            $table->dropForeign('fk_branch_subscriptions_created_by');
            $table->dropForeign('fk_branch_subscriptions_updated_by');
        });
    }
};
