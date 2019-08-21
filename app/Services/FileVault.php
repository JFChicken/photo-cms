<?php

namespace App\Services;

use App\Models\FileVault as FileVaultModel;
use App\Models\FileVaultRaw as FileVaultRawModel;
use App\Models\FileVaultDisplay as FileVaultDisplayModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

/**
 *  This class will have and has functions relating to access to local, s3, ect
 *  file storages. Its goal is to take the images and store them in the DB and
 *  help with creating thumbnails and meta data as well.
 * 
 */
class FileVault
{

    protected $rootDir = 'public/photos';

    protected $fileVaultModel;

    public function __construct(FileVaultModel $fileVault)
    {
        $this->fileVaultModel = $fileVault;
    }

    /**
     *  Pulls all of the files inside the photos public dir
     */
    private function getPhotos()
    {
        $rootDir = $this->rootDir;
        $files = Storage::allFiles($rootDir);
        return $files;
    }

    /**
     *  Takes a array of files and checks if they exist or are new if they are new we add them to the db and count them
     *  We return the new file count 
     */
    private function updateDatabase(array $files)
    {
        $newFiles = 0;
        foreach ($files as $file) {
            // Check if the year is valid if it is then we are good to go.
            if (checkdate(1, 1, $file['year'])) {
                $fileVaultObj = FileVaultModel::firstOrNew(
                    [
                        'fileName' => $file['fileName'],
                        'folder' => $file['folder'],
                        'year' => $file['year'],
                        'sourceFile' => $file['sourceFile'],
                    ],
                    [
                        // We set this Null to use as a counter for processed files
                        'thumbnailCreated' => null
                    ]
                );

                if (is_null($fileVaultObj->thumbnailCreated)) {
                    $newFiles++;
                    $fileVaultObj->thumbnailCreated = false;
                }

                $fileVaultObj->save();
            }
        }

        return $newFiles;
    }

    /**
     *  This looks at the raw files / dirs and creates a list of jpgs
     *  that can be added to the DB 
     */
    private function processFiles(array $files)
    {
        $rootDir = $this->rootDir;

        $processedFiles = [];

        foreach ($files as $file) {
            // Take the string and remove the root
            $file = str_replace($rootDir . '/', '', $file);

            if (strpos($file, '.JPG') !== false || strpos($file, '.jpg') !== false) {
                // Split the remander to get the 3 need values, year, event and file name
                $split = explode('/', $file);
                if (count($split) < 3) {
                    // If we dont have one that is 3 values we need to decide how we want to handle it
                    // Look at the first value and see if we can build a date from it if we cant then we have a folder item then a file item.
                    $carbon = Carbon::now();
                    if (strtotime($split[0]) === false) {
                        // Now just push in the date
                        array_unshift($split, (string) $carbon->year);
                    }
                }
                $year = (int) $split[0];
                $event = $split[1];
                $fileName = preg_replace('/.[^.]*$/', '', $split[2]);
                $processedFiles[] = [
                    'year' => $year,
                    'folder' => $event,
                    'fileName' => $fileName,
                    'sourceFile' => $file,
                ];
            } elseif (strpos($file, '.TIF') !== false || strpos($file, '.tif') !== false) {
                var_dump($file);
            } else {
                // Show what files are not being processed
                var_dump('process');
            }
        }
        return $processedFiles;
    }

    /**
     *  This will take a record and return an array with the image url and Thumbnail
     *  Depending on the boolen $reelativePath we will either have file sistem absolut path (needed for Python scrip)
     *  Or one used for displaying the images on the site
     */
    private function  createFileUrls($record, $relativePath = false)
    {

        // @TODO: make this if statment better and remove the hard coded strings
        if ($relativePath) {
            $url = '/storage/photos/';
            $thumbnailUrl = '/storage/thumbnails/';
        } else {
            $url = $this->storagePath();
            $thumbnailUrl = $this->thumbnailPath();

            // Create the thumbnail drive before sending this since the python script will not handle it.
            $this->createThumbnailDir($thumbnailUrl . $record->year . '/' . $record->folder);
        }
        return [
            'id' => $record->fileVaultId,
            'image' => $url . $record->year . '/' . $record->folder . '/' . $record->fileName . '.jpg',
            'thumbnail' => $thumbnailUrl . $record->year . '/' . $record->folder . '/' . $record->fileName . '.jpg',
            'manageUrl' => 'manage/image/' . $record->fileVaultId,
        ];
    }

    private function processDbRecords($records)
    {

        $files = [];
        foreach ($records as $record) {
            $files[$record->fileVaultId] = $this->createFileUrls($record, false);
        }

        return $files;
    }

    private function storagePath()
    {
        return storage_path() . '/app/public/photos/';
    }

    private function thumbnailPath()
    {
        return storage_path() . '/app/public/thumbnails/';
    }

    private function createThumbnailDir($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true);
        }
    }

    /**
     * This scans the Dir for photos and reurns them
     *  
     */
    public function readPhotoDir()
    {

        $files = $this->getPhotos();
        return $this->processFiles($files);
    }

    /**
     *  This is the open point to create new thumbnails it will return the count of files processed
     */
    public function updatePhotoRecords($files)
    {

        return $this->updateDatabase($files);
    }

    /**
     *  This will set the DB record column Thumbnail created as true (created)
     */
    public function updatePhotoThumbnail($recordId)
    {
        return $this->fileVaultModel::find($recordId)->update(['thumbnailCreated' => true]);
    }

    /**
     *  This will look at the DB and get all of the records that do not have a thumbnail(default)
     *  and return then with Urls for the image and the proposed url file to be stored
     */
    public function getPhotoRecords($thumbnailCreated = false)
    {

        $files = $this->fileVaultModel::where(['thumbnailCreated' => $thumbnailCreated])->get();

        return $this->processDbRecords($files);
    }

    /**
     *  Looks at the DB records that have thumbnails and creates reletive urls for the view to display
     */
    public function getViewUrls($filter)
    {

        $records = $this->fileVaultModel::where(['thumbnailCreated' => true])->get();
        $files = [];
        // Newest first
        foreach ($records->sortByDesc($filter) as $record) {
            $files[$record->fileVaultId] = $this->createFileUrls($record, true);
        }

        return $files;
    }
    /**
     *  DEVELOPER command; to clear out the DB so it can be reinitilized 
     * 
     */
    public function truncateRecords()
    {

        return $this->fileVaultModel::truncate();
    }

    /**
     *  Takes an CSV file and imports the records to the FV Raw table
     */
    public function importCSVFile(string $csvFile)
    {
        $header = false;
        // Take the CSV File and import it to the Table
        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header) {
                    // Check that this will work for the model if it doesnt abort the loading of the file
                    // Set the flag
                    $header = true;
                    $validCSV = ['SourceFile', 'FileName', 'Orientation', 'GPSLatitude', 'GPSLongitude', 'DateTimeOriginal'];
                    if ($row != $validCSV) {
                        // We likely have a miss mach of case sentitivity
                        var_dump($row,$validCSV);
                        exit('bad CSV file');
                    }
                } else {

                    // Get the Extestion and the 
                    $pathInfo = pathinfo($row[1]);
                    $fileExtestion = $pathInfo['extension'];

                    $fileName = $pathInfo['filename'];

                    // look at the record and if we have an existing source file we will not add it again
                    $fileVaultObj = FileVaultRawModel::firstOrNew(
                        [
                            'sourceFile' => $row[0],
                        ],
                        [
                            // We set this Null to use as a counter for processed files
                            'fileName' => $fileName,
                            'fileExtestion' => $fileExtestion,
                            'fileVaultDisplayId' => null,
                            'gpsLatitude' => $row[3],
                            'gpsLongitude' => $row[4],
                            'dateTimeTaken' => $row[5],
                            'orientation' => $row[2],
                        ]
                    );

                    $fileVaultObj->save();
                }
            }
            // Cleanup
            fclose($handle);
            unlink($csvFile);
        }

        return true;
    }

    public function updateRawTable($output)
    { }

    /**
     *  Takes ALL of the records in the FV:RAW table and create Full size Previews 
     *  Will also sync the Meta data from the table to the new previews
     *  - the only meta info is the orientation info.
     * 
     */
    public function createImagesFromRawTable($output)
    {
        // This will need to have a optional filter to just do new files or do a full refresh baised off of the image id  value
        $unprocessedRecords = FileVaultRawModel::where('fileVaultDisplayId', null)->get();

        // Disp output for the command
        $output->progressStart($unprocessedRecords->count());

        foreach ($unprocessedRecords as $record) {
            // Update output
            $output->progressAdvance();

            #Each record we need to build an full zise image

            // Get the two folder options used for older image caching
            $year = date('Y');
            $date = date('mdy');

            $inputFile = $record['sourceFile'];
            $fileExtestion = $record['fileExtestion'];
            $outputDir = storage_path() . '/app/public/photos/' . $year . '/import-' . $date;
            $fileName = $record['fileName'] . '.jpg';

            // Check that the preview doesnt exist if it does we need to remove it before rebuilding it.
            // We do not keep old previews ever; changes to the RAW files take precidentatne
            if (file_exists("{$outputDir}/{$fileName}")) {
                unlink("{$outputDir}/{$fileName}");
            }

            // Now take the RAW files and make fullsize images
            $command = "exiftool  -b -PreviewImage -w {$outputDir}/%f.jpg -ext {$fileExtestion} {$inputFile}";
            $result = shell_exec($command);

            $command = "exiftool -s -Orientation {$inputFile}";
            $result = shell_exec($command);

            // echo "\n {$command} \n\t".$result.PHP_EOL;

            #SYNC meta data to the new preview image file.

            $final = $outputDir . '/' . $record['fileName'] . '.jpg';
            $orientation = (int) $record['orientation'];

            // Sync the meta for ontration

            $command = "exiftool -overwrite_original -IFD0:Orientation='{$orientation}' -n -IFD1:Orientation='{$orientation}' -n {$final}";
            // $command = "exiftool -overwrite_original -tagsfromfile {$inputFile} -orientation {$final}";
            $result = shell_exec($command);
            //echo "{{$command}} \n\t".$result.PHP_EOL;
            
            
            $command = "exiftool -s -Orientation {$final}";
            $result = shell_exec($command);

            // echo "\n {$command} \n\t".$result.PHP_EOL;


            // Orientate it
            // Build a thumbnail(will handle latter)

            // Update the Raw Table with the image ID

            $pathInfo = pathinfo($final);

            $fileVaultObj = FileVaultDisplayModel::create([

                'sourceFile' => $final,
                'fileName' => $pathInfo['filename'],
                'fileExtestion' => $pathInfo['extension'],
                'thumbnailCreated' => false,

            ]);

            // Update the Raw File with the built display image
            $record['fileVaultDisplayId'] = $fileVaultObj['fileVaultDisplayId'];


            $fileVaultObj->save();
            $record->save();

            // Take the JPG file url and put it in the dir along with some other data
            $final;
        }
        $output->progressFinish();
    }
}
