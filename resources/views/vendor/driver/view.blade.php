@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">View Driver</h5>
        </div>
        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body  px-4 py-4">
            <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off"
                    enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $uinfo->id }}">
                    @csrf

                    <div class="row">
                        <!-- First Name -->
                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label for="firstname">First Name<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="firstname"
                                        value="{{ $uinfo->firstname }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label for="lastname">Last Name<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="lastname"
                                        value="{{ $uinfo->lastname }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label for="email">Email<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" name="email" value="{{ $uinfo->email }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Phone Number with Country Code -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="mobile">Phone Number<sup class="text-danger">*</sup></label>
                                <input type="tel" name="mobile" id="mobile" class="form-control"
                                    placeholder="Enter Phone Number" value="{{ $uinfo->mobile }}" readonly>
                                <input type="hidden" name="country_code" id="country_code">
                            </div>
                        </div>
 
                          <!-- Adhar Card -->
                          <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="adhar_card">Adhar Card<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="adhar_card" value="{{ $uinfo->adhar_card }}" readonly>
                                </div>
                            </div>
                        </div>
                         <!-- Pan Card -->
                         <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="pan_card">Pan Card<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="pan_card"  value="{{ $uinfo->pan_card }}" readonly>
                                </div>
                            </div>
                        </div>
                         <!-- Emergency Contact Information (Optional) -->
                         <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="emergency_contact_information">Emergency Contact Information (Optional)</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="emergency_contact_information"  value="{{ $uinfo->emergency_contact_information }}" readonly>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-6 mt-4">
                            <div class="row">
                               
                                <div class="col-md-12">
                                <label class="mb-2" for="drivers" >Add Attachment<sup class="text-danger">*</sup></label> <br>
                                    <img src="{{ asset(@$uinfo->ImageAttachment->file_path) }}" alt="Uploaded Image" id="uploadedImage_attachment" class="img-thumbnail"
                                        style="width:80px; height:80px;"> 
                                </div>
                            </div>
                        </div> 

                        <div class="col-12 my-4">
                            <div class="form-group">
                                <label for="password_confirmation">Address<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="address" id="project_lookup"
                                        value="{{ $uinfo->address }}" readonly>
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
                            <input type="text" class="form-control" name="license_number" value="{{ $license->license_number }}" readonly>
                        </div>
                    </div>
                </div>         
               
                <!-- Valid Upto -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="valide_upto">Valide Upto<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" name="valide_upto" value="{{ $license->valide_upto }}" readonly>
                        </div>
                    </div>
                </div> 
               

            <div class="col-md-6 mt-4">
                            <div class="row">
                             
                                <div class="col-md-6">
                                <label class="mb-2" for="drivers" >Front Image<sup class="text-danger">*</sup></label> <bR>
                                    <img src="{{ asset($license->ImageFront->file_path) }}" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail"
                                        style="width:80px; height:80px;">
                                </div>
                            </div>
                        </div> 

                        
            <div class="col-md-6 mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                <label class="mb-2" for="drivers" >Back Image<sup class="text-danger">*</sup></label> <br>
                                    <img src="{{ asset($license->ImageBack->file_path) }}" alt="Uploaded Image" id="uploadedImage_back" class="img-thumbnail"
                                        style="width:80px; height:80px;">
                                </div>
                            </div>
                        </div> 


                    </div>

                    <div class="border-0 px-4 pt-3 py-4 text-end">
                        <a href="{{ route('vendor.driver') }}" class="btn btn-light border  m-0 model_footer_button">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

