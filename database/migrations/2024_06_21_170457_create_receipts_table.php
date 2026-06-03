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
        Schema::create('receipts', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('receipt_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('order_no')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('description', 191)->nullable();
            $table->date('datepaid')->nullable();
            $table->decimal('amount', 10)->nullable();
            $table->decimal('subtotal', 10);
            $table->decimal('discount', 10);
            $table->decimal('tax', 10);
            $table->decimal('total', 10);
            $table->decimal('trans_amount', 10)->nullable();
            $table->decimal('transaction_fee', 10)->nullable();
            $table->enum('type', ['Single', 'Mass']);
            $table->string('pmethod', 30)->default('MPESA');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index('fk_receipts_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_receipts_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_receipts_updated_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
};
