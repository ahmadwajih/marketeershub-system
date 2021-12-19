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
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            // Business Information
            $table->integer('ho_user_id')->nullable();
            $table->string('company_name_ar');
            $table->string('company_name_en');
            $table->string('website')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->string('address')->nullable();
            $table->enum('status', ['active', 'unactive'])->default('unactive');
            $table->boolean('exclusive')->default(false);
            $table->string('access_username')->nullable();
            $table->string('access_password')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
            // Validation options
            $table->enum('language', ['ar', 'en', 'ar_en'])->default('ar');
            $table->string('validation_source')->nullable();
            $table->string('validation_duration')->nullable();
            $table->enum('validation_type',['system', 'sheet', 'manual_report_via_email'])->default('sheet');
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
