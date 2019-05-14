<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileVault extends Model
{
    //
    protected $table = 'FileVault';
    protected $fillable = [
        'fileName',
        'folder',
        'year',
        'thumbnailCreated'
    ];
}
