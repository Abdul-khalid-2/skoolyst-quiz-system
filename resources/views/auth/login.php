@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<h1 class="sk-auth-title">Welcome back</h1>
<p class="sk-auth-subtitle">Log in to continue practicing MCQs.</p>

@if(isset($errors['_general']))
<div class="alert alert-danger py-2 small">{{ $errors['_general'] }}</div>
@endif

<form method="POST" action="{{ route('login') }}" novalidate>
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="email" class="sk-auth-label">Email address</label>
        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" value="{{ $old['email'] ?? '' }}" required autofocus>
        @if(isset($errors['email']))
        <div class="invalid-feedback">{{ $errors['email'] }}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="password" class="sk-auth-label">Password</label>
        <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password" required>
        @if(isset($errors['password']))
        <div class="invalid-feedback">{{ $errors['password'] }}</div>
        @endif
    </div>

    <button type="submit" class="btn btn-sk-gold w-100 btn-lg mt-2">Log In</button>
</form>

<div class="sk-auth-divider my-3 text-center text-secondary-custom small">or</div>

<a href="{{ route('auth.skoolyst') }}" class="btn btn-sk-outline w-100 btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Login with Skoolyst</a>

<p class="sk-auth-footer">Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
@endsection
