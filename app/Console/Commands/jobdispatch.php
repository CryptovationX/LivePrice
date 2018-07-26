<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\onesecJobDispatcher;
use App\Jobs\twosecJobDispatcher;
use App\Jobs\sixsecJobDispatcher;
use App\Jobs\SonesecJobDispatcher;
use App\Jobs\SthreesecJobDispatcher;

class jobdispatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobdispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        onesecJobDispatcher::dispatch();
        twosecJobDispatcher::dispatch();
        sixsecJobDispatcher::dispatch();
        SonesecJobDispatcher::dispatch();
        SthreesecJobDispatcher::dispatch();
    }
}
