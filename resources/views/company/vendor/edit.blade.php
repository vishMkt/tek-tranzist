<form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $uinfo->id }}">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h4 class="modal-title mb-3 text-center" id="">Edit Vendor</h4>
            <div class="row">
                <!-- First Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="firstname">First Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="firstname" value="{{ $uinfo->firstname }}">
                        </div>
                    </div>
                </div>

                <!-- Last Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="lastname">Last Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="lastname" value="{{ $uinfo->lastname }}">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="email">Email<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" name="email" value="{{ $uinfo->email }}">
                        </div>
                    </div>
                </div>

                <!-- Phone Number with Country Code -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="mobile">Phone Number<sup class="text-danger">*</sup></label>
                        <input type="tel" name="mobile" id="mobile" class="form-control" placeholder="Enter Phone Number"  value="{{ $uinfo->mobile }}">
                        <input type="hidden" name="country_code" id="country_code">
                    </div>
                </div>

                <!-- Password -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="password">Password<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="password_confirmation">Password Confirm<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                </div>  
                <div class="col-12 mb-4">
                    <div class="form-group">
                        <label for="password_confirmation">Address<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="address" id="project_lookup">
                            <input type="hidden" class="form-control" name="lat">
                            <input type="hidden" class="form-control" name="long">
                        </div>
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
   
    
 
function form_submit1(e)
	{

	$(e).find('.st_loader').show();
	$.ajax({  
	  url :"{{ route('update.vendor') }}",  
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
