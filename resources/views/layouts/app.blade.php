<!DOCTYPE html>

<html lang="{{App::getLocale()}}" dir="{{(App::isLocale('en') ? 'ltr' : 'rtl')}}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HR 360</title>
  <link rel="icon" href="{{ asset('/fronththeme/hr.jpg')}}"/>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('fronththeme/plugins/fontawesome-free/css/all.min.css')}}">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">

  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>

  <!-- Theme style -->
  @if (App::isLocale('ar'))
  <link rel="stylesheet" href="{{ asset('fronththeme') }}/dist/css/fronththeme.rtl.min.css">
  @elseif (App::isLocale('ku'))
  <link rel="stylesheet" href="{{ asset('fronththeme') }}/dist/css/fronththeme.rtl.min.css">
  @else
  <link rel="stylesheet" href="{{ asset('fronththeme') }}/dist/css/fronththeme.min.css">
  @endif
</head>
<body class="hold-transition sidebar-mini">
    @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endauth
    {{-- @include('layouts.page_templates.auth')
@endauth --}}
@guest()
    @include('layouts.page_templates.guest')
@endguest
@auth

<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
<!-- Left navbar links -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
  </li>

</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
  <!-- Navbar Search -->
  {{-- <li class="nav-item">
    <a class="nav-link" href="{{ route('welcome') }}">
        <i class="fas fa-language fa-lg"></i>

    </a>
  </li> --}}

  <li class="nav-item dropdown">

    
    <a class="nav-link" href="" id="navbarDropdownLang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-mobile"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
     
      <a class="dropdown-item" href="/storage/hr360.apk">{{ __('sidebar.download') }}
        <i class="ml-2 fas fa-download"></i>
      
      </a>
    
    </div>
  </li>

  <li class="nav-item dropdown">
    <a class="nav-link" href="" id="navbarDropdownLang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-globe-africa"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
     
      <a class="dropdown-item" href="{{ route('locale',['locale'=>'en']) }}">English</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ route('locale',['locale'=>'ar']) }}" >العربية</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ route('locale',['locale'=>'ku']) }}" >کوردی</a>
    </div>
  </li>
  <li class="nav-item dropdown">
    <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-alt"></i>
      {{-- <p class="d-lg-none d-md-block">
        {{ __('Account') }}
      </p> --}}
      @php
          $user = Auth::user();
      @endphp
      {{$user->name}}
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
     
      {{-- <!-- <a class="dropdown-item" href="{{ route('changePasswordGet') }}">{{ __('sidebar.changepassword') }}</a> --> --}}
      {{-- <!-- <div class="dropdown-divider"></div> --> --}}
      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('sidebar.logout') }}</a>
    </div>
  </li>


</ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Logo -->
<a href="{{ route('welcome') }}" class="text-center brand-link">
  
  <p class="h1 mb-0" style="font-size:2.3rem;"> <img class="mb-0 ml-0" src="{{url('/nrc-nobg2.png')}}"  alt="" style="width:190px;height:60px;"></p>
</a>

<!-- Sidebar -->
<div class="sidebar">





  <!-- Sidebar Menu -->
  
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
 

           <li class="nav-item">
            <a class="nav-link {{ $activePage == 'dashboard' ? ' active' : '' }}" href="{{ route('welcome') }}">
                <i class="fas fa-address-card nav-icon"></i>
                <p>{{ __('sidebar.welcome') }}</p>
            </a>
          </li>
          <div class="dropdown-divider" style="border-color:rgb(77, 77, 77);"></div>
          <li class="nav-item">
            <a class="nav-link {{ $activePage == 'my-leaves' ? ' active' : '' }}" href="{{ route('leaves.index') }}">
                <i class="fas fa-running nav-icon"></i>
                <p>{{ __('sidebar.leaves') }}</p>
            </a>
          </li>
      
      <li class="nav-item">
        <a class="nav-link {{ $activePage == 'overtime' ? ' active' : '' }}" href="{{ route('overtimes.index') }}">
            <i class="fas fa-adjust nav-icon"></i>
            <p>{{ __('sidebar.overtimes') }}</p>
        </a>
      </li>
      {{-- <!-- <li class="nav-item">
        <a class="nav-link {{ $activePage == 'attendnace' ? ' active' : '' }}" href="{{ route('attendances.index') }}">
            <i class="fas fa-clock nav-icon"></i>
            <p>{{ __('Attendances') }}</p>
        </a>
      </li> --> --}}
      <div class="dropdown-divider" style="border-color:rgb(77, 77, 77);"></div>
  @php
  $user = Auth::user();


  @endphp
 

@if($user->hradmin == 'yes')

  <li class="nav-item {{ $activePage == 'createuser'||$activePage == 'all-users' ? ' menu-open' : ''  }}">
    <a href="#" class="nav-link {{ $activePage == 'createuser'||$activePage == 'all-users' ? ' active' : '' }}" >
        <i class="fas fa-users nav-icon"></i>
      <p>{{ __('sidebar.users') }}
        <i class="fas fa-angle-down right"></i>
      </p>
    </a>


      <ul class="nav nav-treeview ">
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'createuser' ? ' active' : '' }}" href="{{ route('admin.users.create') }}">
            <i style="padding-left:20px" class="fas fa-user-plus nav-icon"></i>
            <p style="padding-left:20px">{{ __('sidebar.createNewUser') }}</p>
          </a>
        </li>
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'all-users' ? ' active' : '' }}" href="{{ route('admin.users.index') }}">
            <i style="padding-left:20px" class="fas fa-address-book nav-icon"></i>
            <p style="padding-left:20px">{{ __('sidebar.allUsers') }}</p>
          </a>
        </li>
      </ul>

  </li>



  <li class="nav-item {{ $activePage == 'hrleavesapproval'||$activePage == 'hrovertimesapproval'||$activePage == 'attendanceshrapproval' ? ' menu-open' : ''  }}">
    <a href="#" class="nav-link {{ $activePage == 'hrleavesapproval'||$activePage == 'hrovertimesapproval'||$activePage == 'attendanceshrapproval' ? ' active' : '' }} " >
        <i class="fas fa-check nav-icon"></i>
      <p>{{ __('sidebar.hrApprovals') }}
        {{-- @php
            dd($numapproval);
            @endphp --}}
            @if ($numhrapproval > '0')
            <span class="ml-1 badge badge-primary"> {{$numhrapproval}} </span>
        @endif
    </p>
    <i class="fas fa-angle-down right"></i>
    </a>


      <ul class="nav nav-treeview">
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'hrleavesapproval' ? ' active' : '' }}" href="{{ route('leaves.hrapproval') }}">
            <i style="padding-left:10px" class="fas fa-running nav-icon "></i>
            <p style="padding-left:10px">{{ __('sidebar.leaveApproval') }}
                @if ($numleavehrapproval > '0')

            <span class="ml-1 badge badge-primary"> {{$numleavehrapproval}} </span>
        @endif

            </p>
          </a>
        </li>
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'hrovertimesapproval' ? ' active' : '' }}" href="{{ route('overtimes.hrapproval') }}">
            <i style="padding-left:10px" class="fas fa-adjust nav-icon"></i>
            <p style="padding-left:10px">{{ __('sidebar.overTimeApproval') }}
                @if ($numoverhrapproval > '0')
                <span class="ml-1 badge badge-primary"> {{$numoverhrapproval}} </span>
            @endif</p>
          </a>
        </li>

        {{-- <!-- <li class="nav-item" >
            <a class="nav-link {{ $activePage == 'attendanceshrapproval' ? ' active' : '' }}" href="{{ route('attendances.hrapproval') }}">
              <i style="padding-left:20px" class="fas fa-adjust nav-icon"></i>
              <p style="padding-left:20px">{{ __('Attendances') }}</p>
            </a>
          </li> --> --}}
      </ul>

  </li>


  <li class="nav-item">
    <a  class="as nav-link {{ $activePage == 'allstaffleaves' ? ' active' : '' }}" href="{{ route('admin.allstaffleaves.index') }}">
        <i class="fas fa-paste nav-icon"></i>
        <p>{{ __('sidebar.allStaffLeaves') }}</p>
    </a>
  </li>

  <li class="nav-item">
    <a  class="as nav-link {{ $activePage == 'allstaffovertimes' ? ' active' : '' }}" href="{{ route('admin.allstaffovertimes.index') }}">
        <i class="fas fa-adjust nav-icon"></i>
        <p>{{ __('sidebar.allStaffOverTimes') }}</p>
    </a>
  </li>




  {{-- <li class="nav-item {{ $activePage == 'leaveactivities'||$activePage == 'overtimeactivities'||$activePage == 'useractivities' ? ' menu-open' : ''  }}">
    <a href="#" class="nav-link {{ $activePage == 'leaveactivities'||$activePage == 'overtimeactivities'||$activePage == 'useractivities' ? ' active' : '' }} " >
        <i class="fas fa-check nav-icon"></i>
      <p>{{ __('Activity Log') }}

    </p>
    <i class="fas fa-angle-down right"></i>
    </a>


      <ul class="nav nav-treeview">
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'leaveactivities' ? ' active' : '' }}" href="{{ route('admin.activityleaves.index') }}">
            <i style="padding-left:20px" class="fas fa-running nav-icon "></i>
            <p style="padding-left:20px">{{ __('Leave Activity') }}

            </p>
          </a>
        </li>
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'overtimeactivities' ? ' active' : '' }}" href="{{ route('admin.activityovertimes.index') }}">
            <i style="padding-left:20px" class="fas fa-adjust nav-icon"></i>
            <p style="padding-left:20px">{{ __('Overtime Activity') }}

            </p>
          </a>
        </li>
        <li class="nav-item" >
            <a class="nav-link {{ $activePage == 'useractivities' ? ' active' : '' }}" href="{{ route('admin.activityusers.index') }}">
              <i style="padding-left:20px" class="fas fa-adjust nav-icon"></i>
              <p style="padding-left:20px">{{ __('Users Activity') }}

              </p>
            </a>
          </li>
      </ul>

  </li> --}}





  <div class="dropdown-divider" style="border-color:rgb(77, 77, 77);"></div>
  @endif





      @if($user->usertype_id == '2')

 <li class="nav-item {{ $activePage == 'leavesapproval'||$activePage == 'overtimesapproval'||$activePage == 'attendancesapproval' ? ' menu-open' : ''  }}">
    <a href="#" class="nav-link {{ $activePage == 'leavesapproval'||$activePage == 'overtimesapproval'||$activePage == 'attendancesapproval' ? ' active' : '' }} " >
        <i class="fas fa-check nav-icon"></i>
      <p>{{ __('sidebar.approvals') }}
        {{-- @php
            dd($numapproval);
            @endphp --}}
            @if ($numapproval > '0')

            <span class="ml-1 badge badge-primary"> {{$numapproval}} </span>
        @endif
        <i class="fas fa-angle-down right"></i>
      </p>
    </a>


      <ul class="nav nav-treeview">
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'leavesapproval' ? ' active' : '' }}" href="{{ route('leaves.approval') }}">
            <i style="padding-left:20px" class="fas fa-running nav-icon "></i>
            <p style="padding-left:20px">{{ __('sidebar.leaveApproval') }}
                @if ($numleaveapproval > '0')

            <span class="ml-1 badge badge-primary"> {{$numleaveapproval}} </span>
        @endif

            </p>
          </a>
        </li>
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'overtimesapproval' ? ' active' : '' }}" href="{{ route('overtimes.approval') }}">
            <i style="padding-left:20px" class="fas fa-adjust nav-icon"></i>
            <p style="padding-left:20px">{{ __('sidebar.overTimeApproval') }}
                @if ($numoverapproval > '0')
                <span class="ml-1 badge badge-primary"> {{$numoverapproval}} </span>
            @endif</p>
          </a>
        </li>

        {{-- <!-- <li class="nav-item" >
            <a class="nav-link {{ $activePage == 'attendancesapproval' ? ' active' : '' }}" href="{{ route('attendances.lmapproval') }}">
              <i style="padding-left:20px" class="fas fa-adjust nav-icon"></i>
              <p style="padding-left:20px">{{ __('Attendances') }}</p>
            </a>
          </li> --> --}}
      </ul>

  </li>



<li class="nav-item">
<a class="nav-link {{ $activePage == 'staffleaves' ? ' active' : '' }}" href="{{ route('staffleaves') }}">
    <i class="fas fa-paste nav-icon"></i>
    <p>{{ __('sidebar.myStaff') }}</p>
</a>
</li>

<div class="dropdown-divider" style="border-color:rgb(77, 77, 77);"></div>
@endif
  <li class="nav-item">
    <a class="nav-link {{ $activePage == 'policies' ? ' active' : '' }}" href="{{ route('admin.policies.index') }}">
        <i class="fas fa-file-alt nav-icon"></i>
        <p>{{ __('sidebar.hrPolicies') }}</p>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ $activePage == 'holidays' ? ' active' : '' }}" href="{{ route('admin.holidays.index') }}">
        <i class="fas fa-umbrella-beach nav-icon"></i>
        <p>{{ __('sidebar.holidays') }}</p>
    </a>
  </li>

  <div class="dropdown-divider" style="border-color:rgb(77, 77, 77);"></div>
  <li class="nav-item">
    <a class="nav-link {{ $activePage == 'offices' ? ' active' : '' }}" href="{{ route('admin.offices.index') }}">
        <i class="fas fa-file-alt nav-icon"></i>
        <p>{{ __('sidebar.systemsettings') }}</p>
    </a>
  </li>

    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div id="load"></div>
@yield('content')
<!-- Content Header (Page header) -->

<!-- /.content-header -->

<!-- Main content -->

<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
{{-- <aside class="control-sidebar control-sidebar-dark">
<!-- Control sidebar -->
<div class="p-3">
  <h5>Title</h5>
  <p>Sidebar content</p>
</div>
</aside> --}}
<!-- /.control-sidebar -->
@endauth

  <!-- Main Footer -->
  @auth()
  @if ($_SERVER['REQUEST_URI'] !== "/welcome")
  <footer style="background-color: #f4f6f9;padding: 0rem;border-top: 0px solid #dee2e6;" class="main-footer">
    <!-- To the right -->
    
    <!-- Default to the left -->
    
    <p style="background-color: #f4f6f9;" class=" text-right mb-0"><img class="text-right mb-0 mr-2 ml-0" src="{{url('/hr360-3-noBG.png')}}"  alt="" style=" width:140px;height:40px;"> <br>  Powered by <strong >ICT Syria &copy; </strong></p>
   
  </footer>
  @endif
  @endauth
</div>
<style>
            .loadingDiv{
              position:absolute;
width: 100%;
height: 100vh;
    z-index:9999;
    background:#fff url("/loading.gif") no-repeat center center;
}
          </style>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

{{-- <script src="{{ asset('fronththeme') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('fronththeme') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- fronththeme App -->
<script src="{{ asset('fronththeme') }}/dist/js/fronththeme.min.js"></script>

<script src={{"/fronththeme/dist/js/fronththeme.min.js"}}></script>
<script src={{"/fronththeme/plugins/jquery/jquery.min.js"}}></script>
<script src={{"/fronththeme/plugins/bootstrap/js/bootstrap.bundle.min.js"}}></script> --}}

<script src="{{ asset('fronththeme/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('fronththeme/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('fronththeme/dist/js/fronththeme.min.js')}}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script  src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>

@stack('scripts')

<script>
$('.as').click(function(){
   $('<div class=loadingDiv>loading...</div>').prependTo("#load"); 
});

</script>

</body>
</html>
