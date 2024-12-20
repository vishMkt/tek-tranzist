@extends('layouts.app')
@section('content')
    <div id="content">
        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">Create Vendor</h5>
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
                                <input type="tel" name="mobile" id="mobile" class="form-control"
                                    placeholder="Enter Phone Number">
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
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10">
                                    <label class="mb-2" for="drivers">Add Attachment<sup
                                            class="text-danger">*</sup></label>
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
                    </div>

                     <div class="border-0 px-4 pt-3 py-4 text-end">
                        <button type="submit" class="btn btn-primary m-0 model_footer_button me-3">Save <i
                                class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
                        <a href="{{ route('admin.vendor') }}"
                            class="btn btn-light border  m-0 model_footer_button">Back</a>
                    </div>
                </form>
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
            url: "{{ route('store.vendor') }}",
            method: "POST",
            dataType: "json",
            data: $(e).serialize(),
            success: function(data) {
                if (data.status == 1) {
                    toastr.success(data.message, 'Success');
                    $(e).find('.st_loader').hide();

                    $('#modal-md').modal('hide');
                    $('#modal-md .modal-content').html('')
                    //   location.reload();
                    dataTable.draw(true);

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
            url: '{{ route('image.upload') }}',
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

                } else {}
                $(form).find('#uploadLoader').hide();
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while uploading the image.', 'Error');
            }
        });
    }
</script>
@endsection
