<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tickers\TickerRedis;
use App\Tickers\TickerAPI;

class TestController extends Controller
{
    public function test($id)
    {
        $controller = new TickerAPI;
        $controller->getData($id);

        // $controller = new TickerRedis;
        // $controller->merge();
        // $result = $controller->appendorderbook();
        // dd($result);
    }
}
