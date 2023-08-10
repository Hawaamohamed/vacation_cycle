<?php

namespace App\Http\Controllers;

use App\Country_official_holidays_dates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class CountryOfficialHolidaysDatesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        $vacations = Country_official_holidays_dates::latest()->paginate(25);
        return view('vacations.index')->with('vacations', $vacations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
        return view('vacations.create');
    }
 
    public function store(Request $request)
    {
       
        $validate = $this->validate($request, [
            'official_holiday_date'=>'required', 
            'holiday_name'=>'required'
     ]); 
        $check_vacation = Country_official_holidays_dates::where('official_holiday_date', $request->official_holiday_date)->where('holiday_name', $request->holiday_name);
        if($check_vacation->count() == 0)
        {
      
        $vacation = new Country_official_holidays_dates;  
        $vacation->official_holiday_date=$request->official_holiday_date;  
        $vacation->holiday_name=$request->holiday_name;  
        $vacation->user_id  = Auth::id() ;
        $vacation->save();
      
 

    // if(!is_null($validate))
    // {
        return response()->json([
            'message'   => 'Official Holiday Added Successfully',
            'response' => 'success'  
          ]);
    //} 
    }else{
    
        return response()->json([
        'message'   => 'This Official Holiday already Added ',
        'response' => 'error' 
      ]);
    }
    
     
    }

    
    public function show(Country_official_holidays_dates $country_official_holidays_dates)
    {
        $vacation = Country_official_holidays_dates::where('slug', $slug)->first();
        return view("vacations.show")->with('vacation', $vacation);
    }

    public function edit($id)
    { 
        $vacation = Country_official_holidays_dates::where('id', $id)->first(); 
        if($vacation === null)
        {
            return redirect()->back();
        }
          
          return view('vacations.edit')->with('vacation', $vacation);
        
    }
 
    public function update(Request $request, $id)
    {
       
        $vacation = Country_official_holidays_dates::find($id);
        $this->validate($request, [
            'official_holiday_date'=>'required', 
            'holiday_name'=>'required|email'  
          
        ]);  
 
        
        $vacation->official_holiday_date=$request->official_holiday_date;  
        $vacation->holiday_name=$request->holiday_name;  
        $vacation->save();
        
        return response()->json([
            'message'   => 'vacation Updated Successfully',
            'response' => 'success' 
          ]);
        
    }
 
    public function destroy($id)
    {
        $vacation = Country_official_holidays_dates::where('id', $id);
        $vacation->delete();
        return redirect()->back();
    }

}
