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
        Schema::create('mpesa_transcations', function (Blueprint $table) {
            $table->integer('id');
            $table->string('trans_id', 60)->nullable();
            $table->integer('business_shortcode')->nullable();
            $table->string('invoice_no')->nullable();
            $table->decimal('amount', 10)->nullable();
            $table->string('third_party_id', 1000)->nullable();
            $table->string('conversation_id')->nullable();
            $table->string('checkout_request_id')->nullable();
            $table->string('balance', 30)->nullable();
            $table->dateTime('transaction_date')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('name')->nullable();
            $table->string('status')->nullable()->default('Completed');
            $table->timestamp('date_posted')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable()->index('fk_mpesa_transcations_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_mpesa_transcations_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_mpesa_transcations_updated_by');
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
        Schema::dropIfExists('mpesa_transcations');
    }
};
