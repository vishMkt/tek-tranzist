@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">View Security Guard</h5>
        </div>
        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body  px-4 py-4">
            <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off"
enctype="multipart/form-data">
<input type="hidden" name="id" value="{{ $uinfo->id }}">
@csrf
<div class="mb-4">
    <div class="p-4">
        <h3 class="modal-title mb-3 text-center">Security Guard Details</h3>
        <div class="row">
            <!-- Image Upload -->
          
            <!-- First Name -->
            <div class="col-6 mb-4">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <div class="col-sm-12">
                        <input type="text" readonly class="form-control" name="firstname"
                            value="{{ $uinfo->firstname }}" required readonly>
                    </div>
                </div>
            </div>

            <!-- Last Name -->
            <div class="col-6 mb-4">
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <div class="col-sm-12">
                        <input type="text" readonly class="form-control" name="lastname"
                            value="{{ $uinfo->lastname }}" required>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="col-6 mb-4">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="col-sm-12">
                        <input type="email" readonly class="form-control" name="email"
                            value="{{ $uinfo->email }}" required>
                    </div>
                </div>
            </div>

            <!-- Mobile Number with Country Code -->
            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="mobile">Phone Number</label>
                    <input type="tel" readonly name="mobile" id="mobile" class="form-control"
                        placeholder="Enter Phone Number" value="{{ $uinfo->mobile }}" required>
                    <input type="hidden" name="country_code" id="country_code" value="{{ $uinfo->country_code }}">
                </div>
            </div>

            

            <!-- Status -->
            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" readonly id="status" class="form-control" required>
                        <option @if ($uinfo->status == 1) selected @endif value="1">Active</option>
                        <option @if ($uinfo->status == 0) selected @endif value="0">Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Assigned Location -->
            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="assigned_location">Assigned Location</label>
                    <input type="text" readonly class="form-control" name="assigned_location"
                        value="{{ $uinfo->assigned_location }}" required>
                </div>
            </div> 
            <!-- Date of Joining -->
            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="date_of_joining">Date of Joining</label>
                    <input type="date" readonly class="form-control" name="date_of_Joining"
                        value="{{ $uinfo->date_of_Joining }}" required>
                </div>
            </div>

            <!-- Emergency Contact Information -->
            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="emergency_contact_information">Emergency Contact Information</label>
                    <input type="text" readonly class="form-control" name="emergency_contact_information"
                        value="{{ $uinfo->emergency_contact_information }}">
                </div>
            </div>
           
            <!-- Address -->
            <div class="col-12 mb-4">
                <div class="form-group">
                    <label for="address">Address</label>
                    <div class="col-sm-12">
                        <input type="text" readonly class="form-control" name="address"
                            value="{{ $uinfo->address }}" required>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="col-12 mb-4">
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control" readonly name="notes" rows="3">{{ $uinfo->notes }}</textarea>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                       <label class="mb-2" for="drivers">Front Image</label>
                   
                   <div class="">
                       <img src="{{ asset(@$uinfo->Image->file_path) }}" alt="Uploaded Image"
                           id="uploadedImage" class="img-thumbnail" style="width:80px; height:80px;">
                      
                   </div>
           </div>

           <div class="col-md-12 mb-3">
                       <label class="mb-2" for="drivers">Attachment</label>
                   
                   <div class="">
                       <img src="{{ asset(@$uinfo->ImageAttachment->file_path) }}" alt="Uploaded Image"
                           id="uploadedImage" class="img-thumbnail" style="width:80px; height:80px;">
                      
                   </div>
           </div>


        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
</div>
</form>


            </div>
        </div>
    </div>
@endsection 