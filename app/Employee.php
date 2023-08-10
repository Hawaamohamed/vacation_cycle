<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['slug', 'user_id', 'name', 'job_title', 'hiring_date', 'image', 'birthday', 'phone', 'email', 'address'];
 
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function employee_vacation_requests()
    {
        return $this->hasMany('App\employee_vacation_requests');
    }



}
