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
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket_no')->unique('ticket_id');
            $table->unsignedInteger('user_id')->index('user_id');
            $table->string('ticket_subject');
            $table->enum('ticked_status', ['open', 'in_progress', 'closed'])->nullable()->default('open');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_tickets_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_tickets_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_tickets_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
