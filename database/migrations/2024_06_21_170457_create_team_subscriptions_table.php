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
        Schema::create('team_subscriptions', function (Blueprint $table) {
            $table->unsignedInteger('id')->default(0);
            $table->unsignedInteger('merchant_id')->index('merchant_id');
            $table->unsignedInteger('team_plan_id')->index('team_plan_id');
            $table->timestamp('expiry_date')->nullable();
            $table->integer('members');
            $table->timestamp('opted_out_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_team_subscriptions_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_team_subscriptions_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_team_subscriptions_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_subscriptions');
    }
};
