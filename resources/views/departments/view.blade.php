@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">View Department</h5>
        </div>
        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body  px-4 py-4">
            <form method="post" class="" id="step_one" onsubmit="updateForm(this);return false;" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $department->id }}">
    <div class="mb-4">
        <div class="p-3">
        <div class="row">
                <!-- First Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="firstname">Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="name" value="{{ $department->name}}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Code -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="code">Code<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="code" value="{{ $department->code}}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="email">Email<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" name="email" value="{{ $department->email}}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Phone Number with Country Code -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="phone">Phone Number<sup class="text-danger">*</sup></label>
                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter Phone Number" value="{{ $department->phone}}" readonly>
                        <input type="hidden" name="country_code" id="country_code">
                    </div>
                </div>

                <!-- Description -->
                <div class="col-12 mb-12">
                    <div class="form-group">
                        <label for="lastname">Description<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <textarea name="description" class="form-control" id="" cols="30" rows="10" readonly>{{ $department->description}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <label for="status">Status<sup class="text-danger">*</sup></label> 
                        <select disabled name="status" id="status" class="form-control" readonly>
                            <option @if($department->status == 1) selected @endif value="1">Active</option>
                            <option @if($department->status == 0) selected @endif value="0">In Active</option>
                        </select>
                    </div>
                </div> 
                
            </div> 
        </div>
    </div>

    <div class="border-0 px-4 pt-3 py-4 text-end">
    <a href="{{ route('departments') }}" class="btn btn-light border  m-0 model_footer_button">Back</a>
    </div>
</form>
 

            </div>
        </div>
    </div>
@endsection
