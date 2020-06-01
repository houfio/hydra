<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoteColumnToOrderDishesTable extends Migration
{
    public function up()
    {
        Schema::table('order_dishes', function (Blueprint $table) {
            $table->string('note')->nullable();
        });
    }

    public function down()
    {
        Schema::table('order_dishes', function (Blueprint $table) {
            $table->dropColumn(['note']);
        });
    }
}
