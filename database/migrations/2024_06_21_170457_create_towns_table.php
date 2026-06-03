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
        Schema::create('towns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('county_id')->index('county_id');
            $table->string('name');
            $table->unsignedInteger('shipping_zone_id')->index('shipping_zone_id');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_towns_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_towns_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_towns_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('towns');
    }
};
