<form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off"
    enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $uinfo->id }}">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h3 class="modal-title mb-3 text-center" id="">PUC</h3>
            <div class="row">
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="vehicle_number">Vehicle Number<sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="vehicle_number"
                                value="{{ $uinfo->vehicle_number }}">
                        </div>
                    </div>
                </div>
                <!-- Owner Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="owner_name">Owner Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="owner_name"
                                value="{{ $uinfo->owner_name }}">
                        </div>
                    </div>
                </div>
                <!-- PUC Certificate Number -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="puc_certificate_number">PUC Certificate Number<sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="puc_certificate_number"
                                value="{{ $uinfo->puc_certificate_number }}">
                        </div>
                    </div>
                </div>
                <!-- PUC Issue Date -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="puc_issue_date">PUC Issue Date<sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" readonly class="form-control" name="puc_issue_date"
                                value="{{ $uinfo->puc_issue_date }}">
                        </div>
                    </div>
                </div>
                <!-- PUC Expiry Date -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="puc_expiry_date">PUC Expiry Date<sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" readonly class="form-control" name="puc_expiry_date"
                                value="{{ $uinfo->puc_expiry_date }}">
                        </div>
                    </div>
                </div>
                <!-- Driver -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="drivers">Driver<sup class="text-danger">*</sup></label>
                        <select name="driver_id" readonly id="drivers" class="form-control">
                            <option value="">--Choose--</option>
                            @foreach ($drivers as $driver)
                                <option @if ($driver->id == $uinfo->driver_id) selected @endif value="{{ $driver->id }}">
                                    {{ $driver->firstname . ' ' . $driver->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Front Image -->

                <div class="col-md-6">
                    <label class="mb-2" for="drivers">Front Image<sup class="text-danger">*</sup></label>
                    <div class="">
                        <img src="{{ asset(@$uinfo->ImageFront->file_path) }}" alt="Uploaded Image" id="uploadedImage"
                            class="img-thumbnail" style="width:80px; height:80px;">
                    </div>
                </div>

                <!-- Back Image -->

                <div class="col-md-6">
                    <label class="mb-2" for="drivers">Back Image<sup class="text-danger">*</sup></label>
                    <div class="">
                        <img src="{{ asset(@$uinfo->ImageBack->file_path) }}" alt="Uploaded Image"
                            id="uploadedImage_back" class="img-thumbnail" style="width:80px; height:80px;">
                        <div id="uploadLoader_back" class="spinner-border text-primary" role="status"
                            style="display: none;">
                            <span class="visually-hidden">Uploading...</span>
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

<script>
    


</script>
