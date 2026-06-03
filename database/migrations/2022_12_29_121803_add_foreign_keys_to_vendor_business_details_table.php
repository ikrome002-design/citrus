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
        Schema::table('vendor_business_details', function (Blueprint $table) {
            $table->foreign(['vendor_id'])->references(['id'])->on('vendors')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_business_details', function (Blueprint $table) {
            $table->dropForeign('vendor_business_details_vendor_id_foreign');
        });
    }
};
