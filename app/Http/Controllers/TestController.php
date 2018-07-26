<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tickers\TickerRedis;
use App\Tickers\TickerAPI;

class TestController extends Controller
{
    public function test()
    {
        // $controller = new TickerAPI;
        // $controller->getData(15, 'btcusd_para');

        $controller = new TickerRedis;
        // $controller->merge();
        $result = $controller->appendorderbook();
        dd($result);
    }
}
