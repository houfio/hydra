<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDealsTable extends Migration
{
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('valid_until')->nullable();
            $table->timestamps();
        });

        Schema::create('deal_dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deal_id');
            $table->unsignedBigInteger('dish_id');
            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
            $table->foreign('dish_id')->references('id')->on('dishes')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->integer('tax');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deal_dishes');
        Schema::dropIfExists('deals');
    }
}
