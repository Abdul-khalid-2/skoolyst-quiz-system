<nav class="navbar navbar-expand-lg sk-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="sk-logo-mark">S</span>
            <span class="sk-logo-text">Skoolyst<span>MCQs</span></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#skNav" aria-controls="skNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="skNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">MCQs</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}" href="{{ route('subjects.index') }}">Subjects</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('test-types.*') ? 'active' : '' }}" href="{{ route('test-types.index') }}">Test Types</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('mock-tests.*') ? 'active' : '' }}" href="{{ route('mock-tests.index') }}">Mock Tests</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <input type="text" class="sk-search-box d-none d-lg-inline-block" placeholder="Search MCQs..." />
                @if(is_authenticated())
                <span class="text-secondary-custom small d-none d-lg-inline">Hi, {{ auth_user()['name'] }}</span>
                <a href="{{ route('logout') }}" class="btn btn-sk-outline btn-sm-sk">Logout</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-sk-outline btn-sm-sk">Login</a>
                <a href="{{ route('register') }}" class="btn btn-sk-navy btn-sm-sk">Register</a>
                @endif
            </div>
        </div>
    </div>
</nav>