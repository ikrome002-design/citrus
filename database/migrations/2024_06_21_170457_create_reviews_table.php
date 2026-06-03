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
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index('fk_testimonials_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_testimonials_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_testimonials_updated_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
