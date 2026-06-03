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
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id')->nullable()->index('order_id');
            $table->string('invoice_no')->nullable()->index('invoice_no');
            $table->string('payment_method')->nullable()->default('mpesa');
            $table->string('phone_number')->nullable();
            $table->integer('name');
            $table->string('transaction_id')->nullable();
            $table->timestamp('transaction_date')->useCurrent();
            $table->string('payment_status')->nullable()->default('pending');
            $table->decimal('amount', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_payments_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_payments_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_payments_updated_by');

            $table->index(['invoice_no'], 'invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
