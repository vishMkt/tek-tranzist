              
@extends('layouts.app')
@section('content')
<div id="content">
    <div class=" d-flex flex-wrap justify-content-between mb-4">
        <h5 class="top_title">View Vehicle</h5>
    </div>

    <div class="card border-0 mt-4 rounded-3">
        <div class="card-body  px-4 py-4">
            <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $uinfo->id }}">
                @csrf
                <div class="mb-4">
                    <div class="p-4">
                    <div class="row"> 
                <!-- Licance Plate -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="license_plate">License Plate<sup class="text-danger">*</sup></label>
                        <input type="tel" name="license_plate" id="license_plate" class="form-control" value="{{ $uinfo->license_plate }}" readonly> 
                    </div>
                </div> 
                <!-- Make --> 
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="firstname">Make<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="make" value="{{ $uinfo->Make->name }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Model -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="lastname">Model<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="model" value="{{ $uinfo->ModelVehicle->name }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Year Expiry -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="email">Year expiry<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="year" value="{{ $uinfo->year }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="vehicle_owner">Vehicle Owner<sup class="text-danger">*</sup></label> 
                    <select disabled name="vehicle_owner" id="vehicle_owner" class="form-control">
                        <option value="">--Choose--</option>
                        @foreach($vehicle_owners as $vehicle_owner)
                            <option @if($vehicle_owner->id == $uinfo->vehicle_owner) selected @endif value="{{ $vehicle_owner->id }}">{{ $vehicle_owner->firstname .' '. $vehicle_owner->lastname}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

                
            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="status">Status<sup class="text-danger">*</sup></label> 
                    <select disabled name="status" id="status" class="form-control" readonly>
                        <option @if($uinfo->status == 1) selected @endif value="1">Active</option>
                        <option @if($uinfo->status == 0) selected @endif value="0">In Active</option>
                    </select>
                </div>
            </div> 

            <h2 class="fw-bolder mb-4"> PUC </h2>
            
            
                        <!-- Valid Upto -->
                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label class="mb-2" for="puc_certificate_number">PUC Certificate Number<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="puc_certificate_number" value="{{ $puc->puc_certificate_number }}" readonly>
                                </div>
                            </div>
                        </div> 

                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label class="mb-2" for="puc_issue_date">PUC Issue Date<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" name="puc_issue_date" value="{{ $puc->puc_issue_date }}" readonly>
                                </div>
                            </div>
                        </div> 

                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label class="mb-2" for="puc_expiry_date">PUC Expiry Date<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" name="puc_expiry_date" value="{{ $puc->puc_expiry_date }}" readonly>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="row">
                                
                                <div class="col-md-12">
                                <label class="mb-2" for="drivers" >Front Image<sup class="text-danger">*</sup></label> 
                                    <img src="{{ asset(@$puc->ImageFront->file_path) }}" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail"
                                        style="width:80px; height:80px;"> 
                                </div>
                            </div>
                        </div>  

                <!-- Back Image -->
                        
                     <div class="col-md-6">
                            <div class="row"> 
                                <div class="col-md-12">
                                <label class="mb-2" for="drivers" >Back Image<sup class="text-danger">*</sup></label> 
                                <img src="{{ asset(@$puc->ImageBack->file_path) }}" alt="Uploaded Image" id="uploadedImage_back" class="img-thumbnail" style="width:80px; height:80px;"> 
                                </div>
                            </div>
                        </div> 
                     
                        <h2 class="fw-bolder mb-4"> Insurance </h2>

                         <!-- Policy Number -->
                        <div class="col-6 mb-4">
                            <div class="form-group">
                                <label class="mb-2" for="policy_number">Policy Number<sup class="text-danger">*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="policy_number" value="{{ $insurance->policy_number }}" readonly>
                                </div>
                            </div>
                        </div>         
                <!-- Provider -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="provider">Provider<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="provider"  value="{{ $insurance->provider }}" readonly>
                        </div>
                    </div>
                </div>      
                <!-- Issue Date -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="issue_date">Issue Date<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" name="issue_date"  value="{{ $insurance->issue_date }}" readonly>
                        </div>
                    </div>
                </div>  

                  <!-- Expiry Date -->

                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="expiry_date">Expiry Date<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" name="expiry_date"  value="{{ $insurance->expiry_date }}" readonly>
                        </div>
                    </div>
                </div> 
                
                    <div class="col-md-6">
                        <div class="row">
                          
                            <div class="col-md-12">
                            <label class="mb-2" for="drivers" >Front Image<sup class="text-danger">*</sup></label>  
                                <img src="{{ asset($insurance->ImageFront->file_path) }}" alt="Uploaded Image" id="uploadedImage_front_insurance" class="img-thumbnail"
                                    style="width:80px; height:80px;">
                               
                            </div>
                        </div>
                    </div> 

                        
                        <div class="col-md-6">
                            <div class="row"> 
                                <div class="col-md-12">
                                    <label class="mb-2" for="drivers" >Back Image<sup class="text-danger">*</sup></label>  
                                    <img src="{{ asset($insurance->ImageBack->file_path) }}" alt="Uploaded Image" id="uploadedImage_back_insurance" class="img-thumbnail"
                                        style="width:80px; height:80px;"> 
                                </div>
                            </div>
                        </div> 

            </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a  href="{{ route('vehicle') }}" class="btn btn-secondary mx-2" >Cancel</a>
                    <button type="submit" class="btn btn-primary">Save <i class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
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
                url: '{{ route('modeldata.vehicle') }}',
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
        url :"{{ route('update.vehicle') }}",  
        method:"POST",  
        dataType:"json",  
        data:$(e).serialize(),
        success: function(data){ 
                if(data.status==1){
                toastr.success(data.message,'Success');
                $(e).find('.st_loader').hide();
                
                    $('#modal-md').modal('hide');
                    $('#modal-md .modal-content').html('') 
                //   location.reload();
                    dataTable.draw(true); 
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

</script>
@endsection 