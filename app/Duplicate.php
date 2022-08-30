<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Duplicate extends Model
{
    protected $table = 'duplicate_reasons';
     protected $fillable = [
        'reason','position'
    ];
}
