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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('invoice_id')->nullable();
            $table->text('description');
            $table->decimal('price', 10)->default(0);
            $table->integer('quantity')->default(1);
            $table->decimal('amount', 10)->default(0);
            $table->integer('team_subscription_id')->nullable();
            $table->integer('back_office_subscription_id')->nullable();
            $table->integer('branch_subscription_id')->nullable();
            $table->unsignedInteger('product_subscription_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_invoice_items_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_invoice_items_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_invoice_items_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
};
