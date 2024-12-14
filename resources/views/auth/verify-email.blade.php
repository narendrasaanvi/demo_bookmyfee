@extends('frontend.layouts.master')
@section('title', 'E-Shop || Login Page')
@section('main-content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .header-padding {
        margin-top: 100px;
        background: #f5f5f5;
        min-height: 50vh; /* Ensure full-screen height for centering */
        display: flex;
        align-items: center;
    }
    .left-side-bar {
        background: #ffffff;
        padding: 10px;
    }
    .bg-login-image {
        background: url(assets/images/welcome.jpg);
        background-size: cover;
    }
</style>
<section class="header-padding">
<div class="container d-flex flex-column justify-content-center align-items-center text-center">
    <h1>Verify Your Email</h1>
    <p>Please check your email for a verification link.</p>

    @if (session('status') == 'verification-link-sent')
        <p class="text-success">A new verification link has been sent to your email.</p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>
</div>
</section>
@endsection
