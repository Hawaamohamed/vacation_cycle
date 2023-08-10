<?php

namespace App\Http\Controllers;

use App\Employee_vacation_request;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Country_official_holidays_dates;

class EmployeeVacationRequestController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    { 
        $employee_vacation_requests = Employee_vacation_request::where('employee_id', Session::get('employee_id'))->Orderby('id', 'DESC')->paginate(25);
        $employee = Employee::where('id', Session::get('employee_id'))->first();
        return view('employees.employee_vacation_requests')->with('employee_vacation_requests', $employee_vacation_requests)->with('employee', $employee);
    }
 
    public function create()
    {
       
        return view('employees.create');
    }

     
    public function store(Request $request)
    {
       
        $validate = $this->validate($request, [
            'vacation_from'=>'required|date', 
            'vacation_to'=>'required|date' ,
            'vacation_type'=>'required' 
        ]);
        
        if(Session::get('total_vacations') - Session::get('total_vacation_requests_based_on_hiring_date') > 0)
        {
        
            if(date($request->vacation_from) < date($request->vacation_to))
            { 
                $country_official_holidays_dates = Country_official_holidays_dates::where('official_holiday_date', $request->vacation_from)->first();
        
                $count_country_official_holidays_dates = Country_official_holidays_dates::where('official_holiday_date', $request->vacation_from);
        
        
                if($count_country_official_holidays_dates->count() == 0)
                { 
                $check_employee_vacation_request = Employee_vacation_request::where('employee_id', Session::get('employee_id'))->where('vacation_from', $request->vacation_from)->where('vacation_to', $request->vacation_to);
            
                
                    if($check_employee_vacation_request->count() == 0)
                    {
                
                        $employee_vacation_request = new Employee_vacation_request;  
                        $employee_vacation_request->request_id=$request->request_id;  
                        $employee_vacation_request->vacation_from=$request->vacation_from; 
                        $employee_vacation_request->vacation_to=$request->vacation_to;   
                        $employee_vacation_request->reason=$request->reason; 
                        $employee_vacation_request->vacation_type= $request->vacation_type; 
                        $employee_vacation_request->employee_id=$request->employee_id;  
                        $employee_vacation_request->user_id  = Auth::id() ;
                        $employee_vacation_request->employee_id = Session::get('employee_id');
                        $employee_vacation_request->save();
                    
                

                    // if(!is_null($validate))
                    // {
                        return response()->json([
                            'message'   => 'ُemployee vacation request Added Successfully',
                            'response' => 'success'  
                        ]);
                    //} 
                    }else{
                    
                        return response()->json([
                        'message'   => 'This Request already Done before ',
                        'response' => 'error' 
                        ]);
                
                    }
                }else{
                
                    return response()->json([
                    'message'   => 'This day is already a holiday '. $country_official_holidays_dates->holiday_name,
                    'response' => 'error' 
                    ]);
                }
            }else{
            
                return response()->json([
                'message'   => 'Please Enter Correct dates',
                'response' => 'error' 
            ]);
            } 
       }else{ 
            return response()->json([
            'message'   => "Sorry, you can't make new vacation as you take all vacations assigned by system",
            'response' => 'error' 
           ]);
        } 
  }
 
    public function show($id)
    {
        $employee_vacation_request = Employee_vacation_request::where('id', $id)->first();
        return view("employees.show")->with('employee_vacation_request', $employee_vacation_request);
    }

    public function edit($id)
    { 
        $employee_vacation_request = Employee_vacation_request::where('id', $id)->first(); 
        if($employee_vacation_request === null)
        {
            return redirect()->back();
        }
          
          return view('employees.edit')->with('employee_vacation_request', $employee_vacation_request);
        
    }
 
    public function update(Request $request, $id)
    {
       
        $employee_vacation_request = Employee_vacation_request::find($id);
        $this->validate($request, [
            'vacation_from'=>'required|date', 
            'vacation_to'=>'required|date' ,
            'vacation_type'=>'required' 
          
        ]);
 
        $employee_vacation_request->request_id=$request->request_id;  
        $employee_vacation_request->vacation_from=$request->vacation_from; 
        $employee_vacation_request->vacation_to=$request->vacation_to;   
        $employee_vacation_request->reason=$request->reason; 
        $employee_vacation_request->vacation_type= $request->vacation_type;  
        $employee_vacation_request->save();
        
        return response()->json([
            'message'   => 'Vacation request Updated Successfully',
            'response' => 'success' 
          ]);
        
    }
 
    public function destroy($id)
    {
        $employee_vacation_request = Employee_vacation_request::where('id', $id);
        $employee_vacation_request->delete();
        return redirect()->back();
    }

}
