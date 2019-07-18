<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FileVault;


class FileVaultDisplayImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fV:img';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Display images';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FileVault $fileVault)
    {
        $this->fileVault = $fileVault;
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
        // Take the images in the RAW Files that do not have an Display Id and creates them along with the Thumbnail

        $this->fileVault->createImagesFromRawTable($this->output);
    }
}
