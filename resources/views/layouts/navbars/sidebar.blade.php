<div class="sidebar" data-color="orange" data-background-color="grey" data-image="{{ asset('material') }}/img/sidebar-5.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://nrc.no/" class="simple-text logo-normal">
      {{ __('NRC') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('welcome') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('welcome') }}</p>
        </a>
      </li>
      @php
      $user = Auth::user();
      @endphp
     @if($user->usertype_id == '2')
<li class="nav-item{{ $activePage == 'approval' ? ' active' : '' }}">
  <a class="nav-link" href="{{ route('approval') }}">
    <i class="material-icons">dashboard</i>
      <p>{{ __('approval') }}</p>
  </a>
</li>

<li class="nav-item{{ $activePage == 'approval' ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('staffleaves') }}">
      <i class="material-icons">dashboard</i>
        <p>{{ __('staffleaves') }}</p>
    </a>
  </li>

    @endif



      {{-- <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Vacations & leaves') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li> --}}
      @if($user->hradmin == 'yes')
      <li class="nav-item {{ ($activePage == 'Users' || $activePage == 'create-new-user') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
            <i class="material-icons">perm_identity</i>
          <p>{{ __('Users') }}
            <b class="caret"></b>
          </p>
        </a>

        <div class="collapse hide" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'create-new-user' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.users.create') }}">
                <i class="material-icons">person_add</i>
                <span class="sidebar-normal">{{ __('Create new user') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'all-users' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="material-icons">supervisor_account</i>
                <span class="sidebar-normal"> {{ __('All users') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>


      <li class="nav-item{{ $activePage == 'allstaffleaves' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.allstaffleaves.index') }}">
          <i class="material-icons">library_books</i>
            <p>{{ __('All Staff Leaves') }}</p>
        </a>
      </li>
      @endif




      {{-- <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('table') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Users') }}</p>
        </a>
      </li> --}}

      <li class="nav-item{{ $activePage == 'all-leaves' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('leaves.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Leaves') }}</p>
        </a>
      </li>


      <li class="nav-item{{ $activePage == 'overtime' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('overtimes.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Overtime') }}</p>
        </a>
      </li>


      <li class="nav-item{{ $activePage == 'policies' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.policies.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('HR Policies') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'holidays' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.holidays.index') }}">
          <i class="material-icons">library_books</i>
            <p>{{ __('Holidays') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('language') }}">
          <i class="material-icons">language</i>
          <p>{{ __('RTL Support') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>
