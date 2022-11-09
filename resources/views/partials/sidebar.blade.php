<aside class="main-sidebar sidebar-dark-primary elevation-4" id="sidebar">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ \Helper::getGeneralSetting('app_name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{(auth()->user()->image == 'default.png') ? asset('images/users/'.auth()->user()->image) : asset('images/users/'.auth()->user()->id.'/thumbnail/'.auth()->user()->image)}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ucwords(Auth::user()->name)}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          @foreach(\Helper::sideMenu() as $menu)
            @if(auth()->user()->hasAnyPermission($menu->permissions) OR $menu->name == 'My Profile')
              <li class="nav-item @if(count($menu->submenu) > 0) @if(count(array_intersect(Helper::path_url(),$menu->urlselect)) > 0) menu-open @endif @endif">
                <a href="{{$menu->url}}" class="nav-link @if(count(array_intersect(Helper::path_url(),$menu->urlselect)) > 0) active @endif">
                  <i class="nav-icon {{$menu->icon}}"></i>
                  <p>
                    {{$menu->name}}
                    @if(count($menu->submenu) > 0)
                      <i class="right fas fa-angle-left"></i>
                    @endif
                  </p>
                </a>
                @if(count($menu->submenu) > 0)
                <ul class="nav nav-treeview">
                  @foreach($menu->submenu as $submenu)
                  @if(auth()->user()->hasAnyPermission($submenu->permissions))
                    <li class="nav-item">
                      <a href="{{$submenu->url}}" class="nav-link @if(count(array_intersect(Helper::path_url(),$submenu->urlselect)) > 0) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{$submenu->name}}</p>
                      </a>
                    </li>
                  @endif
                  @endforeach
                </ul>
                @endif
              </li>
            @endif
          @endforeach

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>