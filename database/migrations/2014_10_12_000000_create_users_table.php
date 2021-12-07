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
            $table->integer('ho_id')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('gender', ['male','female','other'])->default('male');
            $table->enum('team', ['management','digital_operation', 'finance','media_buying', 'influencer', 'affiliate', 'prepaid'])->default('affiliate');
            $table->enum('position', ['super_admin','head','team_leader', 'account_manager', 'publisher', 'employee'])->default('publisher');
            $table->enum('status', ['active','pending', 'closed'])->default('pending');
            $table->string('category')->nullable();
            $table->string('referral_account_manager')->nullable();
            // Connection Information
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            // Affiliate Information
            $table->string('traffic_sources')->nullable();
            $table->text('affiliate_networks')->nullable();
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
        Schema::dropIfExists('users');
    }
}
