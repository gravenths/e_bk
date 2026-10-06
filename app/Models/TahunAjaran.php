<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'tahun',
        'semester',
        'status',
    ];
}
