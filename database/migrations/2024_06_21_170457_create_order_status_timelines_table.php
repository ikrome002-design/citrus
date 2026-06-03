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
        Schema::create('order_status_timelines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->index('order_id');
            $table->string('status');
            $table->timestamp('status_date')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_order_statuses_created_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_order_statuses_updated_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_order_statuses_deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status_timelines');
    }
};
