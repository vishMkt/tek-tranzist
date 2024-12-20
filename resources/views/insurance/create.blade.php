<form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h3 class="modal-title mb-3 text-center" id="">Add Insurance</h3>
            <div class="row">
                <!-- License Number -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="policy_number">Policy Number<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="policy_number">
                        </div>
                    </div>
                </div>         
                <!-- Issue Date -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="provider">Provider<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="provider">
                        </div>
                    </div>
                </div>      
                <!-- Valid Upto -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="issue_date">Issue Date<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" name="issue_date">
                        </div>
                    </div>
                </div>  

                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="expiry_date">Expiry Date<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" name="expiry_date">
                        </div>
                    </div>
                </div> 
                <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label class="mb-2" for="drivers">Driver<sup class="text-danger">*</sup></label> 
                    <select name="driver_id" id="drivers" class="form-control">
                        <option value="">--Choose--</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->firstname .' '. $driver->lastname}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10">
                                <label class="mb-2" for="drivers" >Front Image<sup class="text-danger">*</sup></label> 
                                    <input type="hidden" id="imageId" name="image_id" value="">
                                    <input type="file" name="file" id="imageUrl" class="form-control mb-4"
                                        onchange="uploadfrontImage('#step_one')">

                                </div>
                                <div class="col-md-2">
                                    <img src="" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail"
                                        style="display:none; width:80px; height:80px;">
                                    <div id="uploadLoader" class="spinner-border text-primary" role="status"
                                        style="display: none;">
                                        <span class="visually-hidden">Uploading...</span>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        
            <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10">
                                <label class="mb-2" for="drivers" >Back Image<sup class="text-danger">*</sup></label> 
                                    <input type="hidden" id="imageId_back" name="image_id_back" value="">
                                    <input type="file" name="file_back" id="imageUrl_back" class="form-control mb-4"
                                        onchange="uploadbackImage('#step_one')">

                                </div>
                                <div class="col-md-2">
                                    <img src="" alt="Uploaded Image" id="uploadedImage_back" class="img-thumbnail"
                                        style="display:none; width:80px; height:80px;">
                                    <div id="uploadLoader_back" class="spinner-border text-primary" role="status"
                                        style="display: none;">
                                        <span class="visually-hidden">Uploading...</span>
                                    </div>
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
	  url :"{{ route('store.insurance') }}",  
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

    function uploadfrontImage(form) {   
  $(form).find('#uploadLoader').show();
    const formData = new FormData($(form)[0]);
    $.ajax({
        type: "POST",
        url: '{{ route("image.upload") }}', 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, 
        contentType: false,       
        cache: false,             
        processData: false,
        dataType: "json",
        data: formData, 
        success: function(response) { 
            if (response.success) {
                $('#imageId').val(response.image_id); 
                $('#uploadedImage').attr('src', response.image_url);
                $('#uploadedImage').css('display', 'block');
                
            } else {
            }
            $(form).find('#uploadLoader').hide();
        },
        error: function(xhr, status, error) {
            toastr.error('An error occurred while uploading the image.', 'Error');
        }
    });
}


function uploadbackImage(form) {   
  $(form).find('#uploadLoader_back').show();
    const formData = new FormData($(form)[0]);
    $.ajax({
        type: "POST",
        url: '{{ route("image.upload_back") }}', 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, 
        contentType: false,       
        cache: false,             
        processData: false,
        dataType: "json",
        data: formData, 
        success: function(response) { 
            if (response.success) {
                $('#imageId_back').val(response.image_id_back); 
                $('#uploadedImage_back').attr('src', response.image_url_back);
                $('#uploadedImage_back').css('display', 'block');
                
            } else {
            }
            $(form).find('#uploadLoader_back').hide();
        },
        error: function(xhr, status, error) {
            toastr.error('An error occurred while uploading the image.', 'Error');
        }
    });
}
</script>
