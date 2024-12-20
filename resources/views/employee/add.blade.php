@extends('layouts.app')
@section('content')
    <div id="content">
        <div class="d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">{{ $nav }}</h5>
        </div>

        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body text-center px-4 py-4">
                <form action="" id="employeeForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" id="firstName" name="firstname"
                                class="form-control shadow-none border-0 mb-4" placeholder="First name">
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="lastName" name="lastname"
                                class="form-control shadow-none border-0 mb-4" placeholder="Last name">
                        </div>
                        <div class="col-md-6">
                            <input type="email" id="email" name="email"
                                class="form-control shadow-none border-0 mb-4" placeholder="Email">
                        </div>
                        <div class="col-md-6">
                            <div class="gap-3">
                                <span class="input-group-text bg_gray border-0 gap-2 font_15_medium"
                                    style="border-radius: 8px;">
                                    <input type="hidden" id="country_code" name="country_code" value="">
                                    <input type="tel" class="form-control" name="mobile" id="phone" placeholder="Mobile Number" style="border-radius: 8px;">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="password" id="password" name="password"
                                class="form-control shadow-none border-0 mb-4" placeholder="Password">
                        </div>
                        <div class="col-md-6">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control shadow-none border-0 mb-4" placeholder="Confirm Password">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="age" id="age"
                                class="form-control shadow-none border-0 mb-4" placeholder="Age">
                        </div> 
                        <div class="col-md-6">
                            <select class="form-select shadow-none border-0 mb-4" id="companie_id" name="companie_id">
                                <option selected disabled>Select Companie</option>
                                @foreach ($companies as $companie)
                                <option value="{{ $companie->id }}">{{ $companie->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <select class="form-select shadow-none border-0 mb-4" id="country" name="country" onchange="getState(this); return false;">
                                <option selected disabled>Select country</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select shadow-none border-0 mb-4" id="state" name="state" onchange="getCities(this); return false;">
                                <option selected disabled>Select State</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select shadow-none border-0 mb-4" id="city" name="city">
                                <option selected disabled>Select city</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control mb-4">
                                <option selected disabled>Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="hidden" id="imageId" name="image_id" value="">
                                    <input type="file" name="file" id="imageUrl" class="form-control mb-4" onchange="uploadSampleFile('#employeeForm')">
                                </div>
                                <div class="col-md-2">
                                    <img src="" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail" style="display:none; width:80px; height:80px;">
                                    <div id="uploadLoader" class="spinner-border text-primary" role="status" style="display: none;">
                                        <span class="visually-hidden">Uploading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-0 px-4 pt-3 py-4 text-end">
                        <button type="submit" class="btn btn-primary m-0 model_footer_button me-3">Save
                            <i class="st_loader spinner-border spinner-border-sm" style="display:none;"></i>
                        </button>
                        <a href="{{ route('employee') }}" class="btn btn-light border m-0 model_footer_button">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch('https://ipinfo.io?token=your_token')  // Replace with your IPInfo token
                    .then(response => response.json())
                    .then(data => callback(data.country))
                    .catch(() => callback('us'));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });
    });

    $('#employeeForm').on('submit', function(e) {
        e.preventDefault();
        $('.st_loader').show();

        var iti = window.intlTelInputGlobals.getInstance(document.querySelector("#phone"));
        var fullNumber = iti.getNumber();
        var countryData = iti.getSelectedCountryData();

        $('#phone').val(fullNumber);
        $('#country_code').val(countryData.dialCode);

        $.ajax({
            url: '{{ route('employee.store') }}',
            method: 'POST',
            data: $('#employeeForm').serialize(),
            dataType: "JSON",
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    window.location.href = "{{ route('employee') }}";
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            },
            complete: function() {
                $('.st_loader').hide();
            }
        });
    });

    function getState(e) {
        var country_id = $(e).val();
        $('#state').empty().append('<option selected disabled>Select State</option>');

        $.ajax({
            type: "POST",
            url: '{{ route('states.list') }}',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            data: { 'country_id': country_id },
            success: function(response) {
                if (response.status == 1) {
                    $('#state').append(response.options);
                }
            },
            error: function() {
                toastr.error('An error occurred while fetching states.');
            }
        });
    }

    function getCities(e) {
        var state_id = $(e).val();
        $('#city').empty().append('<option selected disabled>Select city</option>');

        $.ajax({
            type: "POST",
            url: '{{ route('cities.list') }}',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            data: { 'state_id': state_id },
            success: function(response) {
                if (response.status == 1) {
                    $('#city').append(response.options);
                }
            },
            error: function() {
                toastr.error('An error occurred while fetching cities.');
            }
        });
    }

    function uploadSampleFile(form) {
        $(form).find('#uploadLoader').show();
        const formData = new FormData($(form)[0]);

        $.ajax({
            type: "POST",
            url: '{{ route('image.upload') }}',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#imageId').val(response.image_id);
                    $('#uploadedImage').attr('src', response.image_url).show();
                } else {
                    toastr.error('Failed to upload image. Please try again.');
                }
            },
            error: function() {
                toastr.error('An error occurred while uploading the image.');
            },
            complete: function() {
                $(form).find('#uploadLoader').hide();
            }
        });
    }
</script>
@endsection
