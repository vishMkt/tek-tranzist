<form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $uinfo->id }}">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h3 class="modal-title mb-3 text-center" id="">Make</h3>
            <div class="row">
                <!-- License Number -->
                <div class="col-12 mb-4">
                    <div class="form-group">
                        <label class="mb-2" for="name">Namer<sup class="text-danger">*</sup></label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="name" value="{{ $uinfo->name }}">
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