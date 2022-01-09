<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewApiColumnsToAdvertisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisers', function (Blueprint $table) {
            $table->string('account_manager')->nullable()->after('note');
            $table->string('orders_avg_monthly')->nullable()->after('note');
            $table->string('orders_avg_size')->nullable()->after('note');
            $table->string('business_full_name')->nullable()->after('note');
            $table->string('business_mobile')->nullable()->after('note');
            $table->string('business_industry')->nullable()->after('note');
            $table->unsignedBigInteger('bank_country_id')->nullable()->after('note');
            $table->foreign('bank_country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->string('bank_country')->nullable()->after('note');
            $table->string('bank_address')->nullable()->after('note');
            $table->string('bank_account_title')->nullable()->after('note');
            $table->string('bank_swift')->nullable()->after('note');
            $table->string('iban')->nullable()->after('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertisers', function (Blueprint $table) {
            //
        });
    }
}
