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
        Schema::table('back_office_plans', function (Blueprint $table) {
            $table->foreign(['created_by'], 'fk_back_office_plans_created_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['updated_by'], 'fk_back_office_plans_updated_by')->references(['id'])->on('users')->onDelete('SET NULL');
            $table->foreign(['account_type_id'], 'back_office_plans_ibfk_1')->references(['id'])->on('account_types');
            $table->foreign(['deleted_by'], 'fk_back_office_plans_deleted_by')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('back_office_plans', function (Blueprint $table) {
            $table->dropForeign('fk_back_office_plans_created_by');
            $table->dropForeign('fk_back_office_plans_updated_by');
            $table->dropForeign('back_office_plans_ibfk_1');
            $table->dropForeign('fk_back_office_plans_deleted_by');
        });
    }
};
