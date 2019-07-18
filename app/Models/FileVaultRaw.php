<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileVaultRaw extends Model
{
    //
    use SoftDeletes;
    protected $primaryKey = 'fileVaultRawFileId';
    protected $table = 'FileVaultRawFile';
    protected $fillable = [
        'sourceFile',
        'fileName',
        'fileExtestion',
        'fileVaultDisplayId',
        'gpsLatitude',
        'gpsLongitude',
        'dateTimeTaken',
        'orientation'
    ];
}
