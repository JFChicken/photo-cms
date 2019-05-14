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
}
