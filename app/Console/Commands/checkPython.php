<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class checkPython extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks to see if we have the needed modules for the image processing';

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
        //

        $result = shell_exec("python3 " . app_path() . '/Console/Scripts/checkPython.py ');
        
        echo $result;
        
        
        
    }
}
