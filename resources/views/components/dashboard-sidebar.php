<aside class="sk-dash-sidebar" id="skSidebar">
    <div class="sk-dash-brand"><span class="sk-logo-mark">S</span> Skoolyst<span>MCQs</span></div>
    <div class="sk-dash-section-label">Main</div>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-collection"></i> MCQs</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-journals"></i> Subjects</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-list-ul"></i> Topics</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-diagram-3"></i> Test Types</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-clipboard2-check"></i> Mock Tests</a></li>
    </ul>
    <div class="sk-dash-section-label">Account</div>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-gear"></i> Settings</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="bi bi-box-arrow-right"></i> Back to Site</a></li>
    </ul>
</aside>