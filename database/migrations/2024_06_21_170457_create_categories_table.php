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
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_active')->default(true);
            $table->string('name')->unique();
            $table->string('slug')->unique('slug');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->unsignedInteger('parent_id')->nullable()->index('categories__lft__rgt_parent_id_index');
            $table->unsignedInteger('created_by')->nullable()->index('categories_created_by_foreign');
            $table->unsignedInteger('updated_by')->nullable()->index('categories_updated_by_foreign');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_categories_deleted_by');
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
        Schema::dropIfExists('categories');
    }
};
