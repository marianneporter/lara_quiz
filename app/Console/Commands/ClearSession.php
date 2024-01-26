<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-session';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear session';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        session()->flush();
    }
}
