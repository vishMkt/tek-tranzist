@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">View Vehicle Owner</h5>
        </div>
        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body  px-4 py-4">
            <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $uinfo->id }}">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h3 class="modal-title mb-3 text-center">Vehicle Owner</h3>
            <div class="row">
                <!-- First Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="firstname">First Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="firstname" value="{{ $uinfo->firstname}}">
                        </div>
                    </div>
                </div>

                <!-- Last Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="lastname">Last Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="lastname" value="{{ $uinfo->lastname}}">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="email">Email<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="email" readonly class="form-control" name="email" value="{{ $uinfo->email}}">
                        </div>
                    </div>
                </div>

                <!-- Phone Number with Country Code -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="mobile">Phone Number<sup class="text-danger">*</sup></label>
                        <input type="tel" readonly name="mobile" id="mobile" class="form-control" placeholder="Enter Phone Number" value="{{ $uinfo->mobile}}">
                        <input type="hidden" name="country_code" id="country_code" >
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="status">Status<sup class="text-danger">*</sup></label> 
                    <select name="status" id="status" readonly class="form-control">
                        <option @if($uinfo->status == 1) selected @endif value="1">Active</option>
                        <option @if($uinfo->status == 0) selected @endif value="0">In Active</option>
                    </select>
                </div>
                  </div> 

      
                <div class="col-12 mb-4">
                    <div class="form-group">
                        <label for="password_confirmation">Address<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="address" value="{{ $uinfo->address }}"> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
    <a href="{{ route('vendor.vehicle.owner')}}" class="btn btn-light border  m-0">Back</a>
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
  
<script>
function form_submit1(e)
	{

	$(e).find('.st_loader').show();
	$.ajax({  
	  url :"{{ route('vendor.update.vehicle.owner') }}",  
	  method:"POST",  
	  dataType:"json",  
	  data:$(e).serialize(),
	   success: function(data){ 
            if(data.status==1){
              toastr.success(data.message,'Success');
              $(e).find('.st_loader').hide();
              
                $('#modal-md').modal('hide');
                $('#modal-md .modal-content').html('') 
                window.location.href = "{{ route('vendor.vehicle.owner') }}";
               
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
