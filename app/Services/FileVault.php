<?php

namespace App\Services;

use App\Models\FileVault as FileVaultModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
     * Get an XML File
     */
    public static function getXMLFile()
    {

        // collectet the sheet
        $XML = Storage::disk('local')->get('public/characters/Nadarr.xml');
        // convert to update in xml
        $xmlFile =  simplexml_load_string($XML);
        // make an update to it
        $xmlFile->character->exp = '100';
        // Save to update
        $xmlFile->asXml('storage/characters/updated.xml');
        $characterKeys = collect();
        foreach ($xmlFile->character->children() as $key => $item) {
            $characterKeys[$key]= $item;
        }
        dd($characterKeys);
        dd($xmlFile->children(), $xmlFile->character->children());

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


            if (strpos($file, '.jpg') !== false) {
                // Split the remander to get the 3 need values, year, event and file name

                $split = explode('/', $file);

                $year = (int)$split[0];
                $event = $split[1];
                $fileName = preg_replace('/.[^.]*$/', '', $split[2]);
                $processedFiles[] = [
                    'year' => $year,
                    'folder' => $event,
                    'fileName' => $fileName,
                ];
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
            'thumbnail' => $thumbnailUrl . $record->year . '/' . $record->folder . '/' . $record->fileName . '.jpg'
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
}
