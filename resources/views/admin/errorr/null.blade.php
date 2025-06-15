@extends('admin-layouts.master')

@section('content')
<div class="container-fluid">

<div class="row">
    <div class="col">
        <div class="card shadow-lg mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary text-center">Mohon Menunggu. Pasien Masih Sedang Diperiksa Oleh Dokter</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 40rem;"
                        src="{{ asset('template-admin/img/undraw_doctor_kw5l.png') }}" alt="">
                </div>
                <center>
                    <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                </center>
            </div>
        </div>
    </div>
</div>
</div>

@endsection