@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">Create Driver</h5>
        </div>
        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body  px-4 py-4">
                <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="firstname">First Name<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="firstname">
                                </div>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="lastname">Last Name<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="lastname">
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-4">
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
                                <input type="tel" name="mobile" id="mobile" class="form-control">
                                <input type="hidden" name="country_code" id="country_code">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="password">Password<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="password_confirmation">Password Confirm<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="vendors">Vendor<sup class="text-danger">*</sup></label>
                                <select name="vendor" id="vendors" class="form-control">
                                    <option value="">--Choose--</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->firstname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                         <!-- Adhar Card -->
                         <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="adhar_card">Adhar Card<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="adhar_card">
                                </div>
                            </div>
                        </div>
                         <!-- Pan Card -->
                         <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="pan_card">Pan Card<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="pan_card">
                                </div>
                            </div>
                        </div>
                         <!-- Emergency Contact Information (Optional) -->
                         <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="emergency_contact_information">Emergency Contact Information (Optional)</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="emergency_contact_information">
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
                        <div class="col-12 mb-4">
                        <h2 class="fw-bolder"> License </h2>
                        </div>
                        <div class="col-6 mb-4">
                        <div class="form-group">
                            <label class="mb-2" for="license_number">License Number<sup class="text-danger">*</sup></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="license_number">
                            </div>
                        </div>
                        </div>     
                        <!-- Valid Upto -->
                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label class="mb-2" for="valide_upto">Valide Upto<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" name="valide_upto">
                                </div>
                            </div>
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


                    <div class="border-0 px-4 pt-3 py-4 text-end">
                        <button type="submit" class="btn btn-primary m-0 model_footer_button me-3">Save <i
                                class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
                        <a href="{{ route('driver') }}" class="btn btn-light border  m-0 model_footer_button">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script type="text/javascript">
        var gmapKey = "{{ env('googleMap.key') }}";
        var gmapLib = "{{ env('googleMap.libraries') }}";
        $.getScript('https://maps.googleapis.com/maps/api/js?key=' + gmapKey + '&libraries=' + gmapLib, () => {
            var address = (document.getElementById('project_lookup'));
            var options = {
                fields: ["formatted_address", "geometry", "name"],
            };
            var autocomplete = new google.maps.places.Autocomplete(address, options);
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



        function form_submit1(e) {

            $(e).find('.st_loader').show();
            $.ajax({
                url: "{{ route('store.driver') }}",
                method: "POST",
                dataType: "json",
                data: $(e).serialize(),
                success: function(data) {
                    if (data.status == 1) {
                        toastr.success(data.message, 'Success');
                        $(e).find('.st_loader').hide();
                        window.location.href = "{{ route('driver') }}";
                       

                    } else if (data.success == 0) {
                        toastr.error(data.message, 'Error');
                        $(e).find('.st_loader').hide();
                    }
                },
                error: function(data) {
                    if (typeof data.responseJSON.status !== 'undefined') {
                        toastr.error(data.responseJSON.error, 'Error');
                    } else {
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
