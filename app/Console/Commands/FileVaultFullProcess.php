<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FileVaultFullProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fV:full';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs all the commands in order';

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
        // This will run all of the seprate commands that are needed to start or update the system

        // Start with loading the RAW images
        $this->call('fV:csv', []);
        // Take loaded images and makes full res jpgs
        $this->call('fV:img', []);
        // Caches the images to display them
        $this->call('fV:cache', []);
        // Build thumbnails for site
        $this->call('img:thumb', []);
        
    }
}
