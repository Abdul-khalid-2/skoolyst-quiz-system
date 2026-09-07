@extends('layouts.auth')

@section('title', 'Sign Up')

@section('content')
<h1 class="sk-auth-title">Create your account</h1>
<p class="sk-auth-subtitle">Sign up to start practicing MCQs for free.</p>

@if(isset($errors['_general']))
<div class="alert alert-danger py-2 small">{{ $errors['_general'] }}</div>
@endif

<form method="POST" action="{{ route('register') }}" novalidate>
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="name" class="sk-auth-label">Full name</label>
        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" name="name" value="{{ $old['name'] ?? '' }}" required autofocus>
        @if(isset($errors['name']))
        <div class="invalid-feedback">{{ $errors['name'] }}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="email" class="sk-auth-label">Email address</label>
        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" value="{{ $old['email'] ?? '' }}" required>
        @if(isset($errors['email']))
        <div class="invalid-feedback">{{ $errors['email'] }}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="password" class="sk-auth-label">Password</label>
        <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password" required minlength="8">
        @if(isset($errors['password']))
        <div class="invalid-feedback">{{ $errors['password'] }}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="sk-auth-label">Confirm password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="8">
    </div>

    <button type="submit" class="btn btn-sk-gold w-100 btn-lg mt-2">Create Account</button>
</form>

<p class="sk-auth-footer">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
@endsection
