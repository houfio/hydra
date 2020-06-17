<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeDescriptionNullableOnDishesTable extends Migration
{
    public function up()
    {
        Schema::table('dishes', function (Blueprint $table) {
            $table->longText('description')->nullable()->change();
            $table->string('addition')->nullable()->change();
        });

        Schema::table('order_dishes', function (Blueprint $table) {
            $table->integer('quantity');
        });
    }

    public function down()
    {
        Schema::table('dishes', function (Blueprint $table) {
            $table->longText('description')->change();
            $table->string('addition')->change();
        });

        Schema::table('order_dishes', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
}
