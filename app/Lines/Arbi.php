<?php

namespace App\Lines;

use Illuminate\Support\Facades\Redis;
use Line;
use App\Ticker;

class Arbi
{
    public function Arbitrage()
    {
        $orderbooks = json_decode(Redis::get('orderbook'));
        $forex = Redis::get('THB');
        // dd($orderbooks);
        $worldwide = array();
        $worldwide['btc']['bid']['price'] = null;
        $worldwide['btc']['ask']['price'] = null;
        $worldwide['eth']['bid']['price'] = null;
        $worldwide['eth']['ask']['price'] = null;
        foreach ($orderbooks as $key => $orderbook) {
            if ($worldwide['btc']['bid']['price'] > $orderbook->btcusd->ask || is_null($worldwide['btc']['bid']['price'])) {
                $worldwide['btc']['bid']['price'] = $orderbook->btcusd->ask;
                $worldwide['btc']['bid']['exchange'] = $key;
            }
            if ($worldwide['btc']['ask']['price'] < $orderbook->btcusd->bid || is_null($worldwide['btc']['ask']['price'])) {
                $worldwide['btc']['ask']['price'] = $orderbook->btcusd->bid;
                $worldwide['btc']['ask']['exchange'] = $key;
            }
            if ($worldwide['eth']['bid']['price'] > $orderbook->ethusd->ask || is_null($worldwide['eth']['bid']['price'])) {
                $worldwide['eth']['bid']['price'] = $orderbook->ethusd->ask;
                $worldwide['eth']['bid']['exchange'] = $key;
            }
            if ($worldwide['eth']['ask']['price'] < $orderbook->ethusd->bid || is_null($worldwide['eth']['ask']['price'])) {
                $worldwide['eth']['ask']['price'] = $orderbook->ethusd->bid;
                $worldwide['eth']['ask']['exchange'] = $key;
            }
        }
        $worldwide['btc']['profit'] = ($worldwide['btc']['ask']['price'] - $worldwide['btc']['bid']['price'])/$worldwide['btc']['bid']['price']*100;
        $worldwide['eth']['profit'] = ($worldwide['eth']['ask']['price'] - $worldwide['eth']['bid']['price'])/$worldwide['eth']['bid']['price']*100;
        // dd($worldwide);

        $thailand = array();
        $thailand['btc']['bid']['price'] = null;
        $thailand['btc']['ask']['price'] = null;
        $thailand['eth']['bid']['price'] = null;
        $thailand['eth']['ask']['price'] = null;
        foreach ($orderbooks as $key => $orderbook) {
            $is_thai = (Ticker::where('exchange', $key)->first()->ticker_para == 'thai');
            
            if ($is_thai) {
                if ($thailand['btc']['bid']['price'] > $orderbook->btcusd->ask || is_null($thailand['btc']['bid']['price'])) {
                    $thailand['btc']['bid']['price'] = $orderbook->btcusd->ask;
                    $thailand['btc']['bid']['exchange'] = $key;
                }
                if ($thailand['btc']['ask']['price'] < $orderbook->btcusd->bid || is_null($thailand['btc']['ask']['price'])) {
                    $thailand['btc']['ask']['price'] = $orderbook->btcusd->bid;
                    $thailand['btc']['ask']['exchange'] = $key;
                }
                if ($thailand['eth']['bid']['price'] > $orderbook->ethusd->ask || is_null($thailand['eth']['bid']['price'])) {
                    $thailand['eth']['bid']['price'] = $orderbook->ethusd->ask;
                    $thailand['eth']['bid']['exchange'] = $key;
                }
                if ($thailand['eth']['ask']['price'] < $orderbook->ethusd->bid || is_null($thailand['eth']['ask']['price'])) {
                    $thailand['eth']['ask']['price'] = $orderbook->ethusd->bid;
                    $thailand['eth']['ask']['exchange'] = $key;
                }
            }
        }
        $thailand['btc']['profit'] = ($thailand['btc']['ask']['price'] - $thailand['btc']['bid']['price'])/$thailand['btc']['bid']['price']*100-0.5;
        $thailand['eth']['profit'] = ($thailand['eth']['ask']['price'] - $thailand['eth']['bid']['price'])/$thailand['eth']['bid']['price']*100-0.5;
        // dd($thailand);

        $response = "Arbitrage (ตลาดไทย):";
        $response .= "\r\n---  Bitcoin  --- ";
        $response .= "\r\nถูกที่สุด (". $thailand['btc']['bid']['exchange'] ."): ฿".number_format($thailand['btc']['bid']['price']*$forex, 2);
        $response .= "\r\nแพงที่สุด (". $thailand['btc']['ask']['exchange'] ."): ฿".number_format($thailand['btc']['ask']['price']*$forex, 2);
        $response .= "\r\nกำไร: ". round($thailand['btc']['profit'], 2)."%";
        $response .= "\r\n---  Ethereum  --- ";
        $response .= "\r\nถูกที่สุด (". $thailand['eth']['bid']['exchange'] ."): ฿".number_format($thailand['eth']['bid']['price']*$forex, 2);
        $response .= "\r\nแพงที่สุด (". $thailand['eth']['ask']['exchange'] ."): ฿".number_format($thailand['eth']['ask']['price']*$forex, 2);
        $response .= "\r\nกำไร: ". round($thailand['eth']['profit'], 2)."%";
        $response .= "\r\n_________________________________";
        $response .= "\r\n\r\nArbitrage (International):";
        $response .= "\r\n---  Bitcoin  --- ";
        $response .= "\r\nถูกที่สุด (". $worldwide['btc']['bid']['exchange'] ."): $".number_format($worldwide['btc']['bid']['price'], 2);
        $response .= "\r\nแพงที่สุด (". $worldwide['btc']['ask']['exchange'] ."): $".number_format($worldwide['btc']['ask']['price'], 2);
        $response .= "\r\nกำไร: ". round($worldwide['btc']['profit'], 2)."%";
        $response .= "\r\n---  Ethereum  --- ";
        $response .= "\r\nถูกที่สุด (". $worldwide['eth']['bid']['exchange'] ."): $".number_format($worldwide['eth']['bid']['price'], 2);
        $response .= "\r\nแพงที่สุด (". $worldwide['eth']['ask']['exchange'] ."): $".number_format($worldwide['eth']['ask']['price'], 2);
        $response .= "\r\nกำไร: ". round($worldwide['eth']['profit'], 2)."%";
        $response .= "\r\n\r\nเพิ่มเติม: https://cryptovationx.io";

        Line::pushText('Ua2b3dd43fdfaf129015087ee98896a5a', $response);
    }
}
