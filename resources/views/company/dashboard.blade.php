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
        <p class="paragraph"> <a class="text-dark" href="{{ route('company.employee') }}">Related Link </a></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Vendor</span>
            <img src="assets/icon/garage1.svg" alt="" class=" ms-auto">
        </div>
        <span class="number_count">{{ App\Models\Vendor::get()->count();}}</span>
        <p class="paragraph"> <a class="text-dark" href="{{ route('company.vendor') }}">Related Link </a></p>
    </div>
    <div class="counter-card">
        <div class="icon mb-2">
            <span>Security Guard</span>
            <img src="assets/icon/service1.svg" alt="" class="ms-auto">
        </div>
        <span class="number_count">{{ App\Models\SecurityGuard::get()->count();}}</span>
        <p class="paragraph"> <a class="text-dark" href="{{ route('company.security.guard') }}">Related Link </a> </p>
    </div>
</div>
<!-- top counter  -->
 
  @endsection