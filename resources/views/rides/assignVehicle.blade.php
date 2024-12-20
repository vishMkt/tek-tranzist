 
<form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" value="{{ $id }}" name="ride_id">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h3 class="modal-title mb-3 text-center" id="">Add Vehicle</h3>
            <div class="row">
                <!-- First Name -->
                <div class="col-md-6">
                <div class="form-group">
                    <label for="vehicle_id">Vehicle<sup class="text-danger">*</sup></label> 
                    <select name="vehicle_id" id="vehicle_id" class="form-control select2">
                        <option value="">--Choose--</option>
                        @foreach($vehicles as $vehicle)
                            <option  value="{{ $vehicle->id }}">{{ $vehicle->Make->name .' '.$vehicle->ModelVehicle->name }}</option>
                        @endforeach
                    </select>
                </div> 
            </div>   
             <div class="col-md-6">
                <div class="form-group">
                    <label for="driver_id">Driver<sup class="text-danger">*</sup></label> 
                    <select name="driver_id" id="driver_id" class="form-control select2">
                        <option value="">--Choose--</option>
                        @foreach($drivers as $driver)
                            <option  value="{{ $driver->id }}">{{ $driver->firstname .' '. $driver->lastname    }}</option>
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
	  url :"{{ route('vendor.add.vehicle') }}",  
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
