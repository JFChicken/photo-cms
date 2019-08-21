<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FileVault;

class FileVaultCsvImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fV:csv {dir=cr2Images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import CSV of DNG and CR2 files';

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
        
        $inputDir = $this->argument('dir');

        if($inputDir === 'cr2Images'){
            // use the default dir we import from
            $inputDir = storage_path() . '/app/public/cr2Images';
        }
        $this->info('Building csv from: '.$inputDir);
        $csvDir = storage_path() . '/app/public/import.csv';
        $this->info('csv file '.$csvDir);
        $command = "exiftool -T -r -csv -n -filename -orientation -GPSLatitude -GPSLongitude -dateTimeOriginal {$inputDir} > {$csvDir}";
        $result = shell_exec($command);
        
        $this->info('import CSV');
        
        $this->fileVault->importCSVFile($csvDir);


    }
}
