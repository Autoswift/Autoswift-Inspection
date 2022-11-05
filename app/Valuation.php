<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class Valuation extends Model
{
     protected $fillable = [
        'name','position','grid_pdf','address','short_name','status'
    ];
}
