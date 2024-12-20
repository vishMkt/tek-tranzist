@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">View Vendor</h5>
        </div>
        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body  px-4 py-4">
  
            <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $uinfo->id }}">
    @csrf
    <div class="mb-4">
        <div class="p-4"> 
            <div class="row">
                <!-- First Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="firstname" value="{{ $uinfo->firstname }}">
                        </div>
                    </div>
                </div>

                <!-- Last Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="lastname" value="{{ $uinfo->lastname }}">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="col-sm-12">
                            <input type="email" readonly class="form-control" name="email" value="{{ $uinfo->email }}">
                        </div>
                    </div>
                </div>

                <!-- Phone Number with Country Code -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="mobile">Phone Number</label>
                        <input type="tel" readonly name="mobile" id="mobile" class="form-control" placeholder="Enter Phone Number"  value="{{ $uinfo->mobile }}">
                        <input type="hidden" name="country_code" id="country_code">
                    </div>
                </div> 
                <div class="col-12 mb-4">
                    <div class="form-group">
                        <label for="password_confirmation">Address</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="address" id="project_lookup">
                            <input type="hidden" class="form-control" name="lat">
                            <input type="hidden" class="form-control" name="long">
                        </div>
                    </div>
                </div> 
                 <div class="col-12 mb-4">
                    <div class="form-group">
                        <label for="password_confirmation">Attachment</label>
                        <div class="col-sm-12">
                        <img src="{{ asset(@$uinfo->Image->file_path) }}" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail"
                        style="width:80px; height:80px;">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="border-0 px-4 pt-3 py-4 text-end"> 
                <a href="{{ url('admin/vendor') }}" class="btn btn-light border  m-0 model_footer_button">Back</a>
                </div>
</form>
 

            </div>
        </div>
    </div>
@endsection
