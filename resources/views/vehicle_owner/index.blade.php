@extends('layouts.app')
@section('content')

                <!--invoice table  -->
                <div class=" d-flex flex-wrap justify-content-between mb-4">
                    <h5 class="top_title">{{ $nav }}</h5>
                   
                    
                    <a href="{{ route('create.vehicle.owner')}}" class="ctn_button d-flex flex-wrap align-items-center justify-content-center border-0" >
                        <img src="{{ asset('assets/icon/add_icon.svg')}}" alt="" style=" width: 20px; height: 20px; margin-right: 8px;">
                        Add New {{ $nav }}
                    </a>
                </div>

                <!-- table  -->
                <div class="card border-0 mt-4 rounded-3">
                    <div class="card_header_custom d-flex flex-wrap gap-3 justify-content-between align-items-center ">
                        <div class="d-flex flex-sm-nowrap flex-wrap gap-3 align-items-center">
                            <h5 class="card-title table_caption mb-0 text-nowrap">All {{$nav}}</h5>
                            <div class="input-group search_input " style="max-width: 255px;">
                                <div class="input-group-prepend">
                                    <div class="input-group-text in_put_group" style="outline:0;">
                                        <img src="{{ asset('assets/icon/Search_4.svg')}}" alt="">
                                    </div>
                                </div>
                                <input id="search" type="text" class="form-control border-0 ps-0 shadow-none"
                                    placeholder="Search here" aria-label="Search here"
                                    style="background-color: #EFEFEF;" oninput="serchname(this)">
                            </div>
                        </div> 
                        </div> 
                    
                    <div class="card-body p-0 overflow-hidden ">  
                        <table id="dataTable" class="table table-condensed table-bordered f-12 w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">S No.</th>
                                    <th scope="col">Vendor</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody> 
                            </tbody>
                        </table> 
                        
                    </div>
                </div> 
      
@endsection 
@section('page-script')
 
<script type="text/javascript">


   

var gmapKey = "{{ env('googleMap.key') }}";
        var gmapLib = "{{ env('googleMap.libraries') }}";
        $.getScript('https://maps.googleapis.com/maps/api/js?key=' + gmapKey + '&libraries=' + gmapLib, () => {
            var address = (document.getElementById('project_lookup'));
            var options = {
                fields: ["formatted_address", "geometry", "name"],
            };
            var autocomplete = new google.maps.places.Autocomplete(address,options);
            autocomplete.setTypes(['geocode']);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                // console.log(place.countary);
                console.log(place.geometry.location.lat());
                console.log(place.geometry.location.lng());
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('long').value = place.geometry.location.lng();
            });
        });
    
$(document).ready(function(){
    
    dataTable = $('#dataTable').DataTable({
       dom: 'Bfrtip',
       buttons: [],
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'searching':false, 
      "language": {
          "infoFiltered": "",
          "processing":  '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
       },
                
      //'searching': false,
      'ajax': {
        'headers': {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
         'url': "{{ route('list.vehicle.owner') }}",
         'data': function(data){
             data.searchname = $('#search').val();  
             data.type = $('#type').val();  
         }
      },
      "drawCallback": function () {
         
        $('#dataTable').wrap('<div class="table-responsive"></div>');

        $('#dataTable_paginate').addClass('pagination  d-flex flex-wrap gap-2 justify-content-md-between justify-content-center align-items-center');
        $('#dataTable_paginate .previous').addClass('page_navigation_prev');
        $('#dataTable_paginate .next').addClass('page_navigation_next');
        $('#dataTable_paginate .previous').prepend('<i class="fa-solid fa-arrow-left me-1"></i>');
        $('#dataTable_paginate .next').append('<i class="fa-solid fa-arrow-right ms-1"></i>');
        $('#dataTable_paginate span').addClass('Page_navigation');
        $('#dataTable_paginate span a').wrap('<li class="page-item"></li>');
        $('#dataTable_paginate span a').addClass('page-link');
        $('#dataTable_paginate  .current').parent().addClass('active');
        $('#dataTable_paginate span .page-item').wrapAll('<ul class="pagination mb-0 p-md-0 flex-wrap"></ul>');
       
      
        
    },
      'lengthMenu': [10, 20, 50, 100, 200, 500],         
        'columns': [
         { data: 'sno' }, 
         { data: 'vendor' }, 
         { data: 'name' }, 
         { data: 'email' }, 
         { data: 'phone' }, 
         { data: 'status' }, 
         { data: 'action' },
       ],
  "columnDefs": [
 { 
   "targets": [], //first column / numbering column
   "orderable": false, //set not orderable
 }]
 
    });
   $('#datatable').on('page.dt', function() {
       $('#checkAll').prop("checked", false);
       $('.filed_check').prop("checked", false);
   });

   dataTable.on('page.dt', function() {
       $('html, body').animate({
          scrollTop: $(".dataTables_wrapper").offset().top
       }, 'slow');
    });


});


function serchname(e){
    dataTable.draw(true);  
 }

 


       function add(e){
     
            $('#modal-md .modal-content').html('');
                var modal = 'modal-md';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('create.vehicle.owner') }}",
                    type:"POST",
                    data:{},
                    dataType:"json",
                    success: function(data) { 
                        $('#' + modal + ' .modal-content').html(data.view);
                        $('#' + modal).modal('show');  
                    }
                });
            
        }

        

       function edit(e,url){  
     $('#modal-md .modal-content').html('');
         var modal = 'modal-md';
         $.ajax({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url:url,
             type:"GET",
             data:{},
             dataType:"json",
             success: function(data) {  
                 $('#' + modal + ' .modal-content').html(data.view);
                 $('#' + modal).modal('show');  

             }
         });
     
 }
  
 function viewdetail(e,url){  
     $('#modal-md .modal-content').html('');
         var modal = 'modal-md';
         $.ajax({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url:url,
             type:"GET",
             data:{},
             dataType:"json",
             success: function(data) {  
                 $('#' + modal + ' .modal-content').html(data.view);
                 $('#' + modal).modal('show');  

             }
         });
     
 }
 
 function delete_data(e,url,id){   
         $.ajax({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url:url,
             type:"GET",
             data:{
                'id':id
             },
             dataType:"json",
             success: function(data) {    
              toastr.success(data.message,'Success');
                dataTable.draw(true);

             }
         });
     
 }

 function  statusRow(e,url) {
    var type=0;
    if($(e).prop("checked") == true){
        type=1;
    }
    if(confirm("Are you sure want to change status?")){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('status', type);
        $.ajax({
            url: url,
            method: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success == 1) {
                    toastr.success(response.message, 'Success');
                    table.draw(false);
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
            }
        });
    }else{
        if($(e).prop("checked") == true){
            $(e).prop('checked', false);
        }else{
            $(e).prop('checked', true);
        }
    }
}


  
</script>
@endsection