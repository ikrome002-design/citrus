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
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('varies_by');
            $table->integer('base_weight')->default(0);
            $table->integer('base_volume')->default(0);
            $table->decimal('extra_price_per_weight', 10)->default(0);
            $table->decimal('extra_price_per_volume', 10)->default(0);
            $table->decimal('free_shipping_start_price', 10)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_shipping_zones_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_shipping_zones_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_shipping_zones_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_zones');
    }
};
