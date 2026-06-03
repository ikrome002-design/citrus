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
        Schema::create('refunds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_id')->index('payment_id');
            $table->decimal('amount', 10);
            $table->string('payment_type')->default('mpesa');
            $table->string('phone_number')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamp('transaction_date')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_refunds_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_refunds_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_refunds_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refunds');
    }
};
