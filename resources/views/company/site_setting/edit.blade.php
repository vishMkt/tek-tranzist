
@extends('layouts.app')
@section('content')

                <!--invoice table  -->
                <div class=" d-flex flex-wrap justify-content-between mb-4">
                    <h5 class="top_title">{{ $nav }}</h5>
                    
                </div>

                <!-- table  --> 
                        <div class="card-body p-0 overflow-hidden "> 
                        <div class="table-responsive custom-scrollbar mb-4">
                        <form method="post" class="bg-white rounded" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
        
                        @csrf
                        <div class="mb-4">
                            <div class="p-4">
                              
                                <div class="row">
                                    <!-- License Number -->
                                    <div class="col-6 mb-4">
                                        <div class="form-group">
                                            <label class="mb-2" for="name">Name<sup class="text-danger">*</sup></label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="name" value="{{ $uinfo->name }}">
                                            </div>
                                        </div>
                                    </div>         
                                    <!-- Issue Date -->
                                    <div class="col-6 mb-4">
                                        <div class="form-group">
                                            <label class="mb-2" for="email">Email<sup class="text-danger">*</sup></label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="email" value="{{ $uinfo->email }}">
                                            </div>
                                        </div>
                                    </div>      
                                    <!-- Valid Upto -->
                                    <div class="col-6 mb-4">
                                        <div class="form-group">
                                            <label class="mb-2" for="contact">Contact<sup class="text-danger">*</sup></label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="contact" value="{{ $uinfo->contact }}">
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-10">
                                        <label class="mb-2" for="drivers" >Logo<sup class="text-danger">*</sup></label> 
                                            <input type="hidden" id="imageId" name="image_id" value="{{ $uinfo->logo }}">
                                            <input type="file" name="file" id="imageUrl" class="form-control mb-4"
                                                onchange="uploadImage('#step_one')">

                                        </div>
                                        <div class="col-md-2">
                                            <img src="{{ asset(@$uinfo->logoImage->file_path) }}" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail"
                                                style="width:80px; height:80px;">
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
                                <label class="mb-2" for="drivers" >Fav Icon<sup class="text-danger">*</sup></label> 
                                    <input type="hidden" id="imageId_back" name="image_id_back" value="{{ $uinfo->fav_icon }}">
                                    <input type="file" name="file_back" id="imageUrl_back" class="form-control mb-4"
                                        onchange="uploadfavIcon('#step_one')">

                                </div>
                                <div class="col-md-2">
                                    <img src="{{ asset(@$uinfo->favImage->file_path) }}" alt="Uploaded Image" id="uploadedImage_back" class="img-thumbnail"
                                        style="width:80px; height:80px;">
                                    <div id="uploadLoader_back" class="spinner-border text-primary" role="status"
                                        style="display: none;">
                                        <span class="visually-hidden">Uploading...</span>
                                    </div>
                                </div>
                            </div>
                        </div> 


                            </div>
                            <button type="submit" class="btn btn-primary">Save <i class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
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
	  url :"{{ route('company.update.site_setting') }}",  
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


    function uploadImage(form) {   
  $(form).find('#uploadLoader').show();
    const formData = new FormData($(form)[0]);
    $.ajax({
        type: "POST",
        url: '{{ route("company.image.upload") }}', 
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



function uploadfavIcon(form) {   
  $(form).find('#uploadLoader_back').show();
    const formData = new FormData($(form)[0]);
    $.ajax({
        type: "POST",
        url: '{{ route("company.image.upload_back") }}', 
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
@endsection