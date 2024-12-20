@extends('layouts.app')
@section('content')
    <div id="content">

        <div class=" d-flex flex-wrap justify-content-between mb-4">
            <h5 class="top_title">{{ $nav }}</h5>
        </div>
        <div class="card border-0 mt-4 rounded-3">
            <div class="card-body  px-4 py-4">
                <form method="post" class="" id="step_one" onsubmit="updateForm(this);return false;" autocomplete="off"
                    enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $department->id }}">
                    @csrf

                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="firstname">Name<sup class="text-danger">*</sup></label>
                             
                                    <input type="text" class="form-control" name="name"
                                        value="{{ $department->name }}">
                                
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="email">Email<sup class="text-danger">*</sup></label>
                               
                                    <input type="email" class="form-control" name="email"
                                        value="{{ $department->email }}">
                              
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="password">Password<sup class="text-danger">*</sup></label>
                                
                                    <input type="password" class="form-control" name="password">
                                
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="password_confirmation">Password Confirm<sup class="text-danger">*</sup></label>
                                
                                    <input type="password" class="form-control" name="password_confirmation">
                               
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="status">Status<sup class="text-danger">*</sup></label>
                                <select name="status" id="status" class="form-control">
                                    <option selected disabled>Select</option>
                                    <option @if ($department->status == 1) selected @endif value="1">Active</option>
                                    <option @if ($department->status == 0) selected @endif value="0">In Active
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="border-0 px-4 pt-3 py-4 text-end">
                        <button type="submit" class="btn btn-primary m-0 model_footer_button me-3">Update <i
                                class="st_loader spinner-border spinner-border-sm" style="display:none;"></i></button>
                        <a href="{{ route('users') }}" class="btn btn-light border  m-0 model_footer_button">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endsection
    @section('page-script')
        <script type="text/javascript">


    function updateForm(e)
{
	$(e).find('.st_loader').show();
	$.ajax({  
	  url :"{{ route('users.update') }}",  
	  method:"POST",  
	  dataType:"json",  
	  data:$(e).serialize(),
	   success: function(data){ 
            if(data.status==1){
              toastr.success(data.message,'Success');
              $(e).find('.st_loader').hide();
              window.location.href = "{{ route('users') }}";
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
