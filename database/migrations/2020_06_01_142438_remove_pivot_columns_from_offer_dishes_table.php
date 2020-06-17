<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePivotColumnsFromOfferDishesTable extends Migration
{
    public function up()
    {
        Schema::table('offer_dishes', function (Blueprint $table) {
            $table->dropColumn(['price', 'tax']);
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->integer('tax');
            $table->decimal('price', 10, 2);
        });
    }

    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['price', 'tax']);
        });

        Schema::table('offer_dishes', function (Blueprint $table) {
            $table->decimal('price', 10, 2);
            $table->integer('tax');
        });
    }
}
