<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTaxFromOffersTable extends Migration
{
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('tax');
        });
    }

    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->integer('tax');
        });
    }
}
