@extends('layouts.dashboard')

@section('page_title', 'Account')

@section('content')
<div class="row g-4">
    <div class="col-lg-6">
        <div class="sk-info-box">
            <h6><i class="bi bi-person-circle me-1"></i>Profile</h6>
            <div class="sk-info-row"><span class="sk-info-label">Name</span><span class="sk-info-value">{{ $user['name'] }}</span></div>
            <div class="sk-info-row"><span class="sk-info-label">Email</span><span class="sk-info-value">{{ $user['email'] }}</span></div>
            <div class="sk-info-row"><span class="sk-info-label">Member Since</span><span class="sk-info-value">{{ format_date($user['created_at']) }}</span></div>
        </div>
    </div>

    <div class="col-lg-6">
        @if(isset($errors['_general']))
        <div class="alert alert-danger py-2 small">{{ $errors['_general'] }}</div>
        @endif
        @if(isset($success))
        <div class="alert alert-success py-2 small">{{ $success }}</div>
        @endif

        <div class="sk-info-box">
            <h6><i class="bi bi-shield-lock me-1"></i>Change Password</h6>
            <form method="POST" action="{{ route('dashboard.account') }}" novalidate>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="current_password" class="sk-auth-label">Current password</label>
                    <input type="password" class="form-control <?= isset($errors['current_password']) ? 'is-invalid' : '' ?>" id="current_password" name="current_password" required>
                    @if(isset($errors['current_password']))
                    <div class="invalid-feedback">{{ $errors['current_password'] }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password" class="sk-auth-label">New password</label>
                    <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password" required minlength="8">
                    @if(isset($errors['password']))
                    <div class="invalid-feedback">{{ $errors['password'] }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="sk-auth-label">Confirm new password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="8">
                </div>

                <button type="submit" class="btn btn-sk-gold">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
