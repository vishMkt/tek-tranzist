@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">View Companies</h5>
        </div>
        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body  px-4 py-4">
  
 
            <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $uinfo->id }}">
    @csrf
    <div class="mb-4">
        <div class="p-3">
            <div class="row">
                <!-- First Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="firstname"> Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="name" value="{{ $uinfo->name }}" readonly>
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

                <!-- Mobile Number with Country Code -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="mobile">Phone Number<sup class="text-danger">*</sup></label>
                        <input type="tel" name="mobile" id="mobile" class="form-control" placeholder="Enter Phone Number" value="{{ $uinfo->mobile }}" readonly>
                        <input type="hidden" name="country_code" id="country_code" value="{{ $uinfo->country_code }}">
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="status">Status<sup class="text-danger">*</sup></label> 
                        <select disabled name="status" id="status" class="form-control" required>
                            <option @if($uinfo->status == 1) selected @endif value="1">Active</option>
                            <option @if($uinfo->status == 0) selected @endif value="0">Inactive</option>
                        </select>
                    </div>
                </div> 
                <!-- Address -->
                <div class="col-md-12 mb-4">
                <div class="form-group">
                        <label for="notes">Address</label>
                        <textarea name="address" class="form-control" maxlength="500" readonly>{{ $uinfo->address }}</textarea>
                    </div>
                </div>

                  <!-- Image Upload -->
                  <div class="col-md-12">
                            <div class="row"> 
                                <div class="col-md-2">
                                <label class="mb-2" for="drivers" >Image<sup class="text-danger">*</sup></label> 
                                    <img src="{{ asset(@$uinfo->Image->file_path) }}" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail"
                                        style="width:80px; height:80px;"> 
                                </div>
                            </div>
                        </div> 
            </div>
        </div>
    </div>

    <div class="border-0 px-4 pt-3 py-4 text-end"> 
                <a href="{{ route('companies') }}" class="btn btn-light border  m-0 model_footer_button">Back</a>
</form>


            </div>
        </div>
    </div>
@endsection

