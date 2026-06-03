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
        Schema::table('back_office_subscriptions', function (Blueprint $table) {
            $table->foreign(['back_office_plan_id'], 'back_office_subscriptions_ibfk_2')->references(['id'])->on('back_office_plans')->onDelete('CASCADE');
            $table->foreign(['deleted_by'], 'fk_back_office_subscriptions_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['merchant_id'], 'back_office_subscriptions_ibfk_1')->references(['id'])->on('merchants');
            $table->foreign(['created_by'], 'fk_back_office_subscriptions_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_back_office_subscriptions_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('back_office_subscriptions', function (Blueprint $table) {
            $table->dropForeign('back_office_subscriptions_ibfk_2');
            $table->dropForeign('fk_back_office_subscriptions_deleted_by');
            $table->dropForeign('back_office_subscriptions_ibfk_1');
            $table->dropForeign('fk_back_office_subscriptions_created_by');
            $table->dropForeign('fk_back_office_subscriptions_updated_by');
        });
    }
};
