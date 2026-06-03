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
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street_address');
            $table->unsignedInteger('town_id')->index('town_id');
            $table->unsignedInteger('user_id')->index('user_id');
            $table->boolean('address_is_active')->default(true);
            $table->string('address_phone_number')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index('fk_addresses_created_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_addresses_updated_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_addresses_deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
