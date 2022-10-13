<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCpsColumnsToOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->enum('revenue_cps_type', ['static', 'new_old', 'slaps'])->default('static')->after('currency_id');
            $table->enum('revenue_type', ['percentage', 'flat'])->default('flat')->after('revenue_cps_type');
            $table->enum('payout_cps_type', ['static', 'new_old', 'slaps'])->default('static')->after('revenue_type');
            $table->enum('payout_type', ['percentage', 'flat'])->default('flat')->after('payout_cps_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            //
        });
    }
}
