@extends('frontend.layouts.master')
@section('title', 'E-Shop || Login Page')
@section('main-content')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Warriors</h1>
                  </div>
                  <form class="user" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mt-3">
                      <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Email Address..." required autocomplete="email" autofocus>
                      @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="form-group mt-3 position-relative">
                          <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" 
                                id="passwordField" placeholder="Password" name="password" required autocomplete="current-password">
                          <span class="toggle-password bi bi-eye-slash position-absolute" 
                                style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"></span>
                          @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div>

                    <div class="form-group mt-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                      </div>
                    </div>
                    <div class="text-start">
                    <a class="btn btn-link small text-decoration-none" href="{{ route('register') }}">
                        Don't have an account? <strong>Create one here</strong>
                    </a>
                   </div>                    
                    <button type="submit" class="btn btn-primary btn-user btn-block mt-3 w-100">
                      Login
                    </button>
                  </form>
                  <hr>

                  <div class="text-center">
                    <p><a href="#" data-bs-toggle="modal" data-bs-target="#otpModal">Login With OTP</a></p>
                  </div>

                  <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link small" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    @endif
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

<!-- OTP Modal -->
<!-- OTP Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otpModalLabel">Login With OTP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="alertMessage" class="alert d-none" role="alert"></div> <!-- Message Section -->
                <form id="otpForm">
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" name="phone" id="phoneNumber" placeholder="Enter your mobile number">
                    </div>
                    <button type="button" id="sendOtpBtn" class="btn btn-primary">Send OTP</button>

                    <div id="otpSection" class="mt-3 d-none">
                        <div class="mb-3">
                            <label for="otp" class="form-label">OTP</label>
                            <input type="number" class="form-control" id="otp" placeholder="Enter the OTP">
                        </div>
                        <button type="button" id="verifyOtpBtn" class="btn btn-success">Verify OTP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const sendOtpBtn = document.getElementById("sendOtpBtn");
const phoneNumberField = document.getElementById("phoneNumber");
const otpSection = document.getElementById("otpSection");
const verifyOtpBtn = document.getElementById("verifyOtpBtn");
const otpField = document.getElementById("otp");
const alertMessage = document.getElementById("alertMessage"); // Reference to the alert message div

// Function to show alert messages in modal
function showAlertMessage(message, type = 'warning') {
    alertMessage.textContent = message; // Set the message
    alertMessage.classList.remove("d-none", "alert-success", "alert-danger", "alert-warning"); // Remove all previous classes
    alertMessage.classList.add(`alert-${type}`); // Add the class for the type of alert (success, danger, warning)
}

// Send OTP Button Click
sendOtpBtn.addEventListener("click", function () {
    const phoneNumber = phoneNumberField.value.trim();

    // Validate Phone Number
    if (!/^\d{10}$/.test(phoneNumber)) {
        showAlertMessage("Please enter a valid 10-digit mobile number.", 'danger');
        return;
    }

    sendOtpBtn.setAttribute("disabled", "true");

    // Send OTP Request
    fetch('/send-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ phone: phoneNumber })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            showAlertMessage(data.message, 'success'); // Show success message in modal
            phoneNumberField.setAttribute("disabled", "true");
            otpSection.classList.remove("d-none"); // Show OTP input section
        }
    })
    .catch(error => {
        console.error("Error sending OTP:", error);
        showAlertMessage("Failed to send OTP. Please try again.", 'danger');
        sendOtpBtn.removeAttribute("disabled");
    });
});

// Verify OTP Button Click
verifyOtpBtn.addEventListener("click", function () {
    const phoneNumber = phoneNumberField.value.trim();
    const otp = otpField.value.trim();

    // Validate OTP input
    if (!otp || otp.length !== 4) {
        showAlertMessage("Please enter a valid 4-digit OTP.", 'danger');
        return;
    }

    // Verify OTP Request
    fetch('/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ phone: phoneNumber, otp: otp })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            showAlertMessage(data.message, 'success'); // Show success message in modal
            window.location.href = "/"; // Redirect to home/dashboard
        } else if (data.error) {
            showAlertMessage(data.error, 'danger'); // Show error message in modal
        }
    })
    .catch(error => {
        console.error("Error verifying OTP:", error);
        showAlertMessage("Failed to verify OTP. Please try again.", 'danger');
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.querySelector(".toggle-password");
    const passwordField = document.getElementById("passwordField");

    togglePassword.addEventListener("click", function () {
        // Toggle password visibility
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;

        // Toggle the icon class
        this.classList.toggle("bi-eye");
        this.classList.toggle("bi-eye-slash");
    });
});
</script>

@endsection
