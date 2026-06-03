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
        Schema::create('tarriffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index('created_by');
            $table->unsignedInteger('updated_by')->nullable()->index('updated_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarriffs');
    }
};
