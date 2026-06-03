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
        Schema::create('plan_in', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->integer('plan_id')->nullable();
            $table->integer('vendor_id');
            $table->string('staff_id')->nullable();
            $table->decimal('price')->default(0);
            $table->timestamp('expiry_date')->nullable();
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
        Schema::dropIfExists('plan_in');
    }
};
