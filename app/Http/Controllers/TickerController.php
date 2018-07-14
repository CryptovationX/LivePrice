<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticker;
use App\Jobs\onesecJobDispatcher;
use Illuminate\Support\Facades\Redis;

class TickerController extends Controller
{
    public function test()
    {
        onesecJobDispatcher::dispatch();
    }

    public function getData($id)
    {
        $result = array();
        $data = Ticker::find($id);
        $json = file_get_contents($data->url);
        $tickers = json_decode($json);
        // dd($tickers);
        switch ($data->type) {
            case 1:
                foreach ($tickers as $key => $ticker) {
                    if ($ticker->{$data->symbol_para} == $data->btcusd_para) {
                        $result['btcusd']['bid'] = $ticker->{$data->bid_para};
                        $result['btcusd']['ask'] = $ticker->{$data->ask_para};
                    }
                    if ($ticker->{$data->symbol_para} == $data->ethusd_para) {
                        $result['ethusd']['bid'] = $ticker->{$data->bid_para};
                        $result['ethusd']['ask'] = $ticker->{$data->ask_para};
                    }
                    if ($ticker->{$data->symbol_para} == $data->xrpusd_para) {
                        $result['xrpusd']['bid'] = $ticker->{$data->bid_para};
                        $result['xrpusd']['ask'] = $ticker->{$data->ask_para};
                    }
                }
                break;
            
            case 2:
                foreach ($tickers->{$data->ticker_para} as $key => $ticker) {
                    if ($ticker->{$data->symbol_para} == $data->btcusd_para) {
                        $result['btcusd']['bid'] = $ticker->{$data->bid_para};
                        $result['btcusd']['ask'] = $ticker->{$data->ask_para};
                    }
                    if ($ticker->{$data->symbol_para} == $data->ethusd_para) {
                        $result['ethusd']['bid'] = $ticker->{$data->bid_para};
                        $result['ethusd']['ask'] = $ticker->{$data->ask_para};
                    }
                    if ($ticker->{$data->symbol_para} == $data->xrpusd_para) {
                        $result['xrpusd']['bid'] = $ticker->{$data->bid_para};
                        $result['xrpusd']['ask'] = $ticker->{$data->ask_para};
                    }
                }
                break;

            case 3:
                $result['btcusd']['bid'] = $tickers->{1}->orderbook->bids->highbid;
                $result['btcusd']['ask'] = $tickers->{1}->orderbook->asks->highbid;
                $result['ethusd']['bid'] = $tickers->{21}->orderbook->bids->highbid;
                $result['ethusd']['ask'] = $tickers->{21}->orderbook->asks->highbid;
                $result['xrpusd']['bid'] = $tickers->{25}->orderbook->bids->highbid;
                $result['xrpusd']['ask'] = $tickers->{25}->orderbook->asks->highbid;
                break;
            case 4:
                $result['btcusd']['bid'] = $tickers->result->XXBTZUSD->b[0];
                $result['btcusd']['ask'] = $tickers->result->XXBTZUSD->a[0];
                $result['ethusd']['bid'] = $tickers->result->XETHZUSD->b[0];
                $result['ethusd']['ask'] = $tickers->result->XETHZUSD->a[0];
                $result['xrpusd']['bid'] = $tickers->result->XXRPZUSD->b[0];
                $result['xrpusd']['ask'] = $tickers->result->XXRPZUSD->a[0];
                break;
            case 5:
                $result['btcusd']['bid'] = $tickers->{$data->btcusd_para}->{$data->bid_para};
                $result['btcusd']['ask'] = $tickers->{$data->btcusd_para}->{$data->ask_para};
                $result['ethusd']['bid'] = $tickers->{$data->ethusd_para}->{$data->bid_para};
                $result['ethusd']['ask'] = $tickers->{$data->ethusd_para}->{$data->ask_para};
                $result['xrpusd']['bid'] = $tickers->{$data->xrpusd_para}->{$data->bid_para};
                $result['xrpusd']['ask'] = $tickers->{$data->xrpusd_para}->{$data->ask_para};
                break;
            case 6:
                $result['btcusd']['bid'] = $tickers[0][1];
                $result['btcusd']['ask'] = $tickers[0][3];
                $result['ethusd']['bid'] = $tickers[1][1];
                $result['ethusd']['ask'] = $tickers[1][3];
                $result['xrpusd']['bid'] = $tickers[2][1];
                $result['xrpusd']['ask'] = $tickers[2][3];
                break;
            case 7:
                $result['btcusd']['bid'] = $tickers->data->ticker->{$data->btcusd_para}->{$data->bid_para};
                $result['btcusd']['ask'] = $tickers->data->ticker->{$data->btcusd_para}->{$data->ask_para};
                $result['ethusd']['bid'] = $tickers->data->ticker->{$data->ethusd_para}->{$data->bid_para};
                $result['ethusd']['ask'] = $tickers->data->ticker->{$data->ethusd_para}->{$data->ask_para};
                $result['xrpusd']['bid'] = $tickers->data->ticker->{$data->xrpusd_para}->{$data->bid_para};
                $result['xrpusd']['ask'] = $tickers->data->ticker->{$data->xrpusd_para}->{$data->ask_para};
                break;
            case 8:
                $result['btcusd']['bid'] = $tickers->{$data->ticker_para}->{$data->btcusd_para}->{$data->bid_para};
                $result['btcusd']['ask'] = $tickers->{$data->ticker_para}->{$data->btcusd_para}->{$data->ask_para};
                $result['ethusd']['bid'] = $tickers->{$data->ticker_para}->{$data->ethusd_para}->{$data->bid_para};
                $result['ethusd']['ask'] = $tickers->{$data->ticker_para}->{$data->ethusd_para}->{$data->ask_para};
                $result['xrpusd']['bid'] = $tickers->{$data->ticker_para}->{$data->xrpusd_para}->{$data->bid_para};
                $result['xrpusd']['ask'] = $tickers->{$data->ticker_para}->{$data->xrpusd_para}->{$data->ask_para};
                break;
            case 9:
                foreach ($tickers->{$data->ticker_para}->{$data->btcusd_para} as $key => $ticker) {
                    if ($ticker->currency == 'TRY') {
                        $result['btcusd']['bid'] = $ticker->{$data->bid_para};
                        $result['btcusd']['ask'] = $ticker->{$data->ask_para};
                    }
                }
                foreach ($tickers->{$data->ticker_para}->{$data->ethusd_para} as $key => $ticker) {
                    if ($ticker->currency == 'TRY') {
                        $result['ethusd']['bid'] = $ticker->{$data->bid_para};
                        $result['ethusd']['ask'] = $ticker->{$data->ask_para};
                    }
                }
                foreach ($tickers->{$data->ticker_para}->{$data->xrpusd_para} as $key => $ticker) {
                    if ($ticker->currency == 'TRY') {
                        $result['xrpusd']['bid'] = $ticker->{$data->bid_para};
                        $result['xrpusd']['ask'] = $ticker->{$data->ask_para};
                    }
                }
                
                break;
            case 10:
                $result['btcusd']['bid'] = $tickers->{$data->btcusd_para}->{$data->bid_para};
                $result['btcusd']['ask'] = $tickers->{$data->btcusd_para}->{$data->ask_para};
                $result['ethusd']['bid'] = $tickers->{$data->ethusd_para}->{$data->bid_para};
                $result['ethusd']['ask'] = $tickers->{$data->ethusd_para}->{$data->ask_para};
                $result['xrpusd']['bid'] = $tickers->{$data->xrpusd_para}->{$data->bid_para};
                $result['xrpusd']['ask'] = $tickers->{$data->xrpusd_para}->{$data->ask_para};
                break;
        }
        $result['exchange'] = $data->exchange;
        $result['logo'] = $data->second_url;
        Redis::set('ticker'.$id, json_encode($result));
    }
}
