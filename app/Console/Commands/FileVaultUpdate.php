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
    protected $signature = 'fileVault:update';

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
echo "\tprocessing:\n";
        $result = $this->fileVault->readPhotoDir();
        var_dump($result);
    }
}