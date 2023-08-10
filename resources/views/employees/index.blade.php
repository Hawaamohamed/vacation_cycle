@extends('layouts.app')   
    
@section('content')
 
  <div class="container">
    {{-- prVGyc)%GuZD(wFSLe4j    --}}
    <div class="row">
        <div class='col-12'>
            <div class=" headerarea another-grid employees-active">
            <div class="col-3 title">
               
                <button class="btn btn-sm btnheader mt-15"  data-target="#NewEmployee" data-toggle="modal">New Employee</button>
            </div>
            <div class="col-6 searchbox">
                
            @if($employees->count() > 0)
                <input type="text" placeholder="search" class="search input-search input-search-employee" name="search">
            @endif
            </div>
            <div class="col-3 text-right translate-y"> 
                <button class="btn btn-sm btnheader mt-15"  data-target="#Newofficialholiday " data-toggle="modal">New official holiday</button>
            
            </div>
        </div>
      </div>
    </div>



   @if($employees->count() > 0)
    <div class="row">
     <div class="col-12">
         
          <table class="table table-bordered table-responsive-sm  mt-10">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Employee</th>
                    <th scope="col">Job Title</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Hiring Date</th>
                    <th scope="col">Actions</th>
                <tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($employees as $employee) 
                   
                    <tr>
                        <th scope="row">{{ $i++ }} </th>
                        <td><a href="{{ route('employees.show', $employee->slug) }}" class='btn-link '>{{ $employee->name }} </a></td>
                        <td>{{ $employee->job_title}}</td>  
                        <td>{{ $employee->email}}</td>  
                        <td>{{ $employee->phone }}</td>    
                        <td>{{ $employee->hiring_date}}</td> 
                        <td> 
                           @if ($employee->user_id == Auth::id())
                           <div class="dropdown">
                                <i class=" dropdown-toggle fa fa-ellipsis-h" aria-hidden="true" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                
                                </i>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="dropdown-item">Edit</a>
                                <a class="dropdown-item"  data-target="#DeleteEmployee{{ $employee->id }}" data-toggle="modal">Delete</a>
                                
                                </div>
                            </div> 
                             
                            <!-- Modal delete employee -->
                            <div class="modal fade" id="DeleteEmployee{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete {{ $employee->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    Are you sure that you want to delete Employee {{ $employee->name }}?
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="{{ route('employees.destroy', $employee->id) }}" class='btn btn-danger'>Yes</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    
                @endforeach
            </tbody>
          </table>
           
         {!! $employees->links() !!}
        
     </div>
    </div>

    @else
    <div class="row">
     <div class="col-sm-12">
          <div class="alert alert-info">No Employee Exist Yet</div>
     </div>
    </div>
   @endif


                             
    <!-- Modal add New employee -->
    <div class="modal fade" id="NewEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add New Employee</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form method="post"  id="new_employee" action="{{ route('employees.store') }}" class="pt-20" enctype="multipart/form-data">
                        
              <div class="modal-body">
                  
 
                {{ csrf_field() }}  @method('POST')
        
                <div class="row">
            
                        <div class="col-6">
                            <label class="pure-material-textfield-outlined">
                                <input type="text" name="name" required class="form-control" placeholder=" " dir="auto">
                                <span> Name</span>
                            </label> 
                        </div>
                                
                
                        <div class="col-6">
                            <label class="pure-material-textfield-outlined">
                                <input type="text" name="job_title" required class="form-control" placeholder=" " dir="auto">
                                <span>Job Title</span>
                            </label> 
                        </div>
            
            
            
                        <div class="col-6">
                            <label class="pure-material-textfield-outlined">
                                <input type="email" name="email" class="form-control" placeholder=" " dir="auto" required>
                                <span> Email</span>
                            </label> 
                        </div> 
                                    
                        <div class="col-6"> 
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
                                    <input type="text" name="phone" class="form-control phone" pattern="[+0-9]+" title="Enter only Numbers" placeholder=" "   dir="auto">
                                        <span>Phone</span>
                                    </label>
                                </div>
                                <ul class="country_code_list d-none"></ul>
                            </div>
                            </div>
                                
                            
                
                        
                        <div class="col-6">
                            <label class="pure-material-textfield-outlined">
                                <input type="text" name="address" class="form-control" placeholder=" " dir="auto">
                                <span>Address</span>
                            </label> 
                        </div>
                        <div class="col-6">
                            <label class="pure-material-textfield-outlined">
                                <input type="date" name="hiring_date" required class="form-control" placeholder=" " dir="auto">
                                <span>Hiring date</span>
                            </label> 
                        </div>
                    
                            
                        
                        <div class="col-6">
                            <label class="pure-material-textfield-outlined">
                                <input type="date" name="birthday" class="form-control" placeholder=" " dir="auto">
                                <span>Birthday</span>
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




   </div>
          
    
                             
    <!-- Modal add New  official holiday -->
    <div class="modal fade" id="Newofficialholiday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add New Official Holiday</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form method="post"  id="new_officialholiday" action="{{ route('countryofficialholidays.store') }}" class="pt-20" enctype="multipart/form-data">
                        
              <div class="modal-body"> 
 
                {{ csrf_field() }}  @method('POST')
        
                   <div class="row">
            
                        <div class="col-6">
                            <label class="pure-material-textfield-outlined">
                                <input type="date" name="official_holiday_date" required class="form-control" placeholder=" " dir="auto">
                                <span> Official holiday date</span>
                            </label> 
                        </div>
                        <div class="col-6">
                            <label class="pure-material-textfield-outlined">
                                <input type="text" name="holiday_name" required class="form-control" placeholder=" " dir="auto">
                                <span> Holiday Name</span>
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
    $(document).ready(function(){ console.log("new_employee");
    
        //Add employee
        $('#new_employee').on('submit', function(event){
            event.preventDefault();
            var url = $("#new_employee").attr('action');
             
            $("form#new_employee button[type='submit']").css({'pointer-events':'none', 'opacity': '.3'});
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
                    $("form#new_employee button[type='submit']").css({'pointer-events':'auto', 'opacity': '1'});
                    if(data.response == 'success')
                    {

                        $("#new_employee")[0].reset(); 
                          console.log(data.message);
                        $("#success-modal").removeClass("d-none").addClass("display-flex");
                        $("#success-modal .modal-body p").text(data.message);
                        $("table tbody").append(data.output);

                    }else{ 
                         
                        $("#error-modal").removeClass("d-none").addClass("display-flex");
                        $("#error-modal .modal-body ul").html(data.message);

                    }
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
        });


        //Add  officialholiday
        $('#new_officialholiday').on('submit', function(event){
            event.preventDefault();
            var url = $("#new_officialholiday").attr('action');
             
            $("form#new_officialholiday button[type='submit']").css({'pointer-events':'none', 'opacity': '.3'});
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
                    $("form#new_officialholiday button[type='submit']").css({'pointer-events':'auto', 'opacity': '1'});
                    if(data.response == 'success')
                    {

                        $("#new_officialholiday")[0].reset(); 
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
                        $("form#new_officialholiday button[type='submit']").css({'pointer-events':'auto', 'opacity': '1'});
     
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
    $("input.input-search-employee").on("keyup", function(){
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
   
@endsection
