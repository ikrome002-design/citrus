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
        Schema::create('vendor_msg', function (Blueprint $table) {
            $table->comment('');
            $table->bigIncrements('id');
            $table->string('vendor_id');
            $table->string('reply_id')->nullable();
            $table->string('msg_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('msg')->nullable();
            $table->enum('read_status', ['0', '1', '2'])->default('0');
            $table->string('status')->nullable();
            $table->dateTime('replied_at')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_msg');
    }
};
