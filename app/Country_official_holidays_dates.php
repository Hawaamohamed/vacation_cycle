<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country_official_holidays_dates extends Model
{  
    protected $table = 'country_official_holidays_dates';
    protected $fillable = ['user_id', 'official_holiday_date', 'holiday_name'];
 
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
