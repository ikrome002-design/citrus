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
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique('user_id');
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('business_name');
            $table->string('business_location')->nullable();
            $table->string('business_email');
            $table->unsignedInteger('business_type_id')->index('business_type_id');
            $table->string('business_role')->nullable();
            $table->text('business_about')->nullable();
            $table->string('business_logo')->nullable();
            $table->string('citrus_merchant_id')->unique('merchant_id');
            $table->decimal('balance', 50)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_merchants_created_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_merchants_updated_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_merchants_deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
};
