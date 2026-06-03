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
        Schema::create('memberships', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->text('name')->nullable();
            $table->decimal('price')->nullable();
            $table->text('package_expire')->nullable();
            $table->decimal('monthly_initial_price')->nullable();
            $table->decimal('monthly_recurring_price')->nullable();
            $table->decimal('yearly_initial_price')->nullable();
            $table->decimal('yearly_recurring_price')->nullable();
            $table->integer('tax_id')->nullable();
            $table->text('quantity')->nullable();
            $table->integer('display_product')->nullable();
            $table->integer('purchase_product')->nullable();
            $table->text('description')->nullable();
            $table->text('feature_list')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memberships');
    }
};
