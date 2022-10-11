<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferCpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_cps', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['revenue', 'payout'])->default('revenue');
            $table->enum('cps_type', ['static', 'new_old', 'slaps'])->default('static');
            $table->enum('amount_type', ['percentage', 'flat'])->default('flat');
            $table->double('amount')->nullable();
            // Date Range (Static + new old)
            $table->boolean('date_range')->default(false);
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            // Countries (Static + new old)
            $table->boolean('countries')->default(false);
            $table->text('countries_ids')->nullable();
            // New Old 
            $table->double('new_amount')->nullable();
            $table->double('old_amount')->nullable();
            // Slaps
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
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
        Schema::dropIfExists('offer_cps');
    }
}
