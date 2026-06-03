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
        Schema::create('product_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('product_id');
            $table->timestamp('expiry_date')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('opted_out_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_product_subscriptions_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_product_subscriptions_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_product_subscriptions_updated_by');

            $table->unique(['user_id', 'product_id'], 'unique_user_product_sub');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_subscriptions');
    }
};
