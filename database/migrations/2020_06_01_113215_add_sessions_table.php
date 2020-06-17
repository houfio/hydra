<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('table');
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
