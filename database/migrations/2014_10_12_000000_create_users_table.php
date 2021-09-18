<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Main Information
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('years_of_experience');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->string('city');
            $table->enum('gender', ['male','female','other'])->default('male');
            $table->enum('team', ['admin','media_buying', 'influencer', 'affiliate'])->default('affiliate');
            $table->enum('position', ['super_admin','head', 'account_manager', 'publisher'])->default('publisher');
            // Connection Information
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('skype')->nullable();
            // Affiliate Information
            $table->string('traffic_sources')->nullable();
            $table->string('affiliate_networks')->nullable();
            $table->string('owened_digital_assets')->nullable();
            //Payment Information
            $table->string('account_title')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch_code')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('iban')->nullable();
            $table->string('currency')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
