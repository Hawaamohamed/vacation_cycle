@extends('layouts.app')   
    
@section('content')
@php
                   
$date1 = strtotime($employee->hiring_date);
$date2 = strtotime(date("Y-m-d")) ;
$diff = abs($date2 - $date1);
$years = floor($diff / (365*60*60*24));   
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$total_vacations = 0;
for($year = 0 ;$year <= $years; $year++)
{ 
  $total_vacations_in_year = ($year > 10 or ($year == 10 && $months > 0)) ? 30 : 21 ;
  $total_vacations+= $total_vacations_in_year; 
}
@endphp 
  
 
@php
 
$date1 = strtotime("2012-01-01");
$date2 = strtotime("2022-01-01") ;
$diff = abs($date2 - $date1);
$years = floor($diff / (365*60*60*24)); 
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$total_vacation_requests_based_on_hiring_date = 0;
$total_vacation_requests_this_year = 0;
$days_number = 0;
@endphp 

@foreach ($employee_vacation_requests as $employee_vacation_request)
@php
    $start_month = date("m", strtotime($employee->hiring_date)); 
    
      if($start_month == 1)
      {
        $end_month = 12;
      }else{
        $end_month = $start_month - 1;
      }
      $days_number = date_diff(date_create($employee_vacation_request->vacation_from), date_create($employee_vacation_request->vacation_to))->format('%d');
      
    $from_month = date("m", strtotime($employee_vacation_request->vacation_from));
    $to_month = date("m", strtotime($employee_vacation_request->vacation_to));
   
    $from_year = date("Y", strtotime($employee_vacation_request->vacation_from));
    $to_year = date("Y", strtotime($employee_vacation_request->vacation_to));

    
    $start_day = date("d", strtotime($employee->hiring_date));

    $this_year = date("Y");
    $prev_year = date("Y") - 1;
    $next_year = date("Y") + 1; 
    if(date($employee_vacation_request->vacation_from) > date($prev_year."-".$start_month."-" . $start_day) && date($employee_vacation_request->vacation_to) < date($next_year . "-" . $start_month . "-" . $start_day)) 
    {  
      $total_vacation_requests_this_year+= (int)$days_number;

    }  

@endphp 
@endforeach
@php 
       $total_vacation_requests_based_on_hiring_date+= (int)$days_number;
       $remining_days = $total_vacations - $total_vacation_requests_based_on_hiring_date; 
@endphp       

{{ Session::put('total_vacations', $total_vacations) }} 
{{ Session::put('total_vacation_requests_based_on_hiring_date', $total_vacation_requests_based_on_hiring_date) }} 
 
  <div class="container"> <br> 
    <div class="row">
        <div class='col-12'>
            <div class=" headerarea another-grid employees-active">
            <div class="col-3 title">
                 Vacations History
            </div>
            <div class="col-6 searchbox">
                
            </div>
            <div class="col-3 text-right translate-y"> 
                @if ( Auth::user()->type == 'employee' && Auth::user()->employee_id == $employee->id)
                  <button class="btn btn-sm btnheader mt-15" data-target="#vacationRequest" data-toggle="modal">New Request</button>
                @endif
            </div>
        </div>
      </div>
    </div>

     <div class="row"> 
        <div class='col-sm'> 
            <div class="card" >
                <div class="card-body text-center">
                <h6 class="card-title">Total Vacations based on Hiring date </h6>
                <p class="card-text">{{ $total_vacations }}</p>
                </div>
            </div>
        </div>
        <div class='col-sm'>
            <div class="card" >
                <div class="card-body text-center">
                <h6 class="card-title">Total Token days based on Hiring date</h6>
                <p class="card-text">{{ $total_vacation_requests_based_on_hiring_date }}</p>
                </div>
            </div>
        </div>
        <div class='col-sm'>
            <div class="card" >
                <div class="card-body text-center">
                <h6 class="card-title">Remining days based on Hiring date </h6>
                <p class="card-text">{{ $remining_days }}</p>
                </div>
            </div>
        </div>
 
    </div>


   @if($employee_vacation_requests->count() > 0)
    <div class="row">
     <div class="col-12">
         
          <table class="table table-bordered table-responsive-sm mt-20">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Request id</th>
                    <th scope="col">Vacation from</th>
                    <th scope="col">Vacation to</th>
                    <th scope="col">Vacation type</th>
                    <th scope="col">Reason</th> 
                <tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($employee_vacation_requests as $employee_vacation_request) 
                   
                    <tr>
                        <th scope="row">{{ $i++ }} </th>
                        <td>{{ $employee_vacation_request->request_id }}  </td>
                        <td>{{ $employee_vacation_request->vacation_from}}</td>  
                        <td>{{ $employee_vacation_request->vacation_to}}</td>  
                        <td>{{ $employee_vacation_request->vacation_type }}</td>    
                        <td>{{ $employee_vacation_request->reason}}</td> 
                        
                    </tr>
                    
                @endforeach
            </tbody>
          </table> 
          {!! $employee_vacation_requests->links() !!}
     </div>
    </div>

    @else
    <div class="row">
     <div class="col-sm-12"><br>
          <div class="alert alert-info">No employee vacation requests Exist Yet</div>
     </div>
    </div>
   @endif

                           
    <!-- Modal add New vacation request -->
    <div class="modal fade" id="vacationRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Add New Vacation request</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <form method="post"  id="new_vacation_request" action="{{ route('employee_vacation_requests.store') }}" class="pt-20" enctype="multipart/form-data">
                          
                <div class="modal-body">
                    
   
                  {{ csrf_field() }}  @method('POST')
          
                  <div class="row">
              
                            <div class="col-6">
                                <label class="pure-material-textfield-outlined">
                                    <input type="text" readonly name="request_id" required class="form-control" placeholder=" " dir="auto" value="{{date('Ym'). ($employee_vacation_requests->count() + 1) }}">
                                    <span> request id</span>
                                </label> 
                            </div>
                                  
                  
                          <div class="col-6">
                              <label class="pure-material-textfield-outlined">
                                  <input type="date" name="vacation_from" required class="form-control" placeholder=" " dir="auto">
                                  <span>vacation from</span>
                              </label> 
                          </div>
              
              
              
                          <div class="col-6">
                              <label class="pure-material-textfield-outlined">
                                  <input type="date" name="vacation_to" required class="form-control" placeholder=" " dir="auto" required>
                                  <span>Vacation to</span>
                              </label> 
                          </div> 
                                      
                           
                  
                          <div class="col-6">
                              <div class="select">
                                  <select class="selectpicker select-text form-control" name="vacation_type"  > 
                                      <option value="">--Select--</option>
                                      <option value="Annual Vacation">Annual Vacation</option>
                                      <option value="Sudden Vacation">Sudden Vacation</option> 
                                  </select>
                                  <label class="select-label">Vacation type</label>
                                </div>
                               
                          </div>
                      
                          
                          <div class="col-12">
                              <label class="pure-material-textfield-outlined">
                                  <textarea type="text" row="5" name="reason" class="form-control" dir="auto"></textarea>
                                  <span>reason</span>
                              </label> 
                          </div>
                              
                      </div> 
                  
            
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn bg-black color-white float-right">
                          <span class="spinner-border d-none spinner-border-sm" role="status" aria-hidden="true"></span>
                         Submit
                      </button> 
                  </div> 
              
               </form>
  
              </div>
              </div>
        </div>
      
          
        
   <script>
    $(document).ready(function(){ console.log("new_employee_vacation_request");

        //Add POST
        $('#new_employee_vacation_request').on('submit', function(event){
            event.preventDefault();
            var url = $("#new_employee_vacation_request").attr('action');
             
            $("form#new_employee_vacation_request button[type='submit']").css({'pointer-events':'none', 'opacity': '.3'});
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
                    $("form#new_employee_vacation_request button[type='submit']").css({'pointer-events':'auto', 'opacity': '1'});
                    if(data.response == 'success')
                    {

                        $("#new_employee_vacation_request")[0].reset(); 
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
                        $("form#new_employee_vacation_request button[type='submit']").css({'pointer-events':'auto', 'opacity': '1'});
     
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

<script>

    /**************Search hr***************/
    $("input.input-search-employee_vacation_request").on("keyup", function(){
        var search = $(this).val();  
        $("ul.pagination").addClass("hidden");
        $.ajax({
            url:"{{URL::to('search')}}",
            type:"get",
            dataType:"text",
            data:{'search':search},  
            success:function(data)
            {  console.log(data);
               $("table tbody").html(data);
            },
            error:function(data,exception){
                   
                   $(".spinner-border").addClass("d-none");
                   $("form#new_employee button[type='submit']").css({'pointer-events':'auto', 'opacity': '1'});

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

    })
</script>  
   
<script>
    $(document).ready(function(){ 

        //Add POST
        $('#new_vacation_request').on('submit', function(event){
            event.preventDefault();
            var url = $("#new_vacation_request").attr('action');
             
            $("form#new_vacation_request button[type='submit']").css({'pointer-events':'none', 'opacity': '.3'});
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
                    $("form#new_vacation_request button[type='submit']").css({'pointer-events':'auto', 'opacity': '1'});
                    if(data.response == 'success')
                    {

                        $("#new_vacation_request")[0].reset(); 
                          console.log(data.message);
                          
                        $("#success-modal .modal-dialog").css("display", "block");
                        $("#success-modal").removeClass("d-none").addClass("display-flex");
                        $("#success-modal .modal-body p").text(data.message);

                    }else{ 
                         
                        $("#error-modal").removeClass("d-none").addClass("display-flex");
                        $("#error-modal .modal-body ul").html(data.message);

                    }
                },
                error:function(data,exception){
                   
                        $(".spinner-border").addClass("d-none");
                        $("form#new_vacation_request button[type='submit']").css({'pointer-events':'auto', 'opacity': '1'});
     
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
