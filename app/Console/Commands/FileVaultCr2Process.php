<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FileVault;
use App\Models\BatchCr2;

class FileVaultCr2Process extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fV:cr2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes a given folder and will migrate the files to the DB to be processed';

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



        #$this->output->progressStart(5);



        $inputDir = storage_path() . '/batchTest';

        #$this->output->progressAdvance();

        // This needs to be refactored but for now this will work with the script
        // This will take a data set and convert them to paramaters for the python script to use
        $data = array(
            array(0, $inputDir),
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
        $command = "exiftool -T -r -csv -n -filename -orientation {$inputDir} > {$inputDir}/output.csv";

        $result = shell_exec($command);

        if ($result === null) {
            // We need to load the CSV and add it to our cr2 processing table to be added to the gallery
            $csvFile = "{$inputDir}/output.csv";

            $header = null;
            $data = array();

            if (($handle = fopen($csvFile, 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    if (!$header) {
                        // Check that this will work for the model if it doesnt abort the loading of the file
                        // Set the flag
                        $header = true;
                        $validCSV=['SourceFile','FileName','Orientation'];
                        if($row!=$validCSV){
                            exit('bad CSV file');
                        }

                    } else {
                        $batchCrObj = BatchCr2::create([
                            'SourceFile'=>$row[0],
                            'FileName'=>$row[1],
                            'Orientation'=>$row[2]
                        ]);

                        $batchCrObj->save();
                        // load the row to the model and save it
                    }
                }
                // Cleanup
                fclose($handle);
            }
        }


        #$this->output->progressFinish();
    }
}
