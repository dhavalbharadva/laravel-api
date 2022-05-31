<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{!! URL::to(ADMIN_SLUG.'/dashboard') !!}">
                    <!--<div class="brand-logo"></div>-->
                    <h2 class="brand-text mb-0">Admin Portal</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item {!! (Request::is(ADMIN_SLUG.'/dashboard') ? 'active' : '') !!}">
                <a href="{!!URL::to(ADMIN_SLUG)!!}"><i class="feather icon-home"></i><span class="menu-title">Dashboard</span></a>
            </li>
            <li class=" nav-item {!! (Request::is(ADMIN_SLUG.'/settings*') || Request::is(ADMIN_SLUG.'/password/change') ? ' sidebar-group-active open' : '') !!}">
                <a href="javascript:;"><i class="feather icon-settings"></i><span class="menu-title">Settings</span></a>
                <ul class="menu-content">
                    <li class="{!! (Request::is(ADMIN_SLUG.'/password/change') ? 'active' : '') !!}">
                        <a href="{!!URL::to(ADMIN_SLUG.'/password/change')!!}"><i class="feather icon-circle"></i><span class="menu-item">Change Password</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item {!! (Request::is(ADMIN_SLUG.'/users*')  ? ' sidebar-group-active open' : '') !!}">
                <a href="javascript:;"><i class="feather icon-user-x"></i><span class="menu-title">User Management</span></a>
                <ul class="menu-content">
                    <li class="{!! (Request::is(ADMIN_SLUG.'/users/create') ? 'active' : '') !!}">
                        <a href="{!!URL::to(ADMIN_SLUG.'/users/create')!!}"><i class="feather icon-circle"></i><span class="menu-item">Add User</span></a>
                    </li>
                    <li class="{!! (Request::is(ADMIN_SLUG.'/users') ? 'active' : '') !!}">
                        <a href="{!!URL::to(ADMIN_SLUG.'/users')!!}"><i class="feather icon-circle"></i><span class="menu-item">Users List</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>