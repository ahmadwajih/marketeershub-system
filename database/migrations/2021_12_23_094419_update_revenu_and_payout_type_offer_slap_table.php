<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRevenuAndPayoutTypeOfferSlapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer_slap', function (Blueprint $table) {
            $table->enum('payout_type', ['flat', 'percentage'])->default('flat')->after('to');
            $table->enum('revenue_type', ['flat', 'percentage'])->default('flat')->after('to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
