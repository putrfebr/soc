@extends('admin-layouts.master')

@section('content')
<div class="container-fluid">

<div class="row">
    <div class="col">
        <div class="card shadow-lg mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary text-center">Mohon Maaf. Antrian Sedang Ditutup</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 50rem;"
                        src="{{ asset('template-admin/img/undraw_warning_cyit.png') }}" alt="">
                </div>
                <center>
                   
                </center>
            </div>
        </div>
    </div>
</div>
</div>

@endsection