@extends('admin-layouts.master')

@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Form Pegawai</h1>
    <div class="card">
        <div class="card-body">
            <form  action="{{route($route.'.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $data->id??false }}">
                <div class="form-group">
                    <label for=""@error('username') class="text-danger" @enderror >Username</label>
                    <input type="text" name="username" class="form-control @error('username') form-control is-invalid @enderror"
                    placeholder="" value="{{ $data->username ?? '' }}">
                    @error('username')
                        <span  class="text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for=""@error('name') class="text-danger" @enderror >Nama Pegawai</label>
                    <input type="text" name="name" class="form-control @error('name') form-control is-invalid @enderror"
                    placeholder="" value="{{ $data->name ?? '' }}">
                    @error('name')
                        <span  class="text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for=""@error('email') class="text-danger" @enderror >Email</label>
                    <input type="email" name="email" class="form-control @error('email') form-control is-invalid @enderror"
                    placeholder="" value="{{ $data->email ?? '' }}">
                    @error('email')
                        <span  class="text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                
                <div class="form-group @error('roles') has-error @enderror " >
                    <label for=""@error('roles') class="text-danger" @enderror >Akses</label>
                    <select class="form-control" name="roles">
                        <option value="" selected disabled>Pilih</option>
                        @php
                        $pilihan = [ 'superadmin', 'registrasi-klaim', 'mobile-service', 'pj-pelayanan','keuangan-umum','pembayaran-klaim'];
                        @endphp
                        @foreach ($pilihan as $key => $value)
                            <option value="{{ $value }}" @if($value == $data->roles) selected @endif>{{ $value}}</option>
                        @endforeach
                    </select>
                    @error('roles')
                        <span  class="help-block"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for=""@error('password') class="text-danger" @enderror >Password</label>
                    <input type="password" name="password" class="form-control @error('password') form-control is-invalid @enderror"
                    placeholder="" value="">
                    @error('password')
                        <span  class="text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <a href="{{ route('user.index') }}" class="btn btn-danger mt-3"> Kembali</a>
                    <input type="submit" value="Simpan" class="btn btn-primary mt-3">
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection