<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; 
use App\Employee; 
use App\Employee_vacation_request; 
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  $user = User::where("id", Auth::id())->first();
        if($user->type == 'admin'){
            
            return view('home');

       }else{
            $employee = Employee::where('id', Auth::user()->employee_id)->first();
            Session::put('employee_id', $employee->id); 
            $employee_vacation_requests = Employee_vacation_request::where('employee_id', $employee->id)->get();
            return view("employees.show")->with('employee', $employee)->with('employee_vacation_requests', $employee_vacation_requests);
       }
        
    }
}
