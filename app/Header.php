<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    protected $fillable = [
        'licence_no', 'expire','email1','email2','licence_no', 'mobile_number', 'logo','authorizer_name','authorizer_education','authorizer_designation','report_heading','iisla_no'
    ];
    protected $expire = ['expire'];
}
