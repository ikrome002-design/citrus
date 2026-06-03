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
        Schema::create('team_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->decimal('price', 10)->nullable()->default(0);
            $table->decimal('transaction_fee', 10)->nullable()->default(0);
            $table->enum('discount_type', ['fixed', 'percent'])->nullable();
            $table->enum('apply_discount', ['one_time', 'recurring', 'first_purchase'])->nullable();
            $table->decimal('discount_amount', 12)->nullable();
            $table->enum('govt_charges_type', ['fixed', 'percent'])->nullable();
            $table->enum('apply_govt_charges', ['tax', 'other_charges'])->nullable();
            $table->decimal('govt_charges_amt', 12)->nullable();
            $table->integer('account_type_id')->nullable()->unique('account_type_id');
            $table->decimal('discount', 10);
            $table->decimal('tax', 10);
            $table->decimal('trans_amount', 10);
            $table->integer('total')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_team_plans_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_team_plans_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_team_plans_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_plans');
    }
};
