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
        Schema::create('mpesa_validation', function (Blueprint $table) {
            $table->integer('id');
            $table->string('third_party_id', 1000)->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('trans_id')->nullable();
            $table->dateTime('trans_time')->nullable();
            $table->decimal('amount', 10)->nullable();
            $table->string('business_shortcode')->nullable();
            $table->string('bill_ref_number')->nullable();
            $table->decimal('balance', 10)->nullable();
            $table->string('phone_number')->nullable();
            $table->string('name')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable()->index('fk_mpesa_validation_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_mpesa_validation_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_mpesa_validation_updated_by');
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
        Schema::dropIfExists('mpesa_validation');
    }
};
