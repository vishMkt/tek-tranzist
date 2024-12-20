
@extends('layouts.app')
@section('content')
    <div id="content">
        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">{{ $nav }}</h5>
        </div>

        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body text-center px-4 py-4">
                <form action="" id="employeeForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $employee->id }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" id="firstName" name="firstname"
                                class="form-control shadow-none  border-0  mb-4" value="{{ $employee->firstname }}" placeholder="First name">
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="lastName" name="lastname"
                                class="form-control shadow-none  border-0  mb-4" value="{{ $employee->lastname }}" placeholder="last name">
                        </div>
                        <div class="col-md-6">
                            <input type="email" id="email" name="email"
                                class="form-control shadow-none  border-0  mb-4" value="{{ $employee->email }}" placeholder="Email">
                        </div>
                        <div class="col-md-6">
                            <div class=" gap-3">
                                <span class="input-group-text bg_gray border-0 gap-2 font_15_medium"
                                    style="border-radius: 8px;">  
                                    <input type="hidden" id="country_code" name="country_code" value="{{ $employee->country_code }}">
                                    <input type="tel" class="form-control" name="mobile" id="phone" placeholder="Mobile Number" style="border-radius: 8px;" value="{{ $employee->mobile }}"> 
                                </span> 
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <input type="password" id="password" name="password"
                                class="form-control shadow-none  border-0  mb-4"  placeholder="Password">
                        </div>
                        <div class="col-md-6">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control shadow-none  border-0  mb-4"  placeholder="Confirm Password">
                        </div>
                        
                        <div class="col-md-6">
                            <input type="text" name="age" id="age"
                                class="form-control shadow-none  border-0  mb-4" value="{{ $employee->age }}" placeholder="Age">
                        </div>
                        <div class="col-md-6"> 
                            <select class="form-select shadow-none border-0 mb-4" id="country" name="country" onchange="getstate(this); return false;">
                                <option selected disabled>Select country</option>
                                @foreach ($countries as $country)
                                <option value="{{$country->id}}" @if($employee->country == $country->id) selected @endif >{{ $country->name}}</option>
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
                            <div class="form-group">
                                {{-- <label for="status">Status<sup class="text-danger">*</sup></label>  --}}
                                <select name="status" id="status" class="form-control mb-4">
                                    <option @if($employee->status == 1) selected @endif value="1">Active</option>
                                    <option @if($employee->status == 0) selected @endif value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                       
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="hidden" id="imageId" name="image_id" value="{{ $employee->image_id }}">
                                    <input type="file" name="file" id="imageUrl" class="form-control mb-4"
                                        onchange="uploadSampleFile('#employeeForm')">

                                </div>
                                <div class="col-md-2">
                                    <img src="{{ asset(@$employee->image->file_path) }}" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail"
                                        style="@if(!@$employee->image->file_path)display: none; @endif width:80px; height:80px;">
                                    <div id="uploadLoader" class="spinner-border text-primary" role="status"
                                        style="display: none;">
                                        <span class="visually-hidden">Uploading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-0 px-4 pt-3 py-4 text-end">
                        <button type="submit" class="btn btn-primary  m-0 model_footer_button me-3">Update  <i class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
                        <a href="{{ route('company.employee')}}" class="btn btn-light border  m-0 model_footer_button">Back</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('page-script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>

          // Initialize intl-tel-input with auto country detection
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

        $(document).ready(function() {
            $('#employeeForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                 var iti = window.intlTelInputGlobals.getInstance(document.querySelector("#phone"));
                var fullNumber = iti.getNumber();
                var countryData = iti.getSelectedCountryData();
        
                // You can add the full number to a hidden input or directly send it in the AJAX request
                $('#phone').val(fullNumber);
                $('#country_code').val(countryData.dialCode);

                $(e).find('.st_loader').show();
                $.ajax({
                    url: '{{ route('company.employee.update') }}', // Replace with your route
                    method: 'POST',
                    data: $('#employeeForm').serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = "{{ route('company.employee') }}";
                        }
                        else if(data.success==0){
                            toastr.error(data.message,'Error');
                            $(e).find('.st_loader').hide();
                        }
                        $(e).find('.st_loader').hide();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[
                                0]); // Display each validation error using Toastr
                            });
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });

        function uploadSampleFile(form) {
            $(form).find('#uploadLoader').show();
            const formData = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: '{{ route('company.image.upload') }}',
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

        getstate('#country');
    function getstate(e) {
            var country_id = $(e).val(); 
            if(country_id == null){ 
                country_id = "{{ $employee->country }}";
            } 
            var state = "{{ $employee->state }}"; 

            $.ajax({
                type: "POST",
                url: '{{ route('company.states.list') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                data: { 'country_id': country_id , 'state':state},
                success: function(response) {

                    if (response.status == 1) {
                        $('#state').append(response.options);

                    } 
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while uploading the image.', 'Error');
                }
            });
        }


        getCities('#state');
        function getCities(e) {
            var state_id = $(e).val();
            if(state_id == null){ 
                state_id = "{{ $employee->state }}";
            } 
            var city_id = "{{ $employee->city }}";
            // alert(country_id);
            $.ajax({
                type: "POST",
                url: '{{ route('company.cities.list') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                data: { 'state_id': state_id, 'city_id':city_id},
                success: function(response) {

                    if (response.status == 1) {
                        $('#city').html(response.options);

                    } 
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while uploading the image.', 'Error');
                }
            });
        }
    </script>
@endsection
