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
        Schema::create('business_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_business_types_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_business_types_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_business_types_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_types');
    }
};
