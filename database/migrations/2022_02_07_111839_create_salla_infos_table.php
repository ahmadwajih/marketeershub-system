<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSallaInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salla_infos', function (Blueprint $table) {
            $table->id();
            // Store Authrization Info
            $table->string('access_token')->nullable();
            $table->integer('expires_in')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('scope')->nullable();
            $table->string('token_type')->nullable();
            // User Info 
            $table->integer('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('role')->nullable();
            // Store Info
            $table->integer('store_id')->nullable();
            $table->integer('owner_id')->nullable();
            $table->string('username')->nullable();
            $table->string('store_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('plan')->nullable();
            $table->string('status')->nullable();
            $table->string('domain')->nullable();
            $table->string('subscribed_at')->nullable();
            // Selected Offer
            $table->unsignedBigInteger('offer_id')->nullable();
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
        Schema::dropIfExists('salla_infos');
    }
}
