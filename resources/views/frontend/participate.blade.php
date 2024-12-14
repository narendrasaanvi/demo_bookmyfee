@extends('frontend.layouts.master')
@section('title', 'Welcome')
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
</style>

<section class="header-padding">
    <div class="container py-5">
        <!-- Category Section -->
        <div class="row card p-3 m-2">
            <div class="col-md-12">
                <h3 class="text-center mb-4">Register In</h3>
                <p class="text-center">{{$tournament->title}}</p>
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div style="color: red;font-size: 14px;text-align: center;">{{$error}}</div>
                @endforeach
                @endif

                <form action="{{ route('player.registration.store', ['slug' => $tournament->slug]) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fide_id" class="form-label">FIDE ID*</label>
                            <input type="text" class="form-control @error('fide_id') is-invalid @enderror" id="fide_id" name="fide_id" required>

                            @error('fide_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="aicf_id" class="form-label">AICF ID* (Compulsory for Rating Tmt)</label>
                            <input type="text" class="form-control @error('aicf_id') is-invalid @enderror" id="aicf_id" name="aicf_id" value="{{ old('aicf_id') }}" required>
                            @error('aicf_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fide_rating" class="form-label">FIDE Rating</label>
                            <input type="text" class="form-control" id="fide_rating" name="fide_rating">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="state_membership_id" class="form-label">State Membership ID (Compulsory for State Lvl Tmt)</label>
                            <input type="text" class="form-control" id="state_membership_id" name="state_membership_id">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="player_name" class="form-label">Player Name *</label>
                            <input type="text" class="form-control @error('player_name') is-invalid @enderror" value="{{ Auth::user()->name }}" name="player_name" required>
                            @error('player_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="residential_address" class="form-label">Residential Address</label>
                            <textarea class="form-control" id="residential_address" name="residential_address"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="father_name" class="form-label">Father's/Guardian's Name</label>
                            <input type="text" class="form-control" id="father_name" name="father_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">State *</label>
                            <select class="form-select" id="state" name="state" required>
                                <option value="" disabled selected>Select State</option>
                                <option value="State1">State 1</option>
                                <option value="State2">State 2</option>
                                <!-- Add more states here -->
                            </select>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dob" class="form-label">Date of Birth *</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="district" class="form-label">District *</label>
                            <input type="text" class="form-control" id="district" name="district" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="mobile_1" class="form-label">Mobile No. 1</label>
                            <input type="text" class="form-control" id="mobile_1" name="mobile_1" value="{{ Auth::user()->phone }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="taluk" class="form-label">Taluk</label>
                            <input type="text" class="form-control" id="taluk" name="taluk">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="mobile_2" class="form-label">Mobile No. 2</label>
                            <input type="text" class="form-control" id="mobile_2" name="mobile_2" value="{{ Auth::user()->phone }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pin_code" class="form-label">Pin Code</label>
                            <input type="text" class="form-control" id="pin_code" name="pin_code">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="mail_id" class="form-label">Mail ID</label>
                            <input type="email" class="form-control" id="mail_id" name="email" value="{{ Auth::user()->email }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="school_college_name" class="form-label">School/College Name</label>
                            <input type="text" class="form-control" id="school_college_name" name="school_college_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="online_chess_id" class="form-label">Online Chess ID (Lichess.org/Chess.com)</label>
                            <input type="text" class="form-control" id="online_chess_id" name="online_chess_id">
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="{{ url('privacy-policy') }}" target="_blank">Terms and Conditions</a> *
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    (function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>
@endsection
