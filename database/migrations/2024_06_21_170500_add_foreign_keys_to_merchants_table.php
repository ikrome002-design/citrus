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
        Schema::table('merchants', function (Blueprint $table) {
            $table->foreign(['deleted_by'], 'fk_merchants_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['business_type_id'], 'merchants_ibfk_1')->references(['id'])->on('business_types')->onDelete('CASCADE');
            $table->foreign(['created_by'], 'fk_merchants_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_merchants_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['user_id'], 'merchants_ibfk_2')->references(['id'])->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropForeign('fk_merchants_deleted_by');
            $table->dropForeign('merchants_ibfk_1');
            $table->dropForeign('fk_merchants_created_by');
            $table->dropForeign('fk_merchants_updated_by');
            $table->dropForeign('merchants_ibfk_2');
        });
    }
};
