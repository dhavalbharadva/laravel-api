
<header class="header">
    
    <div class="site-header-main">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="{!! asset('assets/images/logo.png') !!}" width="200" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarsExample07">
                    <ul class="navbar-nav ml-auto">
                        @if (Auth::guard('user')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Logout</a>
                        </li>
                        @else
                        <li class="nav-item  {!! (Request::is('login') ? 'active' : '') !!}"> <a href="{!! URL::route('frontend.login') !!}" data-target="#login" class="nav-link login-link">Login</a></li>
                        <li class="nav-item  {!! (Request::is('register') ? 'active' : '') !!}"> <a href="{!! URL::route('frontend.users.create') !!}" data-target="#register" class="nav-link last register-link">Registser</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>