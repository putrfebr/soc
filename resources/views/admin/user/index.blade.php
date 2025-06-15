@extends('admin-layouts.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Pegawai</h1>
    

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        {{-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User</h6>
        </div> --}}
        <div class="card-body">
            <div class="text-right px-3 py-3">

                <a href="{{route($route.'.create')}}" class="btn btn-outline-primary">
                    Tambah Pegawai
                </a>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Akses</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                   
                    <tbody>
                        @foreach ($user as $u)
                        <tr>
                                
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->name }}</td>
                            <td>
                                @if($u->roles == 'superadmin')
                                    <span class="badge badge-primary">{{ $u->roles }}</span>
                                @elseif($u->roles == 'registrasi-klaim')
                                    <span class="badge badge-success">{{ $u->roles }}</span>
                                @elseif($u->roles == 'mobile-service')
                                    <span class="badge badge-warning">{{ $u->roles }}</span>
                                @elseif($u->roles == 'pj-pelayanan')
                                    <span class="badge badge-danger">{{ $u->roles }}</span>
                                @elseif($u->roles == 'keuangan-umum')
                                    <span class="badge badge-info">{{ $u->roles }}</span>
                                @else
                                    <span class="badge badge-dark">{{ $u->roles }}</span>
                                @endif
                            </td>
                            <td>{{ $u->email }}</td>
                            <td>
                                <a class="btn btn-warning" href="{{ route('user.edit',$u) }}"><i class="fas fa-edit"></i>Edit</a>
                                <button href="{{route('user.destroy', $u)}}" id="delete" class="btn btn-danger">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<form action="" method="post" id="deleteForm">
    @csrf
    @method("DELETE")
    <input type="submit" value="Hapus" style="display:none">
    </form>
    @push('scripts')
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script>
    $('button#delete').on('click', function(e){
      e.preventDefault();
    
      var href = $(this).attr('href');
    
      Swal.fire({
          title: 'Apakah Kamu yakin akan menghapus data ini?',
          text: "Data yang sudah dihapus tidak dapat dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus!'
          }).then((result) => {
          if (result.value) {
              document.getElementById('deleteForm').action = href;
              document.getElementById('deleteForm').submit();
                  Swal.fire(
                  'Berhasi Dihapus!',
                  'Data Kamu Berhasil Dihapus.',
                  'success'
                  )
              }
          })
    
    
    })
   
    </script>
<script src="{{ asset('template-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template-admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template-admin/js/demo/datatables-demo.js') }}"></script>
@endpush

@endsection