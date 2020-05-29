<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    public function up()
    {
        Schema::create('dish_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->unique();
            $table->timestamps();
        });

        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('addition', 1);
            $table->decimal('price', 10, 2);
            $table->longText('description');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('dish_types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('order_dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('dish_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('dish_id')->references('id')->on('dishes')->onDelete('set null');
            $table->decimal('price', 10, 2);
            $table->integer('tax');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_dishes');
        Schema::dropIfExists('dishes');
        Schema::dropIfExists('dish_types');
    }
}
