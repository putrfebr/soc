@extends('admin-layouts.master')

@section('content')
<style>
    /* Hover effect for cards */
    .hover-shadow:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        cursor: pointer;
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
</style>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Home</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{asset('ilustrasi/undraw_Welcoming.png')}}" class="img-fluid" alt="" width="350">
                        <h4 class="font-weight-bold">Hi {{ucfirst(Auth::user()->name)}} Selamat Datang Di Zerac </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Cards Row -->
    <div class="row mt-4">

        <!-- Card 1: SOC Index -->
        <div class="col-xl-6 col-md-6 mb-4">
            <a href="{{ route('soc.index') }}" class="text-decoration-none">
                <div class="card border-left-info shadow h-100 py-2 hover-shadow" style="transition: box-shadow 0.3s ease;">
                    <div class="card-body d-flex align-items-center justify-content-center flex-column">
                        <i class="fas fa-shield-alt fa-3x text-info mb-3"></i>
                        <h5 class="font-weight-bold text-info">SOC Dashboard</h5>
                        <p class="text-info">Lihat status dan laporan SOC Anda</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2: Dashboard -->
        <div class="col-xl-6 col-md-6 mb-4">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                <div class="card border-left-success shadow h-100 py-2 hover-shadow" style="transition: box-shadow 0.3s ease;">
                    <div class="card-body d-flex align-items-center justify-content-center flex-column">
                        <i class="fas fa-tachometer-alt fa-3x text-success mb-3"></i>
                        <h5 class="font-weight-bold text-success">Statistik</h5>
                        <p class="text-success">Pantau performa dan data penting Anda</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- Content Row -->

    

   
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection