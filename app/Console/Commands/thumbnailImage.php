<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FileVault;

class thumbnailImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'img:thumbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a Python command that will take DB records and process the image and return a bool if it can update the db record';

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

        // Get the list of un thumbnailed records to process
        $files = $this->fileVault->getPhotoRecords(false);
        $this->output->progressStart(count($files));
        foreach ($files as $fileId=>$file) {
                   
            $queryImage = $file['image']; //queryImage
            $queryThumbnail = $file['thumbnail'];
            $this->output->progressAdvance();
            // This needs to be refactored but for now this will work with the script
            $data = array(
                array(0, $queryImage),
                array(1, $queryThumbnail)
            );
    
            $count = count($data);
            $a = 1;
            $string = "";
    
            foreach ($data as $d) {
                $string .= $d[0] . '--' . $d[1];
    
                if ($a < $count) {
                    $string .= ",";
                }
                $a++;
            }
    
            $result = shell_exec("python3 " . app_path() . '/Console/Scripts/imageProcess.py ' . escapeshellarg($string));
            // look at the result if we got a true we will mark it down else we will just skip
            
            
            if (strpos($result, 'true') !== false) {
                // Update the DB Record
                $this->fileVault->updatePhotoThumbnail($fileId);
            }
    
        }
        $this->output->progressFinish();

    }
}
