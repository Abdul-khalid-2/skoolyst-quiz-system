@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<section class="sk-section text-center" style="padding:5rem 0;">
    <div class="container">
        <i class="bi bi-compass" style="font-size:4rem;color:var(--sk-text-muted);"></i>
        <h1 class="mt-3">404 — Page Not Found</h1>
        <p class="text-secondary-custom mb-4">The page you're looking for doesn't exist or may have been moved.</p>
        <a href="{{ route('home') }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-house me-2"></i>Back to Home</a>
    </div>
</section>
@endsection
