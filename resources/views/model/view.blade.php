<form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $uinfo->id }}">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h3 class="modal-title mb-3 text-center" id="">Make</h3>
            <div class="row">
                <!-- License Number -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="name">Name<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="name" value="{{ $uinfo->name }}">
                        </div>
                    </div>
                </div>         
                <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label class="mb-2" for="make">Make<sup class="text-danger">*</sup></label> 
                    <select name="make_id" id="make" class="form-control">
                        <option value="">--Choose--</option>
                        @foreach($makes as $make)
                            <option @if($make->id == $uinfo->make_id) selected @endif value="{{ $make->id }}">{{ $make->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>  
            <div class="col-md-12">
                            <div class="row"> 
                                <div class="col-md-12">
                                <label class="mb-2" for="drivers" >Image<sup class="text-danger">*</sup></label> 
                                    <img src="{{ asset(@$uinfo->ImageFront->file_path) }}" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail"
                                        style="width:80px; height:80px;"> 
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