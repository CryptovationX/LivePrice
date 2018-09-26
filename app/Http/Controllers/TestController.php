<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tickers\TickerRedis;
use App\Tickers\TickerAPI;
use Line;
use Arbi;

class TestController extends Controller
{
    public function test($id)
    {
        $controller = new TickerAPI;
        // $controller->getData($id, 'btcusd_para');
        $controller->forexRedis();
        // $controller->forex();

        // $controller = new TickerRedis;
        // $controller->merge();
        // $result = $controller->appendorderbook();
        // dd($result);
    }

    public function line()
    {
        Line::pushText('Ua2b3dd43fdfaf129015087ee98896a5a', 'hi');
    }

    public function arbi()
    {
        Arbi::Arbitrage();
        // Line::pushText('Ua2b3dd43fdfaf129015087ee98896a5a', 'hi');
    }

    public function price()
    {
        Arbi::Price();
    }
}
