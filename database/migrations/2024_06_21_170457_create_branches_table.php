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
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('branch_title')->nullable();
            $table->text('branch_location')->nullable();
            $table->string('citrus_branch_id')->nullable();
            $table->unsignedInteger('merchant_id')->index('shops_merchant_id_foreign');
            $table->text('branch_logo')->nullable();
            $table->timestamps();
            $table->boolean('show_products')->default(true);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable()->index('fk_branches_created_by');
            $table->unsignedInteger('deleted_by')->nullable()->index('fk_branches_deleted_by');
            $table->unsignedInteger('updated_by')->nullable()->index('fk_branches_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
