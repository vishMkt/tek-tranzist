       <!-- Sidebar -->
       <nav id="sidebar" class="text-white active ">
           <div class="sidebar-header text-center primary-text py-1 px-2 mt-4 fs-4 fw-bold text-uppercase   border-bottom" style="font-family: PlusJakarta, sans-serif;">
               <button id="close-sidebar" class="btn btn-link text-white position-absolute"
                   style="top: 10px; right: 10px; font-size:15px;">
                   <i class="fas fa-times"></i>
               </button>
               <a class="nav-link dropdown-toggle avtar text-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
               <img src="{{asset('assets/icon/angel.jpg')}}" alt="user icon">
               
           </a>
               <p class="font_12_semibold text-center mt-1">{{ env('APP_NAME') }}</p>
            </div>
            {{-- <div class="info">
                <a href="javascript:void(0);"
                    class="d-block text-decoration-none">{{ Auth::guard('admin')->user()->name }}
                </a>
            </div> --}}
           <ul class="main_menu list-unstyled components  d-flex flex-column gap-2">
            @if (Auth::guard('admin')->check())
               <li class="{{ Route::currentRouteName()== 'admin' ? 'active' : '' }}">
                   <a href="{{ route('admin')}}" class="text-white">
                       <img src="{{ asset('assets/icon/dashboard.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Dashboard</span>
                   </a>
               </li>

               
               
               <div class="pcoded-navigation-label text-uppercase">User Management</div>
               <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'employee' || Route::currentRouteName()== 'employee.add' || Route::currentRouteName()== 'employee.edit' || Route::currentRouteName()== 'employee.view') ? 'active' : '' }}">
                   <a href="{{route('employee')}}">
                       <img src="{{asset('assets/icon/workforce.png')}}" alt="" class="me-2" style="width: 18px;height: 20px; filter: invert(1);">
                       <span class="pcoded-mtext ">Employees</span>
                   </a>
               </li>
               
                <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'users' || Route::currentRouteName()== 'users.create' || Route::currentRouteName()== 'users.edit' || Route::currentRouteName()== 'users.view')  ? 'active' : '' }}">
                    <a href="{{route('users')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Admin Users</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'driver' || Route::currentRouteName()== 'create.driver' || Route::currentRouteName()== 'edit.driver' || Route::currentRouteName()== 'view.driver') ? 'active' : '' }}">
                    <a href="{{route('driver')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Drivers</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'admin.vendor' || Route::currentRouteName()== 'create.vendor' || Route::currentRouteName()== 'edit.vendor' || Route::currentRouteName()== 'view.vendor') ? 'active' : '' }}">
                    <a href="{{route('admin.vendor')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Vendor</span>
                    </a>
                </li> 
               <div class="pcoded-navigation-label text-uppercase">Driver Management</div>
               
               <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'departments' || Route::currentRouteName()== 'departments.create' || Route::currentRouteName()== 'departments.edit' || Route::currentRouteName()== 'departments.view') ? 'active' : '' }}">
                    <a href="{{route('departments')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Departments</span>
                    </a>
                </li>
               <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'vehicle' || Route::currentRouteName()== 'create.vehicle' || Route::currentRouteName()== 'vehicle.edit' || Route::currentRouteName()== 'view.vehicle') ? 'active' : '' }}">
                   <a href="{{route('vehicle')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Vehicle</span>
                   </a>
               </li> 
               <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'vehicle.owner' || Route::currentRouteName()== 'create.vehicle.owner' || Route::currentRouteName()== 'edit.vehicle.owner' || Route::currentRouteName()== 'show.vehicle.owner') ? 'active' : '' }}">
                   <a href="{{route('vehicle.owner')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Vehicle Owner</span>
                   </a>
               </li>  
               <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'security.guard' || Route::currentRouteName()== 'create.security.guard' || Route::currentRouteName()== 'edit.security.guard' || Route::currentRouteName()== 'show.security.guard') ? 'active' : '' }}">
                   <a href="{{route('security.guard')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Security Guard</span>
                   </a>
               </li>
               <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'companies' || Route::currentRouteName()== 'create.companies' || Route::currentRouteName()== 'edit.companies' || Route::currentRouteName()== 'show.companies')  ? 'active' : '' }}">
                   <a href="{{route('companies')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Companies</span>
                   </a>
               </li> 
               <li class="pcoded-hasmenu d-flex flex-column {{ Route::currentRouteName()== 'rides' ? 'active' : '' }}">
                   <a href="{{route('rides')}}">
                       <img src="{{asset('assets/icon/car.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Rides</span>
                   </a>
               </li>  
               <li class="pcoded-hasmenu d-flex gap-2 flex-column sidemenu-toggle {{ Route::currentRouteName()== 'license' || Route::currentRouteName()== 'puc' || Route::currentRouteName()== 'insurance' ? 'active' : '' }}">
                    <a href="javascript:void(0)">
                        <img src="assets/icon/garage.svg" alt="" class="me-2">
                        <span class="pcoded-mtext ">Vehicle Document</span>
                        <i class="fa-solid fa-sort-down ms-auto  arrow-icon"></i>
                    </a>
                    <ul class="pcoded-submenu ps-0">
                        <li class="{{ Route::currentRouteName()== 'license' ? 'active' : '' }} d-none">
                            <a href="{{route('license')}}">
                                <span class="pcoded-mtext">License</span>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteName()== 'puc' ? 'active' : '' }} d-none">
                            <a href="{{route('puc')}}">
                                <span class="pcoded-mtext">PUC</span>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteName()== 'insurance' ? 'active' : '' }} d-none">
                            <a href="{{route('insurance')}}">
                                <span class="pcoded-mtext">Insurance</span>
                            </a>
                        </li>
                         <li class="{{ Route::currentRouteName()== 'make' ? 'active' : '' }}">
                            <a href="{{route('make')}}">
                                <span class="pcoded-mtext">Make</span>
                            </a>
                        </li> 
                        <li class="{{ Route::currentRouteName()== 'model' ? 'active' : '' }}">
                            <a href="{{route('model')}}">
                                <span class="pcoded-mtext">Model</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="pcoded-hasmenu d-flex flex-column {{ Route::currentRouteName()== 'site_setting' ? 'active' : '' }}">
                   <a href="{{route('site_setting')}}">
                       <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                       <span class="pcoded-mtext ">Site Setting</span>
                    </a>
                </li>
               
               
               
            @elseif (Auth::guard('company')->check())
                <li class="">
                    <a href="{{ route('company')}}" class="text-white">
                        <img src="{{ asset('assets/icon/dashboard.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Dashboard</span>
                    </a>
                </li>

                <div class="pcoded-navigation-label text-uppercase">User Management</div>
                <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'company.employee' || Route::currentRouteName()== 'company.employee.add' || Route::currentRouteName()== 'company.employee.edit' || Route::currentRouteName()== 'company.employee.view') ? 'active' : '' }}">
                    <a href="{{route('company.employee')}}">
                        <img src="{{asset('assets/icon/workforce.png')}}" alt="" class="me-2" style="width: 18px;height: 20px; filter: invert(1);">
                        <span class="pcoded-mtext ">Employees</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'company.vendor') ? 'active' : '' }}">
                    <a href="{{route('company.vendor')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Vendor</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu d-flex flex-column">
                    <a href="{{route('company.rides')}}">
                        <img src="{{asset('assets/icon/car.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Rides</span>
                    </a>
                </li> 
                <li class="pcoded-hasmenu d-flex flex-column {{ (Route::currentRouteName()== 'company.security.guard' || Route::currentRouteName()== 'company.security.guard.add' || Route::currentRouteName()== 'company.security.guard.edit' || Route::currentRouteName()== 'company.security.guard.view') ? 'active' : '' }}">
                    <a href="{{route('company.security.guard')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Security Guard</span>
                    </a>
                </li> 
                <li class="pcoded-hasmenu d-flex flex-column">
                    <a href="{{route('company.site_setting')}}">
                        <img src="{{asset('assets/icon/service.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Site Setting</span>
                    </a>
                </li>
            @elseif (Auth::guard('vendor')->check())
                <li class="">
                    <a href="{{ route('vendor')}}" class="text-white">
                        <img src="{{ asset('assets/icon/dashboard.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Dashboard</span>
                    </a>
                </li>

                <div class="pcoded-navigation-label text-uppercase">Vendor Management</div>
                <li class="pcoded-hasmenu d-flex flex-column {{ Route::currentRouteName()== 'vendor.driver' ? 'active' : '' }}">
                    <a href="{{route('vendor.driver')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Drivers</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu d-flex flex-column {{ Route::currentRouteName()== 'vendor.vehicle.owner' ? 'active' : '' }}">
                    <a href="{{route('vendor.vehicle.owner')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Vehicle Owner</span>
                    </a>
                </li>  
                <li class="pcoded-hasmenu d-flex flex-column {{ Route::currentRouteName()== 'vendor.vehicle' ? 'active' : '' }}">
                    <a href="{{route('vendor.vehicle')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Vehicle</span>
                    </a>
                </li> 
                <li class="pcoded-hasmenu d-flex flex-column {{ Route::currentRouteName()== 'vendor.rides' ? 'active' : '' }}">
                    <a href="{{route('vendor.rides')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Rides</span>
                    </a>
                </li> 
                {{-- <li class="pcoded-hasmenu d-flex flex-column {{ Route::currentRouteName()== 'departments' ? 'active' : '' }}">
                    <a href="{{route('departments')}}">
                        <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                        <span class="pcoded-mtext ">Departments</span>
                    </a>
                </li>
                
               

               
            <li class="pcoded-hasmenu d-flex flex-column {{ Route::currentRouteName()== 'security.guard' ? 'active' : '' }}">
                <a href="{{route('security.guard')}}">
                    <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                    <span class="pcoded-mtext ">Security Guard</span>
                </a>
            </li>
            <li class="pcoded-hasmenu d-flex flex-column {{ Route::currentRouteName()== 'companies' ? 'active' : '' }}">
                <a href="{{route('companies')}}">
                    <img src="{{asset('assets/icon/customer.svg')}}" alt="" class="me-2">
                    <span class="pcoded-mtext ">Companies</span>
                </a>
            </li>  --}}

            @endif
           </ul>
       </nav>