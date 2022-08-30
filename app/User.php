<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','username','mobile_number','pass1','address','employee_id','area_id','comp_id','icard','govt_issue_id','back_govt_card','ref_start','photo','status','app_version','user_ref','profile_name','device_id','firebase_id','mobile_model','location','location_setting','network_setting',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function valuation()
    {
        return $this->hasOne(Valuation::class, 'id','comp_id');
    }
    public function area()
    {
        return $this->hasOne(Area::class, 'id','area_id');
    }
}
