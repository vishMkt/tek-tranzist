@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">View Vehicle Owner</h5>
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
                        <label for="firstname">First Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="firstname" value="{{ $uinfo->firstname}}">
                        </div>
                    </div>
                </div>

                <!-- Last Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="lastname">Last Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="lastname" value="{{ $uinfo->lastname}}">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="email">Email<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="email" readonly class="form-control" name="email" value="{{ $uinfo->email}}">
                        </div>
                    </div>
                </div>

                <!-- Phone Number with Country Code -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="mobile">Phone Number<sup class="text-danger">*</sup></label>
                        <input type="tel" readonly name="mobile" id="mobile" class="form-control" placeholder="Enter Phone Number" value="{{ $uinfo->mobile}}">
                        <input type="hidden" name="country_code" id="country_code" >
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="vendors">Vendor<sup class="text-danger">*</sup></label> 
                        <select name="vendor" id="vendors" class="form-control">
                            <option value="">--Choose--</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ ($uinfo->vendor_id == $vendor->id) ? 'selected' : '' }}  >{{ $vendor->firstname}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="status">Status<sup class="text-danger">*</sup></label> 
                    <select name="status" id="status" readonly class="form-control">
                        <option @if($uinfo->status == 1) selected @endif value="1">Active</option>
                        <option @if($uinfo->status == 0) selected @endif value="0">In Active</option>
                    </select>
                </div>
                  </div> 

      
                <div class="col-12 mb-4">
                    <div class="form-group">
                        <label for="password_confirmation">Address<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="address" value="{{ $uinfo->address }}"> 
                        </div>
                    </div>
                </div>
            </div> 
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</form>
  
 
            </div>
        </div>
    </div>
@endsection
@section('page-script')
  