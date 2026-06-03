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
        Schema::create('tarriff_details', function (Blueprint $table) {
            $table->unsignedInteger('id')->default(0);
            $table->decimal('tarrif_from', 10);
            $table->decimal('tarrif_to', 10)->nullable();
            $table->unsignedInteger('tarrif_id')->index('tarrif_id');
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
        Schema::dropIfExists('tarriff_details');
    }
};
