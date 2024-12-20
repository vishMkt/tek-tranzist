<form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $uinfo->id }}">
    @csrf
    <div class="mb-4">
        <div class="p-4">
            <h4 class="modal-title mb-3 text-center" id="">View Vendor</h4>
            <div class="row">
                <!-- First Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="firstname" value="{{ $uinfo->firstname }}">
                        </div>
                    </div>
                </div>

                <!-- Last Name -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="lastname" value="{{ $uinfo->lastname }}">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="col-sm-12">
                            <input type="email" readonly class="form-control" name="email" value="{{ $uinfo->email }}">
                        </div>
                    </div>
                </div>

                <!-- Phone Number with Country Code -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="mobile">Phone Number</label>
                        <input type="tel" readonly name="mobile" id="mobile" class="form-control" placeholder="Enter Phone Number"  value="{{ $uinfo->mobile }}">
                        <input type="hidden" name="country_code" id="country_code">
                    </div>
                </div>

                <!-- Password -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="col-sm-12">
                            <input type="password" readonly class="form-control" name="password">
                        </div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-6 mb-4">
                    <div class="form-group">
                        <label for="password_confirmation">Password Confirm</label>
                        <div class="col-sm-12">
                            <input type="password" readonly class="form-control" name="password_confirmation">
                        </div>
                    </div>
                </div>  
                <div class="col-12 mb-4">
                    <div class="form-group">
                        <label for="password_confirmation">Address</label>
                        <div class="col-sm-12">
                            <input type="text" readonly class="form-control" name="address" id="project_lookup">
                            <input type="hidden" class="form-control" name="lat">
                            <input type="hidden" class="form-control" name="long">
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
