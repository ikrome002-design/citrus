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
        Schema::create('vendorplan_info', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->integer('plan_id')->nullable();
            $table->string('plan_name')->nullable();
            $table->integer('vendor_id');
            $table->integer('staff_id');
            $table->decimal('price')->default(0);
            $table->date('date');
            $table->date('expiry_date');
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
        Schema::dropIfExists('vendorplan_info');
    }
};
