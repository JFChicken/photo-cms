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

        $year = date('Y');
        $date = date('mdy');
        $inputDir = storage_path() . '/app/public/cr2Images';
        $jpgDir = storage_path() . '/app/public/photos/' . $year . '/import-' . $date;

        #$this->output->progressAdvance();

        echo "jpg\n";
        // Now take the CR2 files and make fullsize images
        $command = "exiftool  -b -PreviewImage -w {$jpgDir}/%f.jpg -ext dng -r {$inputDir}";
        $result = shell_exec($command);
        echo $result;

        if ($result === null) {
            // We need to load the CSV and add it to our cr2 processing table to be added to the gallery
            $csvFile = "{$inputDir}/output.csv";

            $header = null;
            $data = array();
            echo "import CSV\n";
            if (($handle = fopen($csvFile, 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    if (!$header) {
                        // Check that this will work for the model if it doesnt abort the loading of the file
                        // Set the flag
                        $header = true;
                        $validCSV = ['SourceFile', 'FileName', 'Orientation', 'gpslatitude', 'gpslongitude', 'DateTimeOriginal'];
                        if ($row != $validCSV) {
                            exit('bad CSV file');
                        }
                    } else {
                        $batchCrObj = BatchCr2::create([
                            'sourceFile' => $row[0],
                            'fileName' => $row[1],
                            'orientation' => $row[2],
                            'gpsLatitude' => $row[3],
                            'gpsLongitude' => $row[4],
                            'dateTimeOriginal' => $row[5],
                        ]);

                        $batchCrObj->save();
                        // load the row to the model and save it

                        // // update the JPG Tags from CR2 files
                        // $source = $row[0];
                        // $jpg = str_replace('CR2','jpg',$row[1]);
                        // $final = $jpgDir.'/'.$jpg;
                        // // Sync the meta for ontration       
                        // $command = "exiftool -overwrite_original -tagsfromfile {$source} -orientation {$final}";
                        // $result = shell_exec($command);
                        // echo $result;

                    }
                }
                // Cleanup
                fclose($handle);
                unlink($csvFile);
            }
        }


        #$this->output->progressFinish();
    }
}
