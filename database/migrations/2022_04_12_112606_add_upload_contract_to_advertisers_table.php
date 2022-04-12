<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUploadContractToAdvertisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisers', function (Blueprint $table) {
            $table->string('contract')->nullable();
            $table->string('nda')->nullable();
            $table->string('io')->nullable();
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
