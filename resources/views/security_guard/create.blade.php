@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">Add Security Guard</h5>
        </div>
        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body  px-4 py-4">
            <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <div class="p-3"> 
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

                <!-- Mobile Number -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="mobile">Mobile Number<sup class="text-danger">*</sup></label>
                        <input type="tel" name="mobile" id="mobile" class="form-control" placeholder="Enter Phone Number">
                    </div>
                </div> 

                <!-- Status -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="status">Status<sup class="text-danger">*</sup></label> 
                        <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
 

                <!-- Assigned Location -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="assigned_location">Assigned Location<sup class="text-danger">*</sup></label>
                        <input type="text" name="assigned_location" class="form-control" maxlength="255">
                    </div>
                </div>

               
                <!-- Date of Joining -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="date_of_Joining">Date of Joining<sup class="text-danger">*</sup></label>
                        <input type="date" name="date_of_Joining" class="form-control">
                    </div>
                </div> 

                <!-- Emergency Contact Information -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="emergency_contact_information">Emergency Contact Information (Optional)</label>
                        <input type="text" name="emergency_contact_information" class="form-control" maxlength="255">
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
                                <label class="mb-2" for="drivers" >Add Attachment<sup class="text-danger">*</sup></label> 
                                    <input type="hidden" id="imageId_attachment" name="image_id_attachment" value="">
                                    <input type="file" name="file_attachment" id="imageUrl_attachment" class="form-control mb-4"
                                        onchange="uploadattachmentImage('#step_one')">

                                </div>
                                <div class="col-md-2">
                                    <img src="" alt="Uploaded Image" id="uploadedImage_attachment" class="img-thumbnail"
                                        style="display:none; width:80px; height:80px;">
                                    <div id="uploadLoader_attachment" class="spinner-border text-primary" role="status"
                                        style="display: none;">
                                        <span class="visually-hidden">Uploading...</span>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        
                <!-- Notes -->
                <div class="col-md-12 mb-4">
                    <div class="form-group">
                        <label for="notes">Address</label>
                        <textarea name="address" class="form-control" maxlength="500"></textarea>
                    </div>
                </div>

                <!-- Notes -->
                <div class="col-md-12 mb-4">
                    <div class="form-group">
                        <label for="notes">Notes (Optional)</label>
                        <textarea name="notes" class="form-control" maxlength="500"></textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="border-0 px-4 pt-3 py-4 text-end">
                <button type="submit" class="btn btn-primary m-0 model_footer_button me-3">Save <i
                        class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
                <a href="{{ route('security.guard') }}" class="btn btn-light border  m-0 model_footer_button">Back</a>
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
      url :"{{ route('store.security.guard') }}",  
      method:"POST",  
      dataType:"json",  
      data: new FormData(e),
      contentType: false,
      processData: false,
      success: function(data){ 
            if(data.status == 1){
              toastr.success(data.message, 'Success');
              $(e).find('.st_loader').hide();
              $('#modal-md').modal('hide');
              $('#modal-md .modal-content').html(''); 
              window.location.href = "{{ route('security.guard') }}";
            }else if(data.success == 0){
              toastr.error(data.message, 'Error');
              $(e).find('.st_loader').hide();
            }
          },
          error: function(data){ 
            if(typeof data.responseJSON.status !== 'undefined'){
              toastr.error(data.responseJSON.error, 'Error');
            }else{
              $.each(data.responseJSON.errors, function(key, value) {
                  toastr.error(value, 'Error');
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



function uploadattachmentImage(form) {   
  $(form).find('#uploadLoader_attachment').show();
    const formData = new FormData($(form)[0]);
    $.ajax({
        type: "POST",
        url: '{{ route("image.upload_attachment") }}', 
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
                $('#imageId_attachment').val(response.image_id_attachment); 
                $('#uploadedImage_attachment').attr('src', response.image_url_attachment);
                $('#uploadedImage_attachment').css('display', 'block');
                
            } else {
            }
            $(form).find('#uploadLoader_attachment').hide();
        },
        error: function(xhr, status, error) {
            toastr.error('An error occurred while uploading the image.', 'Error');
        }
    });
}


</script>

@endsection
