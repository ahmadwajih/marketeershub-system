<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisers', function (Blueprint $table) {
            $table->id();
            // Personal Information 
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            // Business Information
            $table->integer('ho_user_id')->nullable();
            $table->string('company_name');
            $table->string('website')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->string('address')->nullable();
            $table->enum('status', ['pending', 'rejected', 'approved'])->default('pending');
            $table->boolean('exclusive')->default(false);
            $table->string('source')->nullable();
            $table->string('access_username')->nullable();
            $table->string('access_password')->nullable();
            $table->string('currency')->nullable();
            $table->string('language')->nullable();
            $table->string('validation_period')->nullable();
            $table->string('validation_type')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('advertisers');
    }
}
