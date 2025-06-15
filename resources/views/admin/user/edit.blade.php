@extends('admin-layouts.master')

@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit User</h1>
    <div class="card">
        <div class="card-body">
            <form  action="{{ route('user.update', $user)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for=""@error('name') class="text-danger" @enderror >Nama user</label>
                    <input type="text" name="name" class="form-control @error('name') form-control is-invalid @enderror"
                    placeholder="" value="{{$user->name ?? old('name') }}">
                    @error('name')
                        <span  class="text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for=""@error('email') class="text-danger" @enderror >email user</label>
                    <input type="email" name="email" class="form-control @error('email') form-control is-invalid @enderror"
                    placeholder="" value="{{$user->email ?? old('email') }}">
                    @error('email')
                        <span  class="text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                
                <div class="form-group @error('roles') has-error @enderror " >
                    <label for=""@error('roles') class="text-danger" @enderror >Roles</label>
                    <select class="form-control" name="roles">
                        <option value="" selected disabled>Pilih</option>
                        @php
                        $pilihan = [ 'admin', 'dokter', 'pendaftar','kasir'];
                         
                        @endphp
                        @foreach ($pilihan as $key => $value)
                        <option value="{{ $value }}" @if($value == $user->roles) selected @endif>{{ $value}}</option>
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
                    <button onclick="history.back()" class="btn btn-danger mt-3"> Kembali</button>
                    <input type="submit" value="Update" class="btn btn-primary mt-3">
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection