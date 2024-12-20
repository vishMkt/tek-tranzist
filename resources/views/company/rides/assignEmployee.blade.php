@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

                <!--invoice table  -->
                <div class=" d-flex flex-wrap justify-content-between mb-4">
                    <h5 class="top_title">{{ $nav }}</h5>
                    
                </div>

                <!-- table  --> 
                        <div class="card-body p-0 overflow-hidden "> 
                        <div class="table-responsive custom-scrollbar mb-4">
                        <form method="post" class="bg-white rounded" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" value="{{ $id }}" name="ride_id">
                        @csrf
                        <div class="mb-4">
                            <div class="p-4">
                                <div class="row">
                                    <!-- License Number -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employee_id">Employee<sup class="text-danger">*</sup></label> 
                                            <select name="employee_id[]" id="employee_id" class="form-control select2" multiple>
                                                <option value="">--Choose--</option>
                                                @foreach($users as $user)
                                                    <option  value="{{ $user->id }}">{{ $user->firstname .' '. $user->lastname}}</option>
                                                @endforeach
                                            </select>
                                        </div> 
                                    </div> 

                                    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bookingType">Booking Type<sup class="text-danger">*</sup></label> 
                                    <select name="bookingType" id="bookingType" class="form-control select2" onchange="selectShift(this)">
                                        <option value="">--Choose--</option>
                                        <option value="1">Shift</option>
                                        <option value="2">Add Off Booking</option>
                                    </select>
                                </div> 
                            </div>  
                            <div class="col-md-6 mt-4 homeToOfficeLabel d-none">
                            <div class="form-group">
                                    <p for="home_to_office" class="fw-bolder">Home To Office</p>  
                                </div> 
                                <div class="form-group">
                                    <label for="home_to_office_pick">Pick up Time<sup class="text-danger">*</sup></label> 
                                <input type="time" name="home_to_office_pick" class="form-control">
                                </div> 
                            </div> 
                            <div class="col-md-6 mt-4 OfficeToHomeLabel d-none">
                            <div class="form-group">
                                    <p for="office_to_home" class="fw-bolder">Office To Home</p>  
                                </div> 
                                <div class="form-group">
                                    <label for="office_to_home_pick">Pick up Time<sup class="text-danger">*</sup></label> 
                                <input type="time" name="office_to_home_pick" class="form-control">
                                </div> 
                            </div> 
                            <div class="col-md-6 mt-4 addOffTimeLabel d-none"> 
                                <div class="form-group">
                                    <label for="add_off_pick_up_time">Pick up Time<sup class="text-danger">*</sup></label> 
                                <input type="time" name="add_off_pick_up_time" class="form-control">
                                </div> 
                            </div>  
                           <div class="col-md-6 mt-4">
                            <div class="form-group">
                                <label for="days">Date<sup class="text-danger">*</sup></label> 
                                <input type="text" class="form-control" name="daterange"   />
                            </div> 
                        </div>  
                                    </div>
                                    <div class="my-4">
                                    <a href="{{ route('company.rides') }}" class="btn btn-danger">Back</a>
                                    <button type="submit" class="btn btn-primary">Save <i class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button> 
                                    </div> 
                                </div> 
                                
                            </div>
                           
                        </div>
                        
                    </div> 
                    
                </form>
             </div> 
            </div>
        </div> 
      
@endsection 
@section('page-script') 
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
      
      $(document).ready(function() { 
        $('.select2').select2(); 
    });
 
    $(function() {
  $('input[name="daterange"]').daterangepicker();
});
    
function form_submit1(e)
	{

	$(e).find('.st_loader').show();
	$.ajax({  
	  url :"{{ route('company.add.employee') }}",  
	  method:"POST",  
	  dataType:"json",  
	  data:$(e).serialize(),
	   success: function(data){ 
            if(data.status==1){
              toastr.success(data.message,'Success');
              $(e).find('.st_loader').hide();
              
                $('#modal-md').modal('hide');
                $('#modal-md .modal-content').html('') 
                window.location.href = "{{ route('company.rides') }}";
            }else if(data.success==0){
              toastr.error(data.message,'Error');
              $(e).find('.st_loader').hide();
            }
          },
          error: function(data){ 
            if(typeof data.responseJSON.status !== 'undefined'){
              toastr.error(data.responseJSON.error,'Error');
            }else{
              $.each(data.responseJSON.errors, function( key, value ) {
                  toastr.error(value,'Error');
              });
            }
            $(e).find('.st_loader').hide();
          } 
	}); 
	}


function selectShift(e){ 
    if(e.value == 1){
        $('.homeToOfficeLabel').removeClass('d-none');
        $('.OfficeToHomeLabel').removeClass('d-none');
        $('.addOffTimeLabel').addClass('d-none'); 

    }else{ 
        $('.homeToOfficeLabel').addClass('d-none');
        $('.OfficeToHomeLabel').addClass('d-none');
        $('.addOffTimeLabel').removeClass('d-none'); 
    }
}
</script>

@endsection