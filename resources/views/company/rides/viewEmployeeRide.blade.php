
@extends('layouts.app')
@section('content')

                <!--invoice table  -->
                <div class=" d-flex flex-wrap justify-content-between mb-4">
                    <h5 class="top_title">{{ $nav }}</h5>
                   
                </div>
                <input type="hidden" value="{{ $employee->id}}" name="employee_id" id="employee_id">
                <input type="hidden" value="{{ $ride_id}}" name="ride_id" id="ride_id">

                <!-- table  -->
                <div class="card border-0 mt-4 rounded-3">
                    <div class="card_header_custom ">
                      <div class="row">
                        <div class="col-md-8">
                        <div class="d-flex flex-sm-nowrap flex-wrap gap-3 align-items-center">
                            <h5 class="card-title table_caption mb-0 text-nowrap">All {{ $nav }}</h5>
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
                        <div class="col-md-4 text-end">
                            <h5 class="pt-2">{{ ucfirst($employee->firstname .' '. $employee->lastname)}}</h5>
                        </div>
                      </div>
                        </div> 
                    
                    <div class="card-body p-0 overflow-hidden ">  
                        <table id="dataTable" class="w-100 table table-condensed table-bordered f-12">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">S No.</th> 
                                    <th scope="col">Ride Date</th>
                                    <th scope="col">Home To Office Time</th>
                                    <th scope="col">Office To Home Time</th>  
                                    <th scope="col">Ride</th>  
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
         'url': "{{ route('company.view.employee.ride.list') }}",
         'data': function(data){
             data.searchname = $('#search').val();  
             data.type = $('#type').val();  
             data.employee_id = $('#employee_id').val();  
             data.ride_id = $('#ride_id').val();  
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
         { data: 'ride_date' }, 
         { data: 'home_to_office_pick_time' },  
         { data: 'office_to_home_pick_time' },
         { data: 'is_ride_complete' },
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
       function assignDriver(e,url){  
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
  
  
 function assignEmployee(e,url){  
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
  


 function updateTimeHomeToOffice(e,url,id){  
 
         $.ajax({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url:url,
             type:"POST",
             data:{
                'time':e.value,
                'id':id
             },
             dataType:"json",
             success: function(data) {    
              toastr.success(data.message,'Success');
                dataTable.draw(true);

             }
         });
     
 }
 

 function updateTimeOfficeToHome(e,url,id){  
 
         $.ajax({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url:url,
             type:"POST",
             data:{
                'time':e.value,
                'id':id
             },
             dataType:"json",
             success: function(data) {    
              toastr.success(data.message,'Success');
                dataTable.draw(true);

             }
         });
     
 }
 
</script>
@endsection