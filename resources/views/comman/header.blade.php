  <!-- header -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container-fluid">
                <button class="btn btn-primary" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button> -->

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb align-items-center mb-0 ms-3">
                      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                      <li class="breadcrumb-item custom-divider">
                        <!-- <img src="assets\icon\right_arrow.svg" width="10" height="10" alt="Divider" class="divider-img" /> -->
                        Dashboard
                      </li>
                    </ol>
                  </nav>
                 

                <div class="navbar-collapse" id="navbarSupportedContent" style="flex-basis:auto;">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0 align-items-center d-flex flex-row justify-content-end">
                        <li class="nav-item active">
                            <a class="nav-link p-2" href="#">
                                <img src="{{asset('assets/icon/bell_header.svg')}}" alt="">
                            </a>
                        </li>
                        
                        @if (Auth::guard('admin')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle avtar" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('assets/icon/angel.jpg')}}" alt="user icon">
                                <span class="ps-2">{{ Auth::guard('admin')->user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item" >Logout</a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;"><input type="hidden" name="_token" value="{{ csrf_token() }}" /></form>
                            </div>
                        </li>
                        @elseif (Auth::guard('company')->check()) 
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle avtar" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('assets/icon/angel.jpg')}}" alt="user icon">
                                <span class="ps-2">{{ Auth::guard('company')->user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item" >Logout</a>
                                <form id="logout-form" action="{{ route('company.logout') }}" method="POST" style="display: none;"><input type="hidden" name="_token" value="{{ csrf_token() }}" /></form>
                            </div>
                        </li>
                        @elseif (Auth::guard('vendor')->check()) 
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle avtar" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('assets/icon/angel.jpg')}}" alt="user icon">
                                <span class="ps-2">{{ Auth::guard('vendor')->user()->firstname }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item" >Logout</a>
                                <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" style="display: none;"><input type="hidden" name="_token" value="{{ csrf_token() }}" /></form>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <!-- end header  -->