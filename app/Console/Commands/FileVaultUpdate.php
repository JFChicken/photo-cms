<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FileVault;

class FileVaultUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fileVault:update {--boldly : Force a DB Record purge}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will take the photo files in X dir and add them to the DB';

    protected $fileVault;

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
        if ( $this->option('boldly') && $this->confirm('Do you want to reset the DB?')) {
            
            $this->error("Clearing DB Records");
            $result = $this->fileVault->truncateRecords();
            $this->info("Readding images... ");
        }
        $result = $this->fileVault->readPhotoDir();
        $this->info('Found: '.count($result).' Images.');
        $processed = $this->fileVault->updatePhotoRecords($result);
        $this->info("Processed: {$processed} Images.");
        
    }
}
