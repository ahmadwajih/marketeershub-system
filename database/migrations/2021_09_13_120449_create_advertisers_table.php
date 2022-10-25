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
            $table->string('company_name_ar')->nullable();
            $table->string('company_name_en')->nullable();
            $table->string('website')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->string('address')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
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
            $table->string('account_manager')->nullable();
            $table->string('orders_avg_monthly')->nullable();
            $table->string('orders_avg_size')->nullable();
            $table->string('business_full_name')->nullable();
            $table->string('business_mobile')->nullable();
            $table->string('business_industry')->nullable();
            $table->unsignedBigInteger('bank_country_id')->nullable();
            $table->foreign('bank_country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->string('bank_country')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('bank_account_title')->nullable();
            $table->string('bank_swift')->nullable();
            $table->string('iban')->nullable();
            $table->string('contract')->nullable();
            $table->string('nda')->nullable();
            $table->string('io')->nullable();
            $table->boolean('broker')->default(false);
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
