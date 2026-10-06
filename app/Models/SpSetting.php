<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpSetting extends Model
{
    protected $table = 'sp_settings';

    protected $fillable = [
        'sp1',
        'sp2',
        'sp3',
    ];
}
