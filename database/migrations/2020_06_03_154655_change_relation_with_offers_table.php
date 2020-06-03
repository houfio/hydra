<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRelationWithOffersTable extends Migration
{
    public function up()
    {
        Schema::create('order_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('set null');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->string('note')->nullable();
            $table->integer('tax');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_offers');
    }
}
