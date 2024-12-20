@extends('layouts.app')
@section('content')
<div id="content">

    <div class=" d-flex flex-wrap justify-content-between mb-4">
        <h5 class="top_title">{{ $nav }}</h5>
    </div>
    <div class="card border-0 mt-4 rounded-3">
        <div class="card-body  px-4 py-4">
            <div class="row">
                <!-- First Name -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="firstname">Name<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" name="name" value="{{ $department->name }}"
                            readonly>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="email">Email<sup class="text-danger">*</sup></label>
                        <input type="email" class="form-control" name="email" value="{{ $department->email }}"
                            readonly>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="status">Status<sup class="text-danger">*</sup></label>
                        <select name="status" id="status" class="form-control" readonly>
                            <option @if ($department->status == 1) selected @endif value="1">Active</option>
                            <option @if ($department->status == 0) selected @endif value="0">In Active</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="border-0 px-4 pt-3 py-4 text-end">
                <a href="{{ route('users') }}" class="btn btn-light border  m-0 model_footer_button">Back</a>
            </div>
        </div>
    </div>
</div>

@endsection
    @section('page-script')
        <script type="text/javascript">

function view(e,url){  
    $('#modal-md .modal-content').html('');
    var modal = 'modal-md';
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:url,
        type:"POST",
        data:{},
        dataType:"json",
        success: function(data) {  
            $('#' + modal + ' .modal-content').html(data.view);
            $('#' + modal).modal('show');  

        }
    });
}
</script>
@endsection