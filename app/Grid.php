<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    protected $fillable=['vehicle_make','vehicle_model','variant','chassis_no','year','cost','note'];
}
