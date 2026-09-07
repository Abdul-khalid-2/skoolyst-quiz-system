<header class="sk-dash-topbar">
    <div class="d-flex align-items-center gap-2">
        <button class="sk-dash-toggle d-lg-none" type="button"><i class="bi bi-list"></i></button>
        <h1>@yield('page_title', 'Dashboard')</h1>
    </div>
    <div class="d-flex align-items-center gap-2">
        <input type="text" class="sk-dash-search d-none d-md-inline-block" placeholder="Search..." />
        <button class="sk-dash-icon-btn" type="button"><i class="bi bi-bell"></i><span class="sk-dot"></span></button>
        <div class="dropdown">
            <button class="sk-dash-icon-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('home') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</header>