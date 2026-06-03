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
        Schema::create('counties', function (Blueprint $table) {
            $table->increments('id');
            $table->char('county_code', 5);
            $table->text('county_name');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_counties_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_counties_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_counties_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counties');
    }
};
