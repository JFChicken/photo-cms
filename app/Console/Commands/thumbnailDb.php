<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PhotoProcess;

class thumbnailDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumbnail:processDb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will look at the records in the table and process the missing thumbnails';

    protected $photoProcess;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PhotoProcess $photoProcess)
    {
        $this->photoProcess = $photoProcess;
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
    }
}
