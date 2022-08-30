<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $fillable=['valuations_by','user_id','area_id','registration_no','make_model','party_name','mobile_no','place','payment','sender_id'];
    public function valuation()
    {
        return $this->hasOne(Valuation::class, 'id','valuations_by');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
    public function area()
    {
        return $this->hasOne(Area::class, 'id','area_id');
    }
}
