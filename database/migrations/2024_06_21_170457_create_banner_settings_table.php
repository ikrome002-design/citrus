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
        Schema::create('banner_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_banner_settings_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_banner_settings_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_banner_settings_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_settings');
    }
};
