<?php

namespace App\Tickers;

use App\Ticker;
use Illuminate\Support\Facades\Redis;
use App\Events\OrderbookOmit;
use App\Forex;

class TickerRedis
{
    public function merge()
    {
        $tickers = Ticker::all();
        foreach ($tickers as $key => $ticker) {
            if ($ticker->seperate == 1) {
                $key++;
                $btc = json_decode(Redis::get('ticker'.$key.'btc'));
                $eth = json_decode(Redis::get('ticker'.$key.'eth'));
                $xrp = json_decode(Redis::get('ticker'.$key.'xrp'));
                $merged = array_merge((array) $btc, (array) $eth, (array) $xrp);
                Redis::set('ticker'.$key, json_encode($merged));
            }
        }
    }

    public function appendorderbook()
    {
        $tickers = Ticker::all();
        foreach ($tickers as $key => $ticker) {
            if ($ticker->seperate == 1) {
                $key++;
                $btc = json_decode(Redis::get('ticker'.$key.'btc'));
                $eth = json_decode(Redis::get('ticker'.$key.'eth'));
                $xrp = json_decode(Redis::get('ticker'.$key.'xrp'));
                $merged = array_merge((array) $btc, (array) $eth, (array) $xrp);
                Redis::set('ticker'.$key, json_encode($merged));
            }
        }

        $orderbooks = array();
        foreach ($tickers as $key => $ticker) {
            $orderbooks[$ticker->exchange] = json_decode(Redis::get('ticker'.($key + 1)));
        }

        $json = json_encode($orderbooks);

        Redis::set('orderbook', $json);

        $result = event(new OrderbookOmit($json));

        return $result;
    }

    public function forexRedis()
    {
        $data = Forex::find(1);
        Redis::set('THB', $data['THB']);
        Redis::set('INR', $data['INR']);
        Redis::set('KRW', $data['KRW']);
        Redis::set('TRY', $data['TRY']);
    }

}
