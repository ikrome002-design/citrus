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
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_active')->default(false);
            $table->string('title')->nullable();
            $table->string('description');
            $table->longText('content')->nullable();
            $table->string('slug')->nullable()->unique('slug');
            $table->text('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_blogs_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_blogs_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_blogs_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
