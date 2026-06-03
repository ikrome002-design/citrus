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
        Schema::table('team_subscriptions', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_team_subscriptions_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['merchant_id'], 'team_subscriptions_ibfk_1')->references(['id'])->on('merchants');
            $table->foreign(['created_by'], 'fk_team_subscriptions_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_team_subscriptions_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['team_plan_id'], 'team_subscriptions_ibfk_2')->references(['id'])->on('team_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_subscriptions', function (Blueprint $table) {
            $table->dropForeign('fk_team_subscriptions_deleted_by');
            $table->dropForeign('team_subscriptions_ibfk_1');
            $table->dropForeign('fk_team_subscriptions_created_by');
            $table->dropForeign('fk_team_subscriptions_updated_by');
            $table->dropForeign('team_subscriptions_ibfk_2');
        });
    }
};
