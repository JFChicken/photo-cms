<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileVault extends Model
{
    //
    protected $primaryKey = 'fileVaultId';
    protected $table = 'FileVault';
    protected $fillable = [
        'fileName',
        'folder',
        'year',
        'thumbnailCreated',
        'sourceFile',
    ];
}
