<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Carbon\Carbon;
use App\Ticker;

class sixsecJobDispatcher implements ShouldQueue
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
        sixsecJobDispatcher::dispatch()->delay(Carbon::now()->addSeconds(6));
        
        $tickers = Ticker::all();
        foreach ($tickers as $key => $ticker) {
            if ($ticker->interval == 6) {
                JobDispatcher::dispatch($ticker->id);
            }
        }
    }
}
