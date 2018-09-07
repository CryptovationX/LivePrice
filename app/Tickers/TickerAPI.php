<?php

namespace App\Tickers;

use App\Ticker;
use Illuminate\Support\Facades\Redis;

class TickerAPI
{
    public function test()
    {
        $this->getData(15, 'btcusd_para');
    }

    public function forex()
    {
        $json = file_get_contents('http://apilayer.net/api/live?access_key=388c98963b910615abafe67e5d0d6bc5&currencies=THB,INR,KRW,TRY');
        $forex = json_decode($json);
        Redis::set('THB', $forex->quotes->USDTHB);
        Redis::set('INR', $forex->quotes->USDINR);
        Redis::set('KRW', $forex->quotes->USDKRW);
        Redis::set('TRY', $forex->quotes->USDTRY);
    }

    public function getData($id, $symbol = null)
    {
        $result = array();
        $data = Ticker::find($id);
        if (is_null($data->link)) {
            $data->link = 'https://'.$data->exchange;
        }

        if ($data->seperate==1) {
            $json = file_get_contents($data->url.$data->{$symbol});
        } else {
            $json = file_get_contents($data->url);
            $result['exchange'] = $data->exchange;
            $result['logo'] = $data->second_url;
            $result['link'] = $data->link;
            $result['filter'] = $data->filter;
            $result['region'] = $data->region;
            $result['country'] = $data->country;
        }
        $tickers = json_decode($json);
       
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
                $forex = Redis::get('THB');
                $result['btcusd']['bid'] = $tickers->{1}->orderbook->bids->highbid/$forex;
                $result['btcusd']['ask'] = $tickers->{1}->orderbook->asks->highbid/$forex;
                $result['ethusd']['bid'] = $tickers->{21}->orderbook->bids->highbid/$forex;
                $result['ethusd']['ask'] = $tickers->{21}->orderbook->asks->highbid/$forex;
                $result['xrpusd']['bid'] = $tickers->{25}->orderbook->bids->highbid/$forex;
                $result['xrpusd']['ask'] = $tickers->{25}->orderbook->asks->highbid/$forex;
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
                $forex = Redis::get('KRW');
                $result['btcusd']['bid'] = $tickers->{$data->ticker_para}->{$data->btcusd_para}->{$data->bid_para}/$forex;
                $result['btcusd']['ask'] = $tickers->{$data->ticker_para}->{$data->btcusd_para}->{$data->ask_para}/$forex;
                $result['ethusd']['bid'] = $tickers->{$data->ticker_para}->{$data->ethusd_para}->{$data->bid_para}/$forex;
                $result['ethusd']['ask'] = $tickers->{$data->ticker_para}->{$data->ethusd_para}->{$data->ask_para}/$forex;
                $result['xrpusd']['bid'] = $tickers->{$data->ticker_para}->{$data->xrpusd_para}->{$data->bid_para}/$forex;
                $result['xrpusd']['ask'] = $tickers->{$data->ticker_para}->{$data->xrpusd_para}->{$data->ask_para}/$forex;
                break;
            case 9:
                $forex = Redis::get('TRY');
                foreach ($tickers->{$data->ticker_para}->{$data->btcusd_para} as $key => $ticker) {
                    if ($ticker->currency == 'TRY') {
                        $result['btcusd']['bid'] = $ticker->{$data->bid_para}/$forex;
                        $result['btcusd']['ask'] = $ticker->{$data->ask_para}/$forex;
                    }
                }
                foreach ($tickers->{$data->ticker_para}->{$data->ethusd_para} as $key => $ticker) {
                    if ($ticker->currency == 'TRY') {
                        $result['ethusd']['bid'] = $ticker->{$data->bid_para}/$forex;
                        $result['ethusd']['ask'] = $ticker->{$data->ask_para}/$forex;
                    }
                }
                foreach ($tickers->{$data->ticker_para}->{$data->xrpusd_para} as $key => $ticker) {
                    if ($ticker->currency == 'TRY') {
                        $result['xrpusd']['bid'] = $ticker->{$data->bid_para}/$forex;
                        $result['xrpusd']['ask'] = $ticker->{$data->ask_para}/$forex;
                    }
                }
                
                break;
            case 10:
                $forex = Redis::get('INR');
                $result['btcusd']['bid'] = $tickers->{$data->btcusd_para}->{$data->bid_para}/$forex;
                $result['btcusd']['ask'] = $tickers->{$data->btcusd_para}->{$data->ask_para}/$forex;
                $result['ethusd']['bid'] = $tickers->{$data->ethusd_para}->{$data->bid_para}/$forex;
                $result['ethusd']['ask'] = $tickers->{$data->ethusd_para}->{$data->ask_para}/$forex;
                $result['xrpusd']['bid'] = $tickers->{$data->xrpusd_para}->{$data->bid_para}/$forex;
                $result['xrpusd']['ask'] = $tickers->{$data->xrpusd_para}->{$data->ask_para}/$forex;
                break;
            case 11:
                switch ($symbol) {
                    case 'btcusd_para':
                        $result['btcusd']['bid'] = $tickers->{$data->ticker_para}->{$data->symbol_para}[2];
                        $result['btcusd']['ask'] = $tickers->{$data->ticker_para}->{$data->symbol_para}[4];
                        $id .= 'btc';
                        break;
                    
                    case 'ethusd_para':
                        $result['ethusd']['bid'] = $tickers->{$data->ticker_para}->{$data->symbol_para}[2];
                        $result['ethusd']['ask'] = $tickers->{$data->ticker_para}->{$data->symbol_para}[4];
                        $id .= 'eth';
                        break;
                    
                    case 'xrpusd_para':
                        $result['xrpusd']['bid'] = $tickers->{$data->ticker_para}->{$data->symbol_para}[2];
                        $result['xrpusd']['ask'] = $tickers->{$data->ticker_para}->{$data->symbol_para}[4];
                        $result['exchange'] = $data->exchange;
                        $result['logo'] = $data->second_url;
                        $result['link'] = $data->link;
                        $result['filter'] = $data->filter;
                        $id .= 'xrp';
                        break;
                }
                break;
            case 12:
                $forex = Redis::get('KRW');
                switch ($symbol) {
                    case 'btcusd_para':
                        $result['btcusd']['bid'] = $tickers->bid[0]->price/$forex;
                        $result['btcusd']['ask'] = $tickers->ask[0]->price/$forex;
                        $id .= 'btc';
                        break;
                    
                    case 'ethusd_para':
                        $result['ethusd']['bid'] = $tickers->bid[0]->price/$forex;
                        $result['ethusd']['ask'] = $tickers->ask[0]->price/$forex;
                        $id .= 'eth';
                        break;
                    
                    case 'xrpusd_para':
                        $result['xrpusd']['bid'] = $tickers->bid[0]->price/$forex;
                        $result['xrpusd']['ask'] = $tickers->ask[0]->price/$forex;
                        $result['exchange'] = $data->exchange;
                        $result['logo'] = $data->second_url;
                        $result['link'] = $data->link;
                        $result['filter'] = $data->filter;
                        $id .= 'xrp';
                        break;
                }
                break;
            case 13:
                $forex = Redis::get('THB');
                switch ($symbol) {
                    case 'btcusd_para':
                        $result['btcusd']['bid'] = $tickers->Bid/$forex;
                        $result['btcusd']['ask'] = $tickers->Ask/$forex;
                        $id .= 'btc';
                        break;
                    
                    case 'ethusd_para':
                        $result['ethusd']['bid'] = $tickers->Bid/$forex;
                        $result['ethusd']['ask'] = $tickers->Ask/$forex;
                        $id .= 'eth';
                        break;
                    
                    case 'xrpusd_para':
                        $result['xrpusd']['bid'] = $tickers->Bid/$forex;
                        $result['xrpusd']['ask'] = $tickers->Ask/$forex;
                        $result['exchange'] = $data->exchange;
                        $result['logo'] = $data->second_url;
                        $result['link'] = $data->link;
                        $result['filter'] = $data->filter;
                        $id .= 'xrp';
                        break;
                }
                break;

            case 14:
                $forex = Redis::get('THB');
                foreach ($tickers as $key => $ticker) {
                    if ($ticker->{$data->symbol_para} == $data->btcusd_para) {
                        $result['btcusd']['bid'] = $ticker->{$data->bid_para}/$forex;
                        $result['btcusd']['ask'] = $ticker->{$data->ask_para}/$forex;
                    }
                    if ($ticker->{$data->symbol_para} == $data->ethusd_para) {
                        $result['ethusd']['bid'] = $ticker->{$data->bid_para}/$forex;
                        $result['ethusd']['ask'] = $ticker->{$data->ask_para}/$forex;
                    }
                }
                break;

            case 15:
                $result['btcusd']['bid'] = $tickers[1]->price;
                $result['btcusd']['ask'] = $tickers[0]->price;
                break;

            case 16:
                foreach ($tickers->{$data->ticker_para} as $key => $ticker) {
                    if ($ticker->{$data->symbol_para} == $data->btcusd_para) {
                        $result['btcusd']['bid'] = $ticker->open;
                        $result['btcusd']['ask'] = $ticker->close;
                    }
                    if ($ticker->{$data->symbol_para} == $data->ethusd_para) {
                        $result['ethusd']['bid'] = $ticker->open;
                        $result['ethusd']['ask'] = $ticker->close;
                    }
                    if ($ticker->{$data->symbol_para} == $data->xrpusd_para) {
                        $result['xrpusd']['bid'] = $ticker->open;
                        $result['xrpusd']['ask'] = $ticker->close;
                    }
                }
                dd($result);
                break;
        
        }
       
        Redis::set('ticker'.$id, json_encode($result));
    }
}
