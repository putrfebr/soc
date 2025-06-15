<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">Zerac
            <sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Home</span></a>
    </li>
   
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

   
    @if(Auth::user()->roles == 'superadmin' || Auth::user()->roles == 'manager')
    <li class="nav-item">
        <a class="nav-link" href="{{route('soc.index')}}">
            <i class="fas fa-file-signature"></i>
            <span>SOC</span></a>
    </li>
    <li class="nav-item ">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Statistik</span></a>
    </li>
    @endif
    {{-- @if(Auth::user()->roles == 'superadmin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('kepala-perwakilan.index') }}">
            <i class="fas fa-hospital-user"></i>
            <span>Upload Foto</span></a>
    </li>
    @endif
    @if(Auth::user()->roles == 'superadmin' || Auth::user()->roles == 'keuangan-umum')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('keuangan-umum.index') }}">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Info</span></a>
    </li>
    @endif
     --}}


    @if(Auth::user()->roles == 'superadmin' )
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2"
            aria-expanded="true" aria-controls="collapsePages2">
            <i class="fas fa-users"></i>
            <span>Hazard</span>
        </a>
        <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('soc.index')}}">Input SOC</a>
                <a class="collapse-item" href="{{ route('user.index') }}">Upload Foto</a>
            </div>
        </div>
    </li> --}}


    @endif
    <!-- Nav Item - Pages Collapse Menu -->
   

   
    <div class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
    </div>
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
   

</ul>