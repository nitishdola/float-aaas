<button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
  <span class="navbar-toggler-icon"></span>
</button>
<a class="navbar-brand" href="#">
  <img class="navbar-brand-full" src="{{ asset('assets/img/logo.png') }}" width="89" height="25" alt="CoreUI Logo">
  <img class="navbar-brand-minimized" src="img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
</a>
<button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
  <span class="navbar-toggler-icon"></span>
</button>
<ul class="nav navbar-nav d-md-down-none">
  <li class="nav-item px-3">
    <a class="nav-link" href="#">Dashboard</a>
  </li>
  <li class="nav-item px-3">
    <a class="nav-link" href="{{ route('admin.user.view_all') }}">Users</a>
  </li>

  <li class="nav-item px-3">
    <a class="nav-link" href="{{ route('admin.floats.create') }}">Upload Float</a>
  </li>

</ul>
<ul class="nav navbar-nav ml-auto">
  
  <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      {{ Auth::user()->name }}
    </a>
    <div class="dropdown-menu dropdown-menu-right">
      <a class="dropdown-item" href="{{ url('/admin/logout') }}"
          onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
          Logout
      </a>

      <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
    </div>
  </li>
</ul>
<button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
  <span class="navbar-toggler-icon"></span>
</button>
<button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
  <span class="navbar-toggler-icon"></span>
</button>