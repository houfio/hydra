<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDealToOffer extends Migration
{
    public function up()
    {
        Schema::table('deal_dishes', function (Blueprint $table) {
            $table->dropForeign(['deal_id']);
        });

        Schema::rename('deals', 'offers');
        Schema::rename('deal_dishes', 'offer_dishes');

        Schema::table('offer_dishes', function (Blueprint $table) {
            $table->renameColumn('deal_id', 'offer_id');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::rename('offers', 'deals');
        Schema::rename('offer_dishes', 'deal_dishes');
    }
}
