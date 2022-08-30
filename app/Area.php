<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
     protected $fillable = [
        'name','state_id'
    ];
    public function State()
    {
        return $this->hasOne(State::class, 'id','state_id');
    }
}
