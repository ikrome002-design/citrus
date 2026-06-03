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
        Schema::create('sociallinks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('link')->nullable();
            $table->unsignedInteger('merchant_id')->index('sociallinks_merchant_id_foreign');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index('fk_sociallinks_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_sociallinks_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_sociallinks_updated_by');
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
        Schema::dropIfExists('sociallinks');
    }
};
