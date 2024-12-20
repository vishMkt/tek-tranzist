
@extends('layouts.app')
@section('content')

                <!--invoice table  -->
                <div class=" d-flex flex-wrap justify-content-between mb-4">
                    <h5 class="top_title">{{ $nav }}</h5>
                   
                    <button type="button" class="ctn_button d-flex flex-wrap align-items-center justify-content-center border-0" data-bs-toggle="modal" data-bs-target="#categoryModal">
                        <img src="{{ asset('assets/icon/add_icon.svg')}}" alt="" style=" width: 20px; height: 20px; margin-right: 8px;">
                        Add new {{ $nav }}
                    </button>
                </div>

                <!-- table  -->
                <div class="card border-0 mt-4 rounded-3">
                    <div class="card_header_custom d-flex flex-wrap gap-3 justify-content-between align-items-center ">
                        <div class="d-flex flex-sm-nowrap flex-wrap gap-3 align-items-center">
                            <h5 class="card-title table_caption mb-0 text-nowrap">All services</h5>
                            <div class="input-group search_input " style="max-width: 255px;">
                                <div class="input-group-prepend">
                                    <div class="input-group-text in_put_group" style="outline:0;">
                                        <img src="{{ asset('assets/icon/Search_4.svg')}}" alt="">
                                    </div>
                                </div>
                                <input type="text" class="form-control border-0 ps-0 shadow-none"
                                    placeholder="Search here" aria-label="Search here"
                                    style="background-color: #EFEFEF;">
                            </div>
                        </div>
                        <div class="d-flex flex-wrap      align-items-center gap-3 ">
                            <a href="javscript:void();" class="action_btn font_14_medium text_dark">
                                <img src="{{ asset('assets/icon/arrow-left.svg') }}" alt="filter icon">
                                Filter</a>
                            <a href="javscript:void();" class="action_btn font_14_medium text_dark">
                                <img src="{{ asset('assets/icon/download.svg') }}" alt="filter icon">
                                Export</a>
                            <a href="javscript:void();" class="action_btn font_14_medium text_dark align-items-start">
                                Action
                                <i class="fa-solid fa-sort-down"></i></a>

                        </div>

                    </div>
                    <div class="card-body p-0 overflow-hidden ">
                        
                        <!-- table  -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="width: 6%;"> 
                                            <div class="form-check">
                                            <input class="form-check-input shadow-none" type="checkbox" value="" id="flexCheckIndeterminate"> 
                                            </div>
                                            
                                        </th>
                                        <th scope="col">SERVICE NAME</th>
                                        <th scope="col">CATEGORY name</th>
                                        <th scope="col">Control</th>
                                        <th scope="col" style="width: 6%;">ACTION
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                            <input class="form-check-input shadow-none" type="checkbox" value="" id="flexCheckIndeterminate"> 
                                            </div>
                                        </td>
                                       
                                        <td>Interior Cleaning</td>
                                        <td>Car detailing</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" checked>
                                            </div>
                                        </td>
                                        <td>
                                            <div class=" custom_dropdown">
                                                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                                                  <i class="fa-solid fa-ellipsis"></i>
                                                </div>
                                                <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                                                  
                                                  <li ><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                    <img src="{{ asset('assets/icon/Report_icon.svg') }}" alt="view invoice" class="me-3">Edit</a></li>
                                                    <li><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                        <img src="{{ asset('assets/icon/Delete_icon.svg') }}" alt="delete invoice" class="me-3">Delete</a></li>
                                                </ul>
                                              </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                            <input class="form-check-input shadow-none" type="checkbox" value="" id="flexCheckIndeterminate"> 
                                            </div>
                                        </td>
                                       
                                        <td>Interior Cleaning</td>
                                        <td>Car detailing</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" checked>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown custom_dropdown">
                                                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                                                  <i class="fa-solid fa-ellipsis"></i>
                                                </div>
                                                <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                                                  
                                                  <li ><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                    <img src="{{ asset('assets/icon/Report_icon.svg') }}" alt="view invoice" class="me-3">Edit</a></li>
                                                    <li><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                        <img src="{{ asset('assets/icon/Delete_icon.svg') }}" alt="delete invoice" class="me-3">Delete</a></li>
                                                </ul>
                                              </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                            <input class="form-check-input shadow-none" type="checkbox" value="" id="flexCheckIndeterminate"> 
                                            </div>
                                        </td>
                                       
                                        <td>Interior Cleaning</td>
                                        <td>Car detailing</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" checked>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown custom_dropdown">
                                                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                                                  <i class="fa-solid fa-ellipsis"></i>
                                                </div>
                                                <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                                                  
                                                  <li ><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                    <img src="{{ asset('assets/icon/Report_icon.svg') }}" alt="view invoice" class="me-3">Edit</a></li>
                                                    <li><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                        <img src="{{ asset('assets/icon/Delete_icon.svg') }}" alt="delete invoice" class="me-3">Delete</a></li>
                                                </ul>
                                              </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                            <input class="form-check-input shadow-none" type="checkbox" value="" id="flexCheckIndeterminate"> 
                                            </div>
                                        </td>
                                       
                                        <td>Interior Cleaning</td>
                                        <td>Car detailing</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" checked>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown custom_dropdown">
                                                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                                                  <i class="fa-solid fa-ellipsis"></i>
                                                </div>
                                                <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                                                  
                                                  <li ><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                    <img src="{{ asset('assets/icon/Report_icon.svg') }}" alt="view invoice" class="me-3">Edit</a></li>
                                                    <li><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                        <img src="{{ asset('assets/icon/Delete_icon.svg') }}" alt="delete invoice" class="me-3">Delete</a></li>
                                                </ul>
                                              </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                            <input class="form-check-input shadow-none" type="checkbox" value="" id="flexCheckIndeterminate"> 
                                            </div>
                                        </td>
                                       
                                        <td>Interior Cleaning</td>
                                        <td>Car detailing</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" checked>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown custom_dropdown">
                                                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                                                  <i class="fa-solid fa-ellipsis"></i>
                                                </div>
                                                <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                                                  
                                                  <li ><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                    <img src="{{ asset('assets/icon/Report_icon.svg') }}" alt="view invoice" class="me-3">Edit</a></li>
                                                    <li><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                        <img src="{{ asset('assets/icon/Delete_icon.svg') }}" alt="delete invoice" class="me-3">Delete</a></li>
                                                </ul>
                                              </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                            <input class="form-check-input shadow-none" type="checkbox" value="" id="flexCheckIndeterminate"> 
                                            </div>
                                        </td>
                                       
                                        <td>Interior Cleaning</td>
                                        <td>Car detailing</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" checked>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown custom_dropdown">
                                                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                                                  <i class="fa-solid fa-ellipsis"></i>
                                                </div>
                                                <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                                                  
                                                  <li ><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                    <img src="{{ asset('assets/icon/Report_icon.svg') }}" alt="view invoice" class="me-3">Edit</a></li>
                                                    <li><a class="dropdown-item font_14_semibold text_dark_opacity" href="#">
                                                        <img src="{{ asset('assets/icon/Delete_icon.svg') }}" alt="delete invoice" class="me-3">Delete</a></li>
                                                </ul>
                                              </div>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- end table  -->

                        <!-- pagination  -->
                        <div
                            class="pagination  d-flex flex-wrap gap-2 justify-content-md-between justify-content-center align-items-center ">
                            <button class="page_navigation_prev" disabled><i class="fa-solid fa-arrow-left"></i>
                                Previous</button>

                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0 p-md-0 flex-wrap">
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><span class="page-link">...</span></li>
                                    <li class="page-item"><a class="page-link" href="#">8</a></li>
                                    <li class="page-item"><a class="page-link" href="#">9</a></li>
                                    <li class="page-item"><a class="page-link" href="#">10</a></li>
                                </ul>
                            </nav>

                            <button class="page_navigation_next">Next <i
                                    class="fa-solid fa-arrow-right"></i></i></button>
                        </div>
                        <!--end pagination  -->
                    </div>
                </div>
                <!-- table  -->
                <!--end invoice table  -->

     
<!-- Modal -->
<div class="modal fade query_reply_model" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog " style="max-width: 368px; padding-top:70px;">
      <div class="modal-content position-relative">
        <!-- Close Button -->
        <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close" style="top: 10px; right: 10px;"></button>
        
        <!-- Modal Header -->
        <div class="modal-header border-0 justify-content-center">
          <h5 class="modal-title" id="categoryModalLabel">Create new service</h5>
        </div>
        
        <!-- Modal Body -->
        <div class="modal-body text-center px-4">
          
          <!-- Input Field -->
          <input type="text" name="servicename" class="mt-2 form-control shadow-none  border-0  mb-3" placeholder="Service name" >

          <select class="form-select shadow-none border-0 " name="category">
            <option selected disabled>Select category type</option>
            <option value="1">Type 1</option>
            <option value="2">Type 2</option>
            <option value="3">Type 3</option>
          </select>
        </div>
        
        <!-- Modal Footer -->
        <div class="modal-footer border-0 px-4 pt-2 py-4">
          <button type="button" class="btn btn-primary w-100 m-0 model_footer_button">Add</button>
        </div>
      </div>
    </div>
  </div>
  <!--End Modal -->
@endsection