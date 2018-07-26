<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


use App\Ticker;
use App\Tickers\TickerAPI;

class SJobDispatcher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $param;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $param)
    {
        $this->id = $id;
        $this->param = $param;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // echo($this->id);
        $controller = new TickerAPI;
        $controller->getData($this->id, $this->param);
    }
}
