<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exchange');
            $table->string('url');
            $table->integer('interval');
            $table->string('second_url')->nullable();
            $table->integer('type');
            $table->string('symbol_para')->nullable();
            $table->string('ticker_para')->nullable();
            $table->string('bid_para');
            $table->string('ask_para');
            $table->string('btcusd_para')->nullable();
            $table->string('ethusd_para')->nullable();
            $table->string('xrpusd_para')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickers');
    }
}
