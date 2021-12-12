<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertiserCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertiser_advertiser_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertiser_category_id');
            $table->foreign('advertiser_category_id')->references('id')->on('advertiser_categories')->onDelete('cascade');
            $table->unsignedBigInteger('advertiser_id');
            $table->foreign('advertiser_id')->references('id')->on('advertisers')->onDelete('cascade');
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
        Schema::dropIfExists('advertiser_advertiser_category');
    }
}
