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
    .list-group-item.active {
    z-index: 2;
    color: var(--bs-list-group-active-color);
    background-color: #7f6cfd;
    border-color: #7f6cfd;
}
</style>

<section class="header-padding">
    <div class="container py-3">
        <!-- Category Section -->
        <div class="row">
            <div class="col-md-12">
              @include('frontend.players.side-menu')
            </div>

            <div class="col-md-12">
            <div class="card p-2">
                <h3 class="text-center mb-4">UPDATE {{ $player->player_name }} DATA</h3>
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div style="color: red;font-size: 14px;text-align: center;">{{$error}}</div>
                @endforeach
                @endif
                <x-sweet-alert :message="session('success')" type="success" />
                <form action="{{ route('player.registration.update',$player->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                    <div class="col-md-4 mb-3">
                            <label for="player_name" class="form-label">Player Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('player_name') is-invalid @enderror" value="{{ old('player_name',$player->player_name) }}"  name="player_name" required>
                            @error('player_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="dob"  name="dob" required value="{{ old('dob', $player->dob ? $player->dob->format('Y-m-d') : '') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="male" @if(old('gender', $player->gender) == 'male') selected @endif>Male</option>
                                <option value="female" @if(old('gender', $player->gender) == 'female') selected @endif>Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="school_college_name" class="form-label">School (or) College (or) Work Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="school_college_name" name="school_college_name" value="{{ old('school_college_name',$player->school_college_name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fide_rating" class="form-label">FIDE Rating <span class="text-secondary">(if any)</span></label>
                            <input type="text" class="form-control" id="fide_rating" name="fide_rating" value="{{ old('fide_rating',$player->fide_rating) }}" >
                        </div>





                        <div class="col-md-4 mb-3">
                            <label for="fide_id" class="form-label">FIDE ID <span class="text-secondary">(required for Rating Event)</span></label>
                            <input type="text" class="form-control @error('fide_id') is-invalid @enderror" id="fide_id" name="fide_id" value="{{$player->fide_id}}">

                            @error('fide_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="aicf_id" class="form-label">AICF ID <span class="text-secondary">(required for Rating Event)</label>
                            <input type="text" class="form-control @error('aicf_id') is-invalid @enderror" id="aicf_id" name="aicf_id" value="{{ old('aicf_id',$player->aicf_id) }}">
                            @error('aicf_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="state_membership_id" class="form-label">State Membership ID <span class="text-secondary">(required for State Event)</span></label>
                            <input type="text" class="form-control" id="state_membership_id" name="state_membership_id" value="{{ old('state_membership_id',$player->state_membership_id) }}" >
                        </div>



                        <div class="col-md-4 mb-3">
                            <label for="mobile_1" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mobile_1" name="mobile_1" value="{{ old('mobile_1',$player->mobile_1) }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="mobile_2" class="form-label">Alternate Mobile Number. <span class="text-secondary">(Optional)</span></label>
                            <input type="text" class="form-control" id="mobile_2" name="mobile_2" value="{{ old('mobile_2',$player->mobile_2) }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Mail ID <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email',$player->email) }}" >
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="father_name" class="form-label">Father (or) Mother (or) Guardian’s Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="father_name" name="father_name" value="{{ old('father_name',$player->father_name) }}"required >
                        </div>


                        <div class="col-md-12 mb-3">
                            <label for="residential_address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="residential_address" name="residential_address" required>{{ old('residential_address',$player->residential_address) }}</textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="pin_code" class="form-label">Pin Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pin_code" name="pin_code" value="{{ old('pin_code',$player->pin_code) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                            <select class="form-select @error('state') is-invalid @enderror" id="state" name="state" required>
                                <option value="" disabled selected>Select State</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->title }}"
                                        @if(old('state', $player->state) == $state->title) selected @endif>
                                        {{ $state->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="district" name="district" required value="{{ old('mobile_1',$player->district) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="online_chess_id" class="form-label">Lichess ID <span class="text-secondary">(Optional)</span></label>
                            <input type="text" class="form-control" id="online_chess_id" name="online_chess_id" value="{{ old('online_chess_id',$player->online_chess_id) }}" >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="chess_id" class="form-label">Chess.com ID <span class="text-secondary">(Optional)</span></label>
                            <input type="text" class="form-control" id="chess_id" name="chess_id" value="{{ old('chess_id') }}">
                        </div>


                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" id="terms" name="terms" checked required>
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
                        <button type="submit" class="btn btn-primary">Update Player Data</button>
                    </div>
                </form>
                </div>
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
