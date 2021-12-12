<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            // Offer Details 
            $table->integer('offer_id')->nullable();
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('website')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('offer_url');
            $table->string('category')->nullable();
            $table->enum('type', ['coupon_tracking', 'link_tracking'])->default('coupon_tracking');
            $table->enum('discount_type', ['flat', 'percentage'])->default('percentage');
            $table->float('discount')->default(0);
            $table->enum('payout_type', ['cps_flat', 'cps_percentage', 'cpa', 'cpl', 'cpc'])->default('cps_flat');
            $table->enum('cps_type', ['static', 'new_old', 'slaps'])->default('static');
            $table->float('payout')->nullable();
            $table->float('revenue')->nullable();
            $table->float('percent_payout')->nullable();
            $table->enum('status', ['active', 'pused', 'pending', 'expire'])->default('pending');
            $table->date('expire_date');
            $table->text('note_ar')->nullable();
            $table->text('note_en')->nullable();
            $table->text('terms_and_conditions_ar')->nullable();
            $table->text('terms_and_conditions_en')->nullable();
            $table->unsignedBigInteger('advertiser_id')->nullable();
            $table->foreign('advertiser_id')->references('id')->on('advertisers')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
