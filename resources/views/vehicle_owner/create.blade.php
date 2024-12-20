@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">Add Vehicle Owner</h5>
        </div>
        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body  px-4 py-4">
            <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <div class="p-4"> 
            <div class="row">
                <!-- First Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="firstname">First Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="firstname">
                        </div>
                    </div>
                </div>

                <!-- Last Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="lastname">Last Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="lastname">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="email">Email<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>
                </div>

                <!-- Phone Number with Country Code -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="mobile">Phone Number<sup class="text-danger">*</sup></label>
                        <input type="tel" name="mobile" id="mobile" class="form-control" placeholder="Enter Phone Number">
                        <input type="hidden" name="country_code" id="country_code">
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="vendors">Vendor<sup class="text-danger">*</sup></label> 
                        <select name="vendor" id="vendors" class="form-control">
                            <option value="">--Choose--</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->firstname}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="drivers">Status<sup class="text-danger">*</sup></label> 
                    <select name="status" id="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">In Active</option>
                    </select>
                </div>
            </div> 

                <div class="col-12 mb-4">
                    <div class="form-group">
                        <label for="password_confirmation">Address<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="address"> 
                        </div>
                    </div>
                </div>

                
          
            <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-3">Save <i class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
                    <a href="{{ route('vehicle.owner')}}" class="btn btn-light border  m-0">Back</a>
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
  
<script>
function form_submit1(e)
	{

	$(e).find('.st_loader').show();
	$.ajax({  
	  url :"{{ route('store.vehicle.owner') }}",  
	  method:"POST",  
	  dataType:"json",  
	  data:$(e).serialize(),
	   success: function(data){ 
            if(data.status==1){
              toastr.success(data.message,'Success');
              $(e).find('.st_loader').hide();
              
                $('#modal-md').modal('hide');
                $('#modal-md .modal-content').html('') 
                window.location.href = "{{ route('vehicle.owner') }}";
               
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

@endsection
