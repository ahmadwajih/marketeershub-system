<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewApiCoulmntToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nationality')->nullable()->after('owened_digital_assets');
            $table->string('previous_network')->nullable()->after('owened_digital_assets');
            $table->string('bank_country')->nullable()->after('owened_digital_assets');
            $table->string('bank_address')->nullable()->after('owened_digital_assets');
            $table->string('digital_platforms')->nullable()->after('owened_digital_assets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
