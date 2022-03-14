<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSallaAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salla_affiliates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('affiliate_id')->nullable();
            $table->string('code')->nullable();
            $table->string('marketer_name')->nullable();
            $table->string('marketer_city')->nullable();
            $table->string('commission_type')->nullable();
            $table->string('amount_amount')->nullable();
            $table->string('amount_currency')->nullable();
            $table->string('profit_amount')->nullable();
            $table->string('profit_currency')->nullable();
            $table->string('link_affiliate')->nullable();
            $table->string('link_statistics')->nullable();
            $table->string('apply_to')->nullable();
            $table->integer('visits_count')->nullable();
            $table->string('notes')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('salla_affiliates');
    }
}
