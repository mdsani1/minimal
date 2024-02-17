<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="color:black; background-color: #fff;box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading" style="color:black;">Core</div>
                <a class="nav-link" href="{{ Route('dashboard') }}" style="color:black;">
                    <div class="sb-nav-link-icon" style="color:black;"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                @if( auth()->user()->role_id == 1)
                <div class="sb-sidenav-menu-heading" style="color:black;">Interface</div>
                <a class="nav-link {{ Request::is('users') || Request::is('roles') || Request::is('navitems') || Request::is('rolenavitems') ? '' : 'collapsed' }}" style="color:black;" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="{{ Request::is('users') || Request::is('roles') || Request::is('navitems') || Request::is('rolenavitems') ? 'true' : 'false' }}" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon" style="color:black;"><i class="fas fa-columns"></i></div>
                    Users Management
                    <div class="sb-sidenav-collapse-arrow" style="color:black;"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ Request::is('users') || Request::is('roles') || Request::is('navitems') || Request::is('rolenavitems/create') ? 'show' : '' }}" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Request::is('roles')? 'active':'' }}" href="{{ route('roles.index') }}" style="color:black;">
                            <div class="sb-nav-link-icon" style="color:black;"><i class="fas fa-user-tag"></i></div>
                            Roles
                        </a>
                        <a class="nav-link {{ Request::is('users')? 'active':'' }}" href="{{ route('users.index') }}" style="color:black;">
                            <div class="sb-nav-link-icon" style="color:black;"><i class="fas fa-users"></i></div>
                            Users
                        </a>
                        <a class="nav-link {{ Request::is('navitems')? 'active':'' }}" href="{{ route('navitems.index') }}" style="color:black;">
                            <div class="sb-nav-link-icon" style="color:black;"><i class="fas fa-keyboard"></i></div>
                            Nav Items
                        </a>
                        <a class="nav-link {{ Request::is('rolenavitems/create')? 'active':'' }}" href="{{ route('rolenavitems.create') }}" style="color:black;">
                            <div class="sb-nav-link-icon" style="color:black;"><i class="fas fa-street-view"></i></div>
                            Role Nav Items
                        </a>
                    </nav>
                </div>
                @endif

                <div class="sb-sidenav-menu-heading" style="color:black;">Addons</div>
                    @if (auth()->user()->role->navItems != null)
                        @foreach (auth()->user()->role->navItems as $item)
                        <a class="nav-link" href="{{ url($item->url) }}" style="color:black;">
                            <div class="sb-nav-link-icon" style="color:black;">{!! $item->icon !!}</div>
                            {{ $item->title }}
                        </a>
                        @endforeach
                    @endif
                </div>
        </div>
        <div class="sb-sidenav-footer" style="background-color: #fff; border-top:1px solid #e8ebe4">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->name ?? '' }}
        </div>
    </nav>
</div>
