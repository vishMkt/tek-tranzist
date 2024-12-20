<form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $uinfo->id }}">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h3 class="modal-title mb-3 text-center" id="">Edit PUC</h3>
            <div class="row">
            <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="vehicle_number">Vehicle Number<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="vehicle_number"  value="{{ $uinfo->vehicle_number }}">
                        </div>
                    </div>
                </div>         
                <!-- Owner Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="owner_name">Owner Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="owner_name" value="{{ $uinfo->owner_name }}">
                        </div>
                    </div>
                </div>      
                <!-- PUC Certificate Number -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="puc_certificate_number">PUC Certificate Number<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="puc_certificate_number"  value="{{ $uinfo->puc_certificate_number }}">
                        </div>
                    </div>
                </div> 
              <!-- PUC Issue Date -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="puc_issue_date">PUC Issue Date<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" name="puc_issue_date"  value="{{ $uinfo->puc_issue_date }}">
                        </div>
                    </div>
                </div> 
             <!-- PUC Expiry Date -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="puc_expiry_date">PUC Expiry Date<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" name="puc_expiry_date" value="{{ $uinfo->puc_expiry_date }}">
                        </div>
                    </div>
                </div> 
             <!-- Driver -->
                <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label class="mb-2" for="drivers">Driver<sup class="text-danger">*</sup></label> 
                    <select name="driver_id" id="drivers" class="form-control">
                        <option value="">--Choose--</option>
                        @foreach($drivers as $driver)
                            <option @if($driver->id  == $uinfo->driver_id) selected @endif value="{{ $driver->id }}">{{ $driver->firstname .' '. $driver->lastname}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

             <!-- Front Image -->
              
            <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10">
                                <label class="mb-2" for="drivers" >Front Image<sup class="text-danger">*</sup></label> 
                                    <input type="hidden" id="imageId" name="image_id" value="{{ $uinfo->front_image }}">
                                    <input type="file" name="file" id="imageUrl" class="form-control mb-4"
                                        onchange="uploadfrontImage('#step_one')">

                                </div>
                                <div class="col-md-2">
                                    <img src="{{ asset(@$uinfo->ImageFront->file_path) }}" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail"
                                        style="width:80px; height:80px;">
                                    <div id="uploadLoader" class="spinner-border text-primary" role="status"
                                        style="display: none;">
                                        <span class="visually-hidden">Uploading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>  

                <!-- Back Image -->
                        
            <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10">
                                <label class="mb-2" for="drivers" >Back Image<sup class="text-danger">*</sup></label> 
                                    <input type="hidden" id="imageId_back" name="image_id_back" value="{{ $uinfo->back_image }}">
                                    <input type="file" name="file_back" id="imageUrl_back" class="form-control mb-4"
                                        onchange="uploadbackImage('#step_one')">

                                </div>
                                <div class="col-md-2">
                                    <img src="{{ asset(@$uinfo->ImageBack->file_path) }}" alt="Uploaded Image" id="uploadedImage_back" class="img-thumbnail"
                                        style="width:80px; height:80px;">
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
   
   
var gmapKey = "{{ env('googleMap.key') }}";
        var gmapLib = "{{ env('googleMap.libraries') }}";
        $.getScript('https://maps.googleapis.com/maps/api/js?key=' + gmapKey + '&libraries=' + gmapLib, () => {
            var address = (document.getElementById('project_lookup'));
            var options = {
                fields: ["formatted_address", "geometry", "name"],
            };
            var autocomplete = new google.maps.places.Autocomplete(address,options);
            autocomplete.setTypes(['geocode']);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                // console.log(place.countary);
                console.log(place.geometry.location.lat());
                console.log(place.geometry.location.lng());
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('long').value = place.geometry.location.lng();
            });
        });
    
 
function form_submit1(e)
	{

	$(e).find('.st_loader').show();
	$.ajax({  
	  url :"{{ route('update.puc') }}",  
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
