<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('comman.css_files')

</head>
<body>
   
    
<div class="modal fade" id="modal-md">
         <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                
            </div>
        </div>
    </div>


    <div class="modal fade auditor__modal" id="modal-xl" >
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
                
            </div>
        </div>
    </div>
    
    
    <div class="modal fade auditor__modal"  tabindex="-1" id="modal-admin" >
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div> -->
                <div class="modal-body">
                  <p></p>
                </div>
            </div>
        </div>
    </div>
  </div> 
  <style>
    .select2-container {
    width: 100% !important;
}
  </style>

    <div class="d-flex " id="wrapper">
      @include('comman.sidebar')
      <!-- Page Content -->
      <div id="page-content-wrapper" class="w-100">
       @include('comman.header')

      <!-- start dashbord content  -->
        <div class="container-fluid page_background " >
            @yield('content')
        </div>
      <!-- start dashbord content  -->  
      @include('comman.footer')
      </div>
      <!-- /#page-content-wrapper -->

  </div>

  <!-- Modal -->
<div class="modal fade query_reply_model" id="CommanModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content position-relative">
    </div>
  </div>
</div>

  @include('comman.js_files')
  @yield('page-script')
  
</body>
</html>
