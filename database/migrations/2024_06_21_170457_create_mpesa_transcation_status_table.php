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
        Schema::create('mpesa_transcation_status', function (Blueprint $table) {
            $table->integer('id');
            $table->string('OriginatorConversationID')->nullable();
            $table->string('ConversationID')->nullable();
            $table->unsignedInteger('created_by')->nullable()->index('fk_mpesa_transcation_status_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_mpesa_transcation_status_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_mpesa_transcation_status_updated_by');
            $table->timestamps();
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
        Schema::dropIfExists('mpesa_transcation_status');
    }
};
