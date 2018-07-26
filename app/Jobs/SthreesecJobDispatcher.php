<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Carbon\Carbon;
use App\Ticker;

class SthreesecJobDispatcher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SthreesecJobDispatcher::dispatch()->delay(Carbon::now()->addSeconds(3));
        
        $tickers = Ticker::all();
        foreach ($tickers as $key => $ticker) {
            if ($ticker->interval == 3 && $ticker->seperate == 1) {
                SJobDispatcher::dispatch($ticker->id, 'btcusd_para');
                SJobDispatcher::dispatch($ticker->id, 'ethusd_para');
                SJobDispatcher::dispatch($ticker->id, 'xrpusd_para');
            }
        }
    }
}
