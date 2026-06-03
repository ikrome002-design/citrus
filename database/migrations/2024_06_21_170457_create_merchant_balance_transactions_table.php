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
        Schema::create('merchant_balance_transactions', function (Blueprint $table) {
            $table->unsignedInteger('id')->default(0);
            $table->unsignedInteger('order_item_id')->nullable()->index('order_item_id');
            $table->unsignedInteger('merchant_id')->index('merchant_id');
            $table->decimal('amount', 20);
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index('created_by');
            $table->unsignedInteger('updated_by')->nullable()->index('updated_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_balance_transactions');
    }
};
