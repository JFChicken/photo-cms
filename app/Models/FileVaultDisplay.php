<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileVaultDisplay extends Model
{
    //
    use SoftDeletes;
    protected $primaryKey = 'fileVaultDisplayId';
    protected $table = 'FileVaultDisplay';
    protected $fillable = [
        'sourceFile',
        'fileName',
        'fileExtestion',
        'thumbnailCreated',
    ];
}
