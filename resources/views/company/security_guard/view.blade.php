 <form method="post" class="" id="step_one" onsubmit="form_submit1(this);return false;" autocomplete="off"
     enctype="multipart/form-data">
     <input type="hidden" name="id" value="{{ $uinfo->id }}">
     @csrf
     <div class="mb-4">
         <div class="p-4">
             <h3 class="modal-title mb-3 text-center">Security Guard Details</h3>
             <div class="row">
                 <!-- Image Upload -->
                 <div class="col-md-12 mb-3">
                            <label class="mb-2" for="drivers">Front Image</label>
                        
                        <div class="">
                            <img src="{{ asset(@$uinfo->Image->file_path) }}" alt="Uploaded Image"
                                id="uploadedImage" class="img-thumbnail" style="width:100px; height:100px;">
                           
                        </div>
                </div>
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

                 <!-- Date of Birth -->
                 <div class="col-md-6 mb-4">
                     <div class="form-group">
                         <label for="date_of_birth">Date of Birth</label>
                         <input type="date" readonly name="date_of_birth" id="date_of_birth" class="form-control"
                             value="{{ $uinfo->date_of_birth }}" required>
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

                 <!-- Shift Timing -->
                 <div class="col-md-6 mb-4">
                     <div class="form-group">
                         <label for="shift_timing">Shift Timing</label>
                         <input type="text" readonly class="form-control" name="shift_timing"
                             value="{{ $uinfo->shift_timing }}" required>
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


             </div>
         </div>
     </div>

     <div class="modal-footer">
         <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
     </div>
 </form>

 <script>
     function form_submit1(e) {
         $(e).find('.st_loader').show();
         $.ajax({
             url: "{{ route('update.security.guard') }}",
             method: "POST",
             dataType: "json",
             data: new FormData(e),
             contentType: false,
             processData: false,
             success: function(data) {
                 if (data.status == 1) {
                     toastr.success(data.message, 'Success');
                     $(e).find('.st_loader').hide();
                     $('#modal-md').modal('hide');
                     $('#modal-md .modal-content').html('');
                     dataTable.draw(true);
                 } else if (data.success == 0) {
                     toastr.error(data.message, 'Error');
                     $(e).find('.st_loader').hide();
                 }
             },
             error: function(data) {
                 if (typeof data.responseJSON.status !== 'undefined') {
                     toastr.error(data.responseJSON.error, 'Error');
                 } else {
                     $.each(data.responseJSON.errors, function(key, value) {
                         toastr.error(value, 'Error');
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
             url: '{{ route('image.upload') }}',
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

                 } else {}
                 $(form).find('#uploadLoader').hide();
             },
             error: function(xhr, status, error) {
                 toastr.error('An error occurred while uploading the image.', 'Error');
             }
         });
     }
 </script>
