<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee_vacation_request extends Model
{
    
    protected $table = 'employee_vacation_requests';
    protected $fillable = ['user_id', 'request_id', 'vacation_from', 'vacation_to', 'reason', 'vacation_type', 'employee_id'];
 
    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id');
    }   
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
