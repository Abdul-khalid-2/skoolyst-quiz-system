@extends('layouts.dashboard')

@section('page_title', 'Account')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="sk-info-box">
            <h6><i class="bi bi-person-circle me-1"></i>Profile</h6>
            <div class="sk-info-row"><span class="sk-info-label">Name</span><span class="sk-info-value">{{ $user['name'] }}</span></div>
            <div class="sk-info-row"><span class="sk-info-label">Email</span><span class="sk-info-value">{{ $user['email'] }}</span></div>
            <div class="sk-info-row"><span class="sk-info-label">Member Since</span><span class="sk-info-value">{{ format_date($user['created_at']) }}</span></div>
        </div>
        <a href="{{ route('dashboard.settings') }}" class="btn btn-sk-outline btn-sm-sk mt-3"><i class="bi bi-shield-lock me-1"></i>Change Password</a>
    </div>
</div>
@endsection
