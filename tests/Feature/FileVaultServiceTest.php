<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\FileVault;
use App\Models\FileVault as FileVaultModel;

class FileVaultServiceTest extends TestCase
{

    private $fileVault;

    public function setUp(): void
    {
        parent::setUp();
        $this->fileVault = new FileVault(
            app(FileVaultModel::class)
        );
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetFiles()
    {

        $this->assertIsArray($this->fileVault->readPhotoDir());
    }

     /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdatingDatabase()
    {
        
        $files = $this->fileVault->readPhotoDir();
        $this->assertTrue($this->fileVault->updatePhotoRecords($files));
    }

    public function testGetPhotoRecords()
    {
        
        $files = $this->fileVault->getPhotoRecords();
        
        $this->assertIsArray($files);
    }
}
