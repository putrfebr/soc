@extends('admin-layouts.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    {{-- <h1 class="h3 mb-2 text-gray-800">Data SOC</h1> --}}
    

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data SOC</h6>
        </div>
        <div class="card-body">
            
            <div class="text-right px-3 py-3">
                @if(Auth::user()->roles == 'superadmin')
                <a href="{{ route('soc.create') }}" class="btn btn-outline-primary">
                    Input SOC
                </a>
                @endif

            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Divisi</th>
                            <th>Tanggal & Waktu</th>
                            <th>Lokasi</th>
                            <th>Golden Rules</th>
                            <th>Unsafe Action</th>
                            <th>Safe Behaviour</th>
                            <th>Cuaca</th>
                            <th>Resiko</th>
                            <th>Tindakan</th>






                           
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($soc as $u)
                        <tr>
                                
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$u->nama ?? ''}}</td>
                            <td>{{ $u->divisi }}</td>
                            <td>{{ $u->tanggal_waktu }}</td>
                            <td>{{ $u->lokasi }}</td>
                            <td>{{ $u->golden_rules == 1 ? 'Ya' : 'Tidak' }}</td>
                            <td>{{ $u->unsafe_action }}</td>
                            <td>{{ $u->safe_behaviour }}</td>
                            <td>{{ \App\Models\Soc::CUACA[$u->cuaca] ?? '' }}</td>
                            @if($u->risk == 'Rendah')
                            <td><span class="badge badge-pill badge-info">{{$u->risk}}</span></td>

                            @elseif ($u->risk == 'Sedang')
                            <td><span class="badge badge-pill badge-warning">{{$u->risk}}</span></td>
                            @elseif($u->risk == 'Tinggi')
                            <td><span class="badge badge-pill badge-danger">{{$u->risk}}</span></td>

                            @endif
                            <td>{{ $u->action }}</td>    
                            <td>
                                <a class="btn btn-info" href="{{ route('soc.show',$u) }}"><i class="fas fa-eye"></i></a>
                                @if(Auth::user()->roles == 'superadmin')
                                <a class="btn btn-warning" href="{{ route('soc.edit',$u->id) }}"><i class="fas fa-edit"></i></a>
                                <button href="{{route('soc.destroy', $u->id)}}" id="delete" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                @endif
                                {{-- <a class="btn btn-success" href=""><i class="fas fa-notes-medical"></i> Pemeriksaan</a> --}}
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

@endpush

@endsection