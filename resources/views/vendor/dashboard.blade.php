@extends('layouts.app')
@section('content')
<!-- top counter  -->
<div class="counter-container">
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Total Bookings</span>
            <img src="assets/icon/totalcount.svg" alt="" class="ms-auto">
        </div>
        <span class="number_count">17,250</span>
        <p class="paragraph">+7.2% <span>more booking than usual</span></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Garages</span>
            <img src="assets/icon/garage1.svg" alt="" class=" ms-auto">
        </div>
        <span class="number_count">520</span>
        <p class="paragraph">+64 <span>new garages added this year</span></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Customers</span>
            <img src="assets/icon/customer1.svg" alt="" class="ms-auto">
        </div>
        <span class="number_count">24,789</span>
        <p class="paragraph"> 200 <span>new added this month</span></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Categories</span>
            <img src="assets/icon/category1.svg" alt="" class=" ms-auto">
        </div>
        <span class="number_count">4</span>
        <p class="paragraph">+1 <span>new category added this year</span></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Services</span>
            <img src="assets/icon/service1.svg" alt="" class="ms-auto">
        </div>
        <span class="number_count">250</span>
        <p class="paragraph">+1 <span>new services added this year</span> </p>
    </div>
</div>
<!-- top counter  -->

  <!-- table  -->
  <div class="card border-0 mt-4 rounded-3">
    <div class="card_header_custom d-flex flex-wrap gap-3 justify-content-between align-items-center ">
        <h5 class="card-title table_caption mb-0">Revenue Table</h5>
        <div class="input-group search_input "  style="max-width: 255px;">
            <div class="input-group-prepend">
              <div class="input-group-text in_put_group">
               <img src="assets/icon/Search_4.svg" alt="">
              </div>
            </div>
            <input type="text" class="form-control border-0 ps-0" placeholder="Search here" aria-label="Search here" style="background-color: #EFEFEF;">
          </div>

      </div>
    <div class="card-body p-0 overflow-hidden ">
      
      <!-- table  -->
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="thead-light">
            <tr>
              <th scope="col">Garage Name</th>
              <th scope="col">Booking Count</th>
              <th scope="col">Garage Revenue</th>
              <th scope="col">Admin Profit</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Auto haven garage</td>
              <td>180</td>
              <td>£370.68</td>
              <td class="text-success"><span class="success_button">£370.68</span></td> 
            </tr>
            <tr>
              <td>Paul d hooks automotive</td>
              <td>128</td>
              <td>£370.68</td>
              <td class="text-success"><span class="success_button">£370.68</span></td>
            </tr>
            <tr>
              <td>Automobiled motor services</td>
              <td>270</td>
              <td>£370.68</td>
              <td class="text-success"><span class="success_button">£370.68</span></td>
            </tr>
            <tr>
              <td>Bharat auto solution</td>
              <td>530</td>
              <td>£370.68</td>
              <td class="text-success"><span class="success_button">£370.68</span></td>
            </tr>
            <tr>
              <td>Tanmay mungfali car solution</td>
              <td>125</td>
              <td>£370.68</td>
              <td class="text-success"><span class="success_button">£370.68</span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- end table  -->

      <!-- pagination  -->
      <div class="pagination  d-flex flex-wrap gap-2 justify-content-md-between justify-content-center align-items-center ">
        <button class="page_navigation_prev" disabled><i class="fa-solid fa-arrow-left"></i> Previous</button>
        
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

        <button class="page_navigation_next">Next <i class="fa-solid fa-arrow-right"></i></i></button>
      </div>
        <!--end pagination  -->
    </div>
  </div>
  <!-- table  -->
  @endsection