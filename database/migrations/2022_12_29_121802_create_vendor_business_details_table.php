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
        Schema::create('vendor_business_details', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->unsignedInteger('vendor_id')->index('vendor_business_details_vendor_id_foreign');
            $table->string('gst_no')->nullable();
            $table->string('pst_no')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('office_number')->nullable();
            $table->string('cell_number')->nullable();
            $table->integer('same_office_add')->default(0);
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_postal_code')->nullable();
            $table->string('billing_office_number')->nullable();
            $table->string('billing_cell_number')->nullable();
            $table->integer('own_by_vancouver')->default(0);
            $table->integer('head_office_vancouver')->default(0);
            $table->integer('local_community')->default(0);
            $table->integer('account_no')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account_holder')->nullable();
            $table->string('branch_address')->nullable();
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('vendor_business_details');
    }
};
