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
        Schema::create('courier_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('courier_id')->index('courier_id');
            $table->unsignedInteger('order_id')->index('order_id');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_courier_orders_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_courier_orders_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_courier_orders_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courier_orders');
    }
};
