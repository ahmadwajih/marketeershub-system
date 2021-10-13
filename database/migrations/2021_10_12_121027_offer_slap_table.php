<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OfferSlapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_slap', function (Blueprint $table) {
            $table->id();
            $table->enum('slap_type', ['number_of_orders', 'ammount_of_orders'])->default('number_of_orders');
            $table->integer('from');
            $table->integer('to');
            $table->float('payout');
            $table->float('revenue');
            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_slap');
    }
}
