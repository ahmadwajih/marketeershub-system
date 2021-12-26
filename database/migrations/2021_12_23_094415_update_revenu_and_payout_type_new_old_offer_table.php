<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRevenuAndPayoutTypeNewOldOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_old_offer', function (Blueprint $table) {
            $table->enum('new_revenue_type', ['flat', 'percentage'])->default('flat')->after('old_revenue');
            $table->enum('new_payout_type', ['flat', 'percentage'])->default('flat')->after('old_revenue');
            $table->enum('old_revenue_type', ['flat', 'percentage'])->default('flat')->after('old_revenue');
            $table->enum('old_payout_type', ['flat', 'percentage'])->default('flat')->after('old_revenue');
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
