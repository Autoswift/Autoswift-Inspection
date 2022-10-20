<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staffs';
    protected $fillable = ['name','mobile_number','address','sort_name','status','photo','position','staff_email','icard','govt_issue_id','back_govt_card'];
}
