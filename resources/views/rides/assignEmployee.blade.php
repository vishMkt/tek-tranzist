 
<form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" value="{{ $id }}" name="ride_id">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h3 class="modal-title mb-3 text-center" id="">Add employee</h3>
            <div class="row">
                <!-- First Name -->
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
                    <select name="bookingType" id="bookingType" class="form-control select2">
                        <option value="">--Choose--</option>
                        <option value="1">Shift</option>
                        <option value="2">Add Off Booking</option>
                    </select>
                </div> 
            </div>  
            <div class="col-md-6 mt-4">
            <div class="form-group">
                    <p for="home_to_office" class="fw-bolder">Home To Office</p>  
                </div> 
                <div class="form-group">
                    <label for="home_to_office_pick">Pick up Time<sup class="text-danger">*</sup></label> 
                 <input type="time" name="home_to_office_pick" class="form-control">
                </div> 
            </div> 
            <div class="col-md-6 mt-4">
            <div class="form-group">
                    <p for="office_to_home" class="fw-bolder">Office To Home</p>  
                </div> 
                <div class="form-group">
                    <label for="office_to_home_pick">Pick up Time<sup class="text-danger">*</sup></label> 
                 <input type="time" name="office_to_home_pick" class="form-control">
                </div> 
            </div> 
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label for="days">Days<sup class="text-danger">*</sup></label> 
                    <select name="days[]" id="days" class="form-control select2" multiple>
                        <option value="">--Choose--</option>
                        @foreach($days as $day)
                            <option  value="{{ $day->id }}">{{ $day->day }}</option>
                        @endforeach
                    </select>
                </div> 
            </div> 
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save <i class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
    </div>
</form>
 
<script>
      
      $(document).ready(function() {
        $('.select2').select2({
        dropdownParent: $('#modal-md .form-group')
    });
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
            //   location.reload();
                  dataTable.draw(true); 
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

</script>
