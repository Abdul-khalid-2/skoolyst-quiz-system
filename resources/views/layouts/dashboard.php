<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>@yield('title') — Skoolyst MCQs Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    @yield('extra_css')
</head>
<body style="background-color: var(--sk-bg);">
    <div class="sk-dash-wrapper">
        @include('components.dashboard-sidebar')
        <div class="sk-dash-overlay" id="skDashOverlay"></div>
        <div class="sk-dash-main">
            @include('components.dashboard-topbar')
            <main class="sk-dash-content">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('extra_js')
</body>
</html>