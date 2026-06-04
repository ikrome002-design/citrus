<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {

            $table->string('product_type')->nullable(); 
            $table->string('taxable')->nullable(); 
            $table->string('flat_rate')->nullable(); 
            $table->string('flat_amount')->nullable(); 
            $table->unsignedInteger('vendor_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->foreign('vendor_id')
                  ->references('id')
                  ->on('vendors');
            $table->foreign('created_by')
                  ->references('id')
                  ->on('employees');
            $table->foreign('updated_by')
                  ->references('id')
                  ->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_type');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('taxable');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('flat_rate');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('flat_amount');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });
    }
}
