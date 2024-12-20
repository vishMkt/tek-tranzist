<form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off"
    enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $uinfo->id }}">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h3 class="modal-title mb-3 text-center" id="">Insurance</h3>
            <div class="row">
                <!-- License Number -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="policy_number">Policy Number<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="policy_number"
                                value="{{ $uinfo->policy_number }}">
                        </div>
                    </div>
                </div>
                <!-- Issue Date -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="provider">Provider<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="provider"
                                value="{{ $uinfo->provider }}">
                        </div>
                    </div>
                </div>
                <!-- Valid Upto -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="issue_date">Issue Date<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" readonly class="form-control" name="issue_date"
                                value="{{ $uinfo->issue_date }}">
                        </div>
                    </div>
                </div>

                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="expiry_date">Expiry Date<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="date" readonly class="form-control" name="expiry_date"
                                value="{{ $uinfo->expiry_date }}">
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
                        <img src="{{ asset($uinfo->ImageFront->file_path) }}" alt="Uploaded Image" id="uploadedImage"
                            class="img-thumbnail" style="width:80px; height:80px;">
                        <div id="uploadLoader" class="spinner-border text-primary" role="status"
                            style="display: none;">
                            <span class="visually-hidden">Uploading...</span>
                        </div>
                    </div>
                </div>

                <!-- Back Image -->

                <div class="col-md-6">
                    <label class="mb-2" for="drivers">Back Image<sup class="text-danger">*</sup></label>
                    <div class="">
                        <img src="{{ asset($uinfo->ImageBack->file_path) }}" alt="Uploaded Image"
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
