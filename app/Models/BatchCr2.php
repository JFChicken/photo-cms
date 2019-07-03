<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchCr2 extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'batchCrId';
    protected $table = 'batchCr';
    protected $fillable = [
        'SourceFile',
        'FileName',
        'Orientation'
    ];
}
