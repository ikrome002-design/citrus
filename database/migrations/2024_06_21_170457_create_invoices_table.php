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
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no')->nullable()->unique('invoice_no');
            $table->unsignedInteger('mass_invoice_id')->nullable();
            $table->unsignedInteger('order_item_id')->nullable()->index('order_item_id');
            $table->integer('quantity')->nullable()->default(1);
            $table->decimal('price', 10);
            $table->decimal('subtotal', 10)->default(0);
            $table->decimal('amount', 10)->nullable()->default(0);
            $table->decimal('discount', 10)->nullable()->default(0);
            $table->decimal('tax', 10)->default(0);
            $table->decimal('total', 10)->default(0);
            $table->string('description')->nullable();
            $table->decimal('transaction_fee', 10)->nullable();
            $table->decimal('trans_amount', 10)->nullable();
            $table->unsignedInteger('user_id')->index('user_id');
            $table->unsignedInteger('created_by')->nullable()->index('fk_invoices_created_by');
            $table->timestamp('duedate')->nullable();
            $table->timestamp('datepaid')->nullable();
            $table->enum('status', ['Unpaid', 'Paid', 'Partially Paid', 'Cancelled'])->nullable()->default('Unpaid');
            $table->enum('bill_created', ['Yes', 'No'])->nullable()->default('No');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->integer('tax_type')->nullable()->default(0);
            $table->decimal('tax_amount', 10)->nullable()->default(0);
            $table->integer('discount_type')->nullable()->default(0);
            $table->decimal('discount_amt', 10)->nullable()->default(0);
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_invoices_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_invoices_updated_by');
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
        Schema::dropIfExists('invoices');
    }
};
