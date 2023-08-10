<?php 
namespace App\Http\Controllers;

use App\User; 
use App\Employee; 
use App\Employee_vacation_request;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        if(Auth::user()->type == 'admin')
        {
            $employees = Employee::where('user_id', Auth::id())->latest()->paginate(10);
            return view('employees.index')->with('employees', $employees);
        }
        return back();
    }
 
    public function create()
    { 
        return view('employees.create');
    }

     
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
                'name'=>'required', 
                'email'=>'required|email' ,
                'phone'=>'required',
                'hiring_date'=>'required' 
        ]); 
     $check_employee = Employee::where('email', $request->email)->where('phone', $request->phone);
     $check_employee_name = Employee::where('name', $request->name);
     if($check_employee_name->count() == 0)
     {
        
     if($check_employee->count() == 0)
     {
         
        if($request->has('image')){
            $image = $request->image;
            $newimage = time().$image->getClientOriginalName();
            $image->move('public/uploads/', $newimage);  
            
        }else{ $newimage = "";  }
 
            $employee = new Employee;
            $employee->image =  $newimage;
            $employee->slug = str_slug($request->name);
            $employee->name=$request->name;  
            $employee->hiring_date=$request->hiring_date; 
            $employee->birthday=$request->birthday;   
            $employee->email=$request->email; 
            $employee->phone=$request->phone_country_code.$request->phone; 
            $employee->address=$request->address; 
            $employee->job_title=$request->job_title;   
            $employee->user_id  = Auth::id();
            $employee->save();

            //add employee as a user
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->name); 
            $user->type = 'employee'; 
            $user->employee_id = $employee->id;
            $user->save();


 

            $output="";
            $output.="<tr><th scope='row'>" . "</th><td><a href='". route('employees.show', $employee->slug) ."' class='btn btn-link'>". $employee->name. "</a></td><td>". $employee->job_title ."</td><td>". $employee->email."</td><td>". $employee->phone ."</td><td>". $employee->hiring_date  ."</td><td>";
              
                  $output.=" <div class='dropdown'>
                  <i class='dropdown-toggle fa fa-ellipsis-h' aria-hidden='true' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                  
                  </i>
                  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                  <a href='". route('employees.edit', $employee->id) ."' class='dropdown-item'>Edit</a>
                  <a class='dropdown-item'  data-target='#DeleteEmployee". $employee->id ."' data-toggle='modal'>Delete</a>
                  
                  </div>
                 </div> 
                    <!-- Modal delete employee -->
                    <div class='modal fade'  id='DeleteEmployee". $employee->id ."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLongTitle'>Delete ". $employee->name ."</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>
                            <div class='modal-body'>
                            Are you sure that you want to delete Employee".  $employee->name ."?
                            </div>
                            <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                            <a href='". route('employees.destroy', $employee->id)  ."' class='btn btn-danger'>Yes</a>
                            </div>
                        </div>
                        </div>
                    </div>";
               
                   $output.="  </td>
            </tr>";
        
  
        // if(!is_null($validate))
        // {
            return response()->json([
                'message'   => 'Employee Added Successfully',
                'response' => 'success',
                'output' => $output
              ]);
        //} 
        }else{
        
            return response()->json([
            'message'   => 'This Email already exist ',
            'response' => 'error' 
          ]);
        }
        }else{
            
            return response()->json([
            'message'   => 'This Employee Name already exist ',
            'response' => 'error' 
        ]);
        }
        

    }
 
    public function show($slug)
    { 
        $employee = Employee::where('slug', $slug)->first(); 
        Session::put('employee_id', $employee->id);
        $employee_vacation_requests = Employee_vacation_request::where('employee_id', $employee->id)->get();
        return view("employees.show")->with('employee', $employee)->with('employee_vacation_requests', $employee_vacation_requests);
    }
 
    public function edit($id)
    { 
        $employee = Employee::where('id', $id)->first(); 
        if($employee === null)
        {
            return redirect()->back();
        }
          
          return view('employees.edit')->with('employee', $employee);
        
    }
 
    public function update(Request $request, $id)
    {
       
        $employee = Employee::find($id);
        $this->validate($request, [
            'name'=>'required', 
            'email'=>'required|email' ,
            'phone'=>'required' ,
            'hiring_date'=>'required'
          
        ]);

        if($request->has('image')){
            $image = $request->image;
            $newimage = time().$image->getClientOriginalName();
            $image->move('public/uploads/', $newimage);
            $employee->image = $newimage; 
        } 
 
        $employee->slug = str_slug($request->name);
        $employee->name=$request->name;  
        $employee->hiring_date=$request->hiring_date; 
        $employee->birthday=$request->birthday;   
        $employee->email=$request->email; 
        $employee->phone=$request->phone_country_code.$request->phone; 
        $employee->address=$request->address; 
        $employee->job_title=$request->job_title;   
        $employee->save();
        
        return response()->json([
            'message'   => 'Employee Updated Successfully',
            'response' => 'success' 
          ]);
        
    }


    public function upload_profile_image(Request $request)
    {
        $employee = Employee::find(Session::get('employee_id'));
        
        if($request->has('image')){
            $image = $request->image;
            $newimage = time().$image->getClientOriginalName();
            $image->move('public/uploads/', $newimage);
            $employee->image = $newimage; 
            $employee->save();
            
          return response()->json([
            'message'   => 'Employee Image Uploaded Successfully',
            'response' => 'success' 
          ]);
        }else{
        
            return response()->json([
            'message'   => 'Please Upload Right Image ',
            'response' => 'error' 
          ]);
        }

    }



    public function search(Request $request)
    {
      $employees = Employee::where('name','LIKE','%'.$request->search."%")->orwhere('hiring_date','LIKE','%'.$request->search."%")->orwhere('email','LIKE','%'.$request->search."%")->orwhere('phone','LIKE','%'.$request->search."%")->orwhere('job_title','LIKE','%'.$request->search."%")->get();
       
      if($employees->count() > 0)
      { 
        $output="";  $i = 1;
        foreach($employees as $employee) 
        {       
            $output.="<tr><th scope='row'>". $i++ ."</th><td><a href='". route('employees.show', $employee->slug) ."' class='btn btn-link'>". $employee->name. "</a></td><td>". $employee->job_title ."</td><td>". $employee->email."</td><td>". $employee->phone ."</td><td>". $employee->hiring_date  ."</td><td>";
            if ($employee->user_id == Auth::id())
            {  
                  $output.=" <div class='dropdown'>
                  <i class='dropdown-toggle fa fa-ellipsis-h' aria-hidden='true' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                  
                  </i>
                  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                  <a href='". route('employees.edit', $employee->id) ."' class='dropdown-item'>Edit</a>
                  <a class='dropdown-item'  data-target='#DeleteEmployee". $employee->id ."' data-toggle='modal'>Delete</a>
                  
                  </div>
                 </div> 
                    <!-- Modal delete employee -->
                    <div class='modal fade'  id='DeleteEmployee". $employee->id ."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLongTitle'>Delete ". $employee->name ."</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>
                            <div class='modal-body'>
                            Are you sure that you want to delete Employee".  $employee->name ."?
                            </div>
                            <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                            <a href='". route('employees.destroy', $employee->id)  ."' class='btn btn-danger'>Yes</a>
                            </div>
                        </div>
                        </div>
                    </div>";
               }
                   $output.="  </td>
            </tr>";
        
        }
         
            return response($output);
    }else{
        $output = "<tr><td colspan='100%' class='text-center'><b>Employee Not Exist</b></td></tr>";
        return response($output);
    }
        
    }


    public function destroy($id)
    {
        $employee = Employee::where('id', $id);
        $employee->delete();
        return redirect()->back();
    }

 
}