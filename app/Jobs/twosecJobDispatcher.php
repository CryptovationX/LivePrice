<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Carbon\Carbon;
use App\Ticker;

class twosecJobDispatcher implements ShouldQueue
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
        twosecJobDispatcher::dispatch()->delay(Carbon::now()->addSeconds(2));
        
        $tickers = Ticker::all();
        foreach ($tickers as $key => $ticker) {
            if ($ticker->interval == 2) {
                JobDispatcher::dispatch($ticker->id);
            }
        }
    }
}
