@extends('frontend.layouts.master')
@section('title','E-Shop || Login Page')
@section('main-content')
<style>
    .header-padding {
        margin-top: 100px;
        background: #f5f5f5;
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

<section class="header-padding">
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">New Register</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="exampleInputName" aria-describedby="namelHelp" placeholder="Enter Name" required autocomplete="name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-3">
                                        <input type="number" class="form-control form-control-user @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" id="phone" aria-describedby="namelHelp" placeholder="Enter Mobile No" required autocomplete="name" autofocus>
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-3">
                                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-3 position-relative">
                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" 
                                            id="passwordField" placeholder="Password" name="password" required autocomplete="current-password">
                                        <span toggle="#passwordField" class="toggle-password bi bi-eye-slash position-absolute" 
                                            style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"></span>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-3 position-relative">
                                        <input type="password" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror" 
                                            id="confirmPasswordField" placeholder="Confirm Password" name="password_confirmation" required autocomplete="current-password">
                                        <span toggle="#confirmPasswordField" class="toggle-password bi bi-eye-slash position-absolute" 
                                            style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"></span>
                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <!-- Register as Player or Organizer -->
                                    <div class="form-group mt-3">
                                        <label for="organizer">Register as:</label><br>
                                        <input type="radio" id="player" name="organizer" value="no" {{ old('organizer') === 'no' ? 'checked' : '' }}>
                                        <label for="player">Player</label>
                                        <input type="radio" id="organizer" name="organizer" value="yes" {{ old('organizer') === 'yes' ? 'checked' : '' }}>
                                        <label for="organizer">Organizer</label>
                                        @error('organizer')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block mt-3 w-100">
                                    Register
                                    </button>
                                </form>

                                <hr>

                                <div class="text-center">

                                    <a class="btn btn-link small" href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.querySelectorAll('.toggle-password');
    
    togglePassword.forEach(icon => {
        icon.addEventListener('click', function () {
            const input = document.querySelector(this.getAttribute('toggle'));
            const iconClass = this.classList;

            if (input.getAttribute('type') === 'password') {
                input.setAttribute('type', 'text');
                iconClass.remove('bi-eye-slash');
                iconClass.add('bi-eye');
            } else {
                input.setAttribute('type', 'password');
                iconClass.remove('bi-eye');
                iconClass.add('bi-eye-slash');
            }
        });
    });
});

</script>    
@endsection
