<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class thumbnailImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumbnail:processImages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a Python command that will take DB records and process the image and return a bool if it can update the db record';

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
        $queryImage = storage_path() .'/app/public/photos/2019/testing/testingPhoto.jpg'; //queryImage
        $queryThumbnail = storage_path() .'/app/public/thumbnails/2019/testing/thumb-testingPhoto.jpg';
        $queryId = 1;
        $data = array(
            array(0, $queryImage),
            array(1, $queryThumbnail),
            array(2, $queryId),
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
        
        echo $result;
    }
}
