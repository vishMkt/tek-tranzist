@extends('layouts.app')
@section('content')
<!-- top counter  -->
<div class="counter-container">
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Employee</span>
            <img src="assets/icon/totalcount.svg" alt="" class="ms-auto">
        </div>
        <span class="number_count">{{ App\Models\User::get()->count();}}</span>
        <p class="paragraph"> <a class="text-dark" href="{{ route('employee') }}">Related Link </a></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Driver</span>
            <img src="assets/icon/totalcount.svg" alt="" class="ms-auto">
        </div>
        <span class="number_count">{{ App\Models\Driver::get()->count();}}</span>
        <p class="paragraph"> <a class="text-dark" href="{{ route('driver') }}">Related Link </a></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Vendor</span>
            <img src="assets/icon/garage1.svg" alt="" class=" ms-auto">
        </div>
        <span class="number_count">{{ App\Models\Vendor::get()->count();}}</span>
        <p class="paragraph"> <a class="text-dark" href="{{ route('admin.vendor') }}">Related Link </a></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Departments</span>
            <img src="assets/icon/customer1.svg" alt="" class="ms-auto">
        </div>
        <span class="number_count">{{ App\Models\Department::get()->count();}}</span>
        <p class="paragraph"> <a class="text-dark" href="{{ route('departments') }}">Related Link </a></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Vehicle</span>
            <img src="assets/icon/category1.svg" alt="" class=" ms-auto">
        </div>
        <span class="number_count">{{ App\Models\Vehicle::get()->count();}}</span>
        <p class="paragraph"> <a class="text-dark" href="{{ route('vehicle') }}">Related Link </a></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Vehicle Owner</span>
            <img src="assets/icon/service1.svg" alt="" class="ms-auto">
        </div>
        <span class="number_count">{{ App\Models\VehicleOwner::get()->count();}}</span>
        <p class="paragraph"> <a class="text-dark" href="{{ route('vehicle.owner') }}">Related Link </a> </p>
    </div> 
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Security Guard</span>
            <img src="assets/icon/service1.svg" alt="" class="ms-auto">
        </div>
        <span class="number_count">{{ App\Models\SecurityGuard::get()->count();}}</span>
        <p class="paragraph"> <a class="text-dark" href="{{ route('security.guard') }}">Related Link </a> </p>
    </div>
</div>
<!-- top counter  -->


  <!-- table  -->
  @endsection