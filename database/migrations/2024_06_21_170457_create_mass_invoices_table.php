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
        Schema::create('mass_invoices', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('mass_invoice_no')->nullable();
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
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('duedate')->nullable();
            $table->timestamp('datepaid')->nullable();
            $table->enum('status', ['unpaid', 'paid', 'partially_paid', 'cancelled'])->nullable()->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->integer('tax_type')->nullable()->default(0);
            $table->decimal('tax_amount', 10)->nullable()->default(0);
            $table->integer('discount_type')->nullable()->default(0);
            $table->decimal('discount_amt', 10)->nullable()->default(0);
            $table->unsignedInteger('deleted_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('mass_invoices');
    }
};
