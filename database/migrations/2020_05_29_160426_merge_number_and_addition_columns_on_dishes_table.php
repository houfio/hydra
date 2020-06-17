<?php

use App\Dish;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MergeNumberAndAdditionColumnsOnDishesTable extends Migration
{
    private function mergeColumns(Collection $dishes): void
    {
        foreach ($dishes as $dish) {
            $dish->number = $dish->number . strtoupper($dish->addition);
            $dish->save();
        }
    }

    private function splitColumns(Collection $dishes): void
    {
        foreach ($dishes as $dish) {
            $number = preg_split('/[A-Z]/i', $dish->number);
            $dish->number = $number[0];
            $dish->addition = $number[1];
            $dish->save();
        }
    }

    public function up()
    {
        $dishes = Dish::all();

        Schema::table('dishes', function (Blueprint $table) {
            $table->dropColumn(['addition']);
            $table->string('number', 6)->change();
        });

        $this->mergeColumns($dishes);
    }

    public function down()
    {
        $dishes = Dish::all();

        Schema::table('dishes', function (Blueprint $table) {
            $table->dropColumn(['number']);
            $table->string('addition', 1);
        });

        Schema::table('dishes', function (Blueprint $table) {
            $table->integer('number');
            $table->string('addition', 1);
        });

        $this->splitColumns($dishes);
    }
}
