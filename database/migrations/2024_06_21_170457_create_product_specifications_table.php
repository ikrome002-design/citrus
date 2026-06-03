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
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->unsignedInteger('id')->default(0);
            $table->string('street_address');
            $table->unsignedInteger('town_id');
            $table->unsignedInteger('user_id');
            $table->boolean('address_is_active')->default(true);
            $table->string('address_phone_number')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_specifications');
    }
};
