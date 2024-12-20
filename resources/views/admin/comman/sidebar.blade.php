       <!-- Sidebar -->
       <nav id="sidebar" class="text-white active ">
           <div class="sidebar-header text-center primary-text py-4 mt-4 fs-4 fw-bold text-uppercase ">
               <button id="close-sidebar" class="btn btn-link text-white position-absolute"
                   style="top: 10px; right: 10px; font-size:15px;">
                   <i class="fas fa-times"></i>
               </button>
           </div>
           <ul class="main_menu list-unstyled components  d-flex flex-column gap-2">
               <li class="">
                   <a href="{{ route('dashboard')}}" class="text-white">
                       <img src="{{ asset('assets/icon/dashboard.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Dashboard</span>
                   </a>
               </li>

               <div class="pcoded-navigation-label text-uppercase">User Management</div>
               <li class="pcoded-hasmenu d-flex flex-column">
                   <a href="{{route('employee')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Employees</span>
                   </a>
               </li>

               <div class="pcoded-navigation-label text-uppercase">Driver Management</div>
               <li class="pcoded-hasmenu d-flex flex-column">
                   <a href="{{route('driver')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Drivers</span>
                   </a>
               </li>
               <li class="pcoded-hasmenu d-flex flex-column">
                   <a href="{{route('vehicle')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Vehicle</span>
                   </a>
               </li>
               <li class="pcoded-hasmenu d-flex flex-column">
                   <a href="{{route('vendor')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Vendor</span>
                   </a>
               </li> 
               <li class="pcoded-hasmenu d-flex flex-column">
                   <a href="{{route('rides')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Rides</span>
                   </a>
               </li> 
               <li class="pcoded-hasmenu d-flex gap-2 flex-column sidemenu-toggle">
                    <a href="javascript:void(0)">
                        <img src="assets/icon/garage.svg" alt="" class="me-2">
                        <span class="pcoded-mtext ">Vehicle Document</span>
                        <i class="fa-solid fa-sort-down ms-auto  arrow-icon"></i>
                    </a>
                    <ul class="pcoded-submenu ps-0">
                        <li class="">
                            <a href="{{route('license')}}">
                                <span class="pcoded-mtext">License</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{route('puc')}}">
                                <span class="pcoded-mtext">PUC</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{route('insurance')}}">
                                <span class="pcoded-mtext">Insurance</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="pcoded-hasmenu d-flex flex-column">
                   <a href="{{route('site_setting')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Site Setting</span>
                   </a>
               </li>
           </ul>

           
       </nav>