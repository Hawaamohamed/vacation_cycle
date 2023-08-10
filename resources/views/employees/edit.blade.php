@extends('layouts.app')   
    
@section('content')
    
@if(count($errors->all())>0)
<div class="alert alert-danger">
 <ul>
   @foreach($errors->all() as $e)
     <li>{{$e}}</li>
   @endforeach
 </ul>
</div>
@endif
 

@if($message = Session()->get('success')) 
<div class='alert alert-success'> {{$message}} </div>
@endif
 


 <div class="container whiteback   m-t-2">

   <div class="row">
      
    <div class="col-12 h4-tit b-bottom-1 no-padding">
        <h4 class="form-title"> Edit Employee</h4>
    </div>
     
 
        <form method="post" novalidate  id="edit_employee" action="{{ route('employees.update', $employee->id) }}" class="pt-20 pb-20" enctype="multipart/form-data">
                    
         {{ csrf_field() }}  @method('POST')
 
         <div class="row">

            <div class="col-3">
                <label class="pure-material-textfield-outlined">
                    <input type="text" name="name" required class="form-control" placeholder=" " dir="auto" value="{{ $employee->name }}">
                    <span> Name</span>
                </label> 
            </div>
                  
 
            <div class="col-3">
                <label class="pure-material-textfield-outlined">
                    <input type="text" name="job_title" class="form-control" placeholder=" " dir="auto" value="{{ $employee->job_title }}">
                    <span>Job Title</span>
                </label> 
            </div>



            <div class="col-3">
                <label class="pure-material-textfield-outlined">
                    <input type="email" name="email" class="form-control" placeholder=" " dir="auto" required value="{{ $employee->email }}">
                    <span> Email</span>
                </label> 
            </div> 
                       
            <div class="col-3"> 
                <div class='row'>
                   <div class="col-4 col-4" style=" padding: 0;">
                     <label class="pure-material-textfield-outlined">
                       <input type="text" readonly name="phone_country_code" class="country_code" value="" required placeholder=" ">
                       
                       <span>Code</span>
                    </label>
                    <span class="glyphicon glyphicon-menu-down"></span>
                   </div>
                   <div class="col-8 col-8" style=" padding: 0;">
                       <label class="pure-material-textfield-outlined">
                       <input type="text" name="phone" class="form-control phone" pattern="[+0-9]+" title="Enter only Numbers" placeholder=" "   dir="auto" value="{{ $employee->phone }}">
                           <span>Phone</span>
                       </label>
                   </div>
                   <ul class="country_code_list d-none"></ul>
                </div>
               </div>
                 
              
 
          
            <div class="col-3">
                <label class="pure-material-textfield-outlined">
                    <input type="text" name="address" class="form-control" placeholder=" " dir="auto" value="{{ $employee->address }}">
                    <span>Address</span>
                </label> 
            </div>
            <div class="col-3">
                <label class="pure-material-textfield-outlined">
                    <input type="date" name="hiring_date"  class="form-control" placeholder=" " dir="auto" value="{{ $employee->hiring_date }}">
                    <span>Hiring date</span>
                </label> 
            </div>
        
             
            
            <div class="col-3">
                <label class="pure-material-textfield-outlined">
                    <input type="date" name="birthday" class="form-control" placeholder=" " dir="auto" value="{{ $employee->birthday }}">
                    <span>Birthday</span>
                </label> 
            </div>
            
            
        </div>
         
        
        <div class="row "> 
            <div class=" col-12">
              
              <button type="submit" class="btn bg-black color-white float-right">
                <span class="spinner-border d-none spinner-border-sm" role="status" aria-hidden="true"></span>
               Submit
              </button> 
              
            </div>
        </div>
       </form>
    </div>
  </div>
    
 </div>
         
        
           
        
 <script>
    $(document).ready(function(){ console.log("edit_employee");

        //Add POST
        $('#edit_employee').on('submit', function(event){
            event.preventDefault();
            var url = $("#edit_employee").attr('action');
             
            $("form#edit_employee button[type='submit']").css({'pointer-events':'none', 'opacity': '.3'});
            $(".spinner-border").removeClass("d-none");
            j=0;
            $.ajax({
                url:url,
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {  
                    $("input").css('border',"solid 1px");
                    $(".spinner-border").addClass("d-none");
                    $("form#edit_employee button[type='submit']").css({'pointer-events':'auto', 'opacity': '1'});
                    if(data.response == 'success')
                    {
 
                          console.log(data.message);
                        $("#success-modal").removeClass("d-none").addClass("display-flex");
                        $("#success-modal .modal-body p").text(data.message);

                    }else{ 
                         
                        $("#error-modal").removeClass("d-none").addClass("display-flex");
                        $("#error-modal .modal-body ul").html(data.message);

                    }
                },
                error:function(data,exception){
                   
                        $(".spinner-border").addClass("d-none");
                        $("form#edit_employee button[type='submit']").css({'pointer-events':'auto', 'opacity': '1'});
     
                        var response = $.parseJSON(data.responseText);
                        var listError = "";
                        
                        $.each(response.errors, function(k,v){
                          listError +="<li>"+v+"</li>";
                          $("input[name='"+k+"']").css('border',"2px solid #d31a1a");
                        });  
                   
                        $("#error-modal").removeClass("d-none").addClass("display-flex");
                        $("#error-modal .modal-body ul").html(listError); 
                   
                }
            })
        });



    });

   </script>



@endsection