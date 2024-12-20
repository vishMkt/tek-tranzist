
@extends('layouts.app')
@section('content')
<div id="content">
    <div class=" d-flex flex-wrap justify-content-between mb-4">
        <h5 class="top_title">Add Vehicle</h5>
    </div>

    <div class="card border-0 mt-4 rounded-3">
        <div class="card-body  px-4 py-4">
            <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <div class="p-4">
                        <div class="row">
                            <!-- Licance Plate -->
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="license_plate">License Plate<sup class="text-danger">*</sup></label>
                                    <input type="tel" name="license_plate" id="license_plate" class="form-control"> 
                                </div>
                            </div> 

                            <!-- Make -->
                            <div class="col-6 mb-4">
                                <div class="form-group">
                                    <label for="email">Make<sup class="text-danger">*</sup></label>
                                    <div class="col-sm-12">
                                    <select name="make" id="make" class="form-control" onchange="getModelData(this); return false;">
                                    <option value="">--Choose--</option>
                                    @foreach($makes as $make)
                                        <option value="{{ $make->id }}">{{ $make->name }}</option>
                                    @endforeach
                                </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-4">
                            <div class="form-group">
                                <label for="model">Model<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                <select name="model" id="model" class="form-control">
                                <option value="">--Choose--</option> 
                            </select>
                                </div>
                            </div>
                        </div>
                             <!-- Year Expiry -->
                            <div class="col-6 mb-4">
                                <div class="form-group">
                                    <label for="email">Year expiry<sup class="text-danger">*</sup></label>
                                    <div class="col-sm-12">
                                        <input type="month" class="form-control" name="year">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="vehicle_owner">Vehicle Owner<sup class="text-danger">*</sup></label> 
                                    <select name="vehicle_owner" id="vehicle_owner" class="form-control">
                                        <option value="">--Choose--</option>
                                        @foreach($vehicle_owners as $vehicle_owner)
                                            <option value="{{ $vehicle_owner->id }}">{{ $vehicle_owner->firstname .' '. $vehicle_owner->lastname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                         
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="status">Status<sup class="text-danger">*</sup></label> 
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                </div>
                            </div> 

                            <h2 class="fw-bolder mb-4"> PUC </h2>
                        
                        
                        <!-- Valid Upto -->
                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label class="mb-2" for="puc_certificate_number">PUC Certificate Number<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="puc_certificate_number">
                                </div>
                            </div>
                        </div> 

                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label class="mb-2" for="puc_issue_date">PUC Issue Date<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" name="puc_issue_date">
                                </div>
                            </div>
                        </div> 

                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label class="mb-2" for="puc_expiry_date">PUC Expiry Date<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" name="puc_expiry_date">
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
                                 
                                <h2 class="fw-bolder mb-4"> Insurance </h2>
                <!-- Policy Number -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="policy_number">Policy Number<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="policy_number">
                        </div>
                    </div>
                </div>         
                <!-- Provider -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="provider">Provider<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="provider">
                        </div>
                    </div>
                </div>      
                <!-- Issue Date -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="issue_date">Issue Date<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" name="issue_date">
                        </div>
                    </div>
                </div>  

                  <!-- Expiry Date -->

                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="expiry_date">Expiry Date<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" name="expiry_date">
                        </div>
                    </div>
                </div> 
                
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-10">
                            <label class="mb-2" for="drivers" >Front Image<sup class="text-danger">*</sup></label> 
                                <input type="hidden" id="imageId_front_insurance" name="image_id_front_insurance" value="">
                                <input type="file" name="file_front_insurance" id="imageUrl_front_insurance" class="form-control mb-4"
                                    onchange="uploadFrontInsuranceImage('#step_one')">

                            </div>
                            <div class="col-md-2">
                                <img src="" alt="Uploaded Image" id="uploadedImage_front_insurance" class="img-thumbnail"
                                    style="display:none; width:80px; height:80px;">
                                <div id="uploadLoader_front_insurance" class="spinner-border text-primary" role="status"
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
                                    <input type="hidden" id="imageId_back_insurance" name="image_id_back_insurance" value="">
                                    <input type="file" name="file_back_insurance" id="imageUrl_back_insurance" class="form-control mb-4"
                                        onchange="uploadbackInsuranceImage('#step_one')">

                                </div>
                                <div class="col-md-2">
                                    <img src="" alt="Uploaded Image" id="uploadedImage_back_insurance" class="img-thumbnail"
                                        style="display:none; width:80px; height:80px;">
                                    <div id="uploadLoader_back_insurance" class="spinner-border text-primary" role="status"
                                        style="display: none;">
                                        <span class="visually-hidden">Uploading...</span>
                                    </div>
                                </div>
                            </div>
                        </div> 
 
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-3">Save <i class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
                    <a href="{{ route('vendor.vehicle')}}" class="btn btn-light border  m-0">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
 
@endsection 
@section('page-script')
<script>

function getModelData(e) { 
            var make_id = $(e).val();
            // alert(country_id);
            $.ajax({
                type: "POST",
                url: '{{ route('vendor.modeldata.vehicle') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                data: { 'make_id': make_id},
                success: function(response) {

                    if (response.status == 1) { 
                        $('#model').html(response.options);

                    } 
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while uploading the image.', 'Error');
                }
            });
        }

 
function form_submit1(e)
	{

	$(e).find('.st_loader').show();
	$.ajax({  
	  url :"{{ route('vendor.store.vehicle') }}",  
	  method:"POST",  
	  dataType:"json",  
	  data:$(e).serialize(),
	   success: function(data){ 
            if(data.status==1){
                toastr.success(data.message,'Success');
                $(e).find('.st_loader').hide();
                $('#modal-md').modal('hide');
                $('#modal-md .modal-content').html('') 
                backurl = "{{ route('vendor.vehicle') }}";
                 window.location.href = backurl;
                //    dataTable.draw(true);
               
            }else if(data.success==0){
              toastr.error(data.message,'Error');
              $(e).find('.st_loader').hide();
            }
          },
          error: function(data){ 
            if(typeof data.responseJSON.status !== 'undefined'){
              toastr.error(data.responseJSON.error,'Error');
            }else{
              $.each(data.responseJSON.errors, function( key, value ) {
                  toastr.error(value,'Error');
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
        url: '{{ route("vendor.image.upload") }}', 
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
        url: '{{ route("vendor.image.upload_back") }}', 
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



function uploadbackInsuranceImage(form) {   
    $(form).find('#uploadLoader_back_insurance').show();
      const formData = new FormData($(form)[0]);
      $.ajax({
          type: "POST",
          url: '{{ route("vendor.image.upload_back_insurance") }}', 
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
                  $('#imageId_back_insurance').val(response.image_id_back_insurance); 
                  $('#uploadedImage_back_insurance').attr('src', response.image_url_back_insurance);
                  $('#uploadedImage_back_insurance').css('display', 'block');
                  
              } else {
              }
              $(form).find('#uploadLoader_back_insurance').hide();
          },
          error: function(xhr, status, error) {
              toastr.error('An error occurred while uploading the image.', 'Error');
          }
      });
  }
  
 
  
function uploadFrontInsuranceImage(form) {   
    $(form).find('#uploadLoader_front_insurance').show();
      const formData = new FormData($(form)[0]);
      $.ajax({
          type: "POST",
          url: '{{ route("vendor.image.upload_front_insurance") }}', 
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
                  $('#imageId_front_insurance').val(response.image_id_front_insurance); 
                  $('#uploadedImage_front_insurance').attr('src', response.image_url_front_insurance);
                  $('#uploadedImage_front_insurance').css('display', 'block');
                  
              } else {
              }
              $(form).find('#uploadLoader_front_insurance').hide();
          },
          error: function(xhr, status, error) {
              toastr.error('An error occurred while uploading the image.', 'Error');
          }
      });
  }
  

</script>
@endsection 