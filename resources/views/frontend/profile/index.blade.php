@extends('frontend.layouts.master')
@section('title', 'Profile')
@section('main-content')
<style>
    .header-padding {
        margin-top: 100px;
        background: #f5f5f5;
    }
    .tab-content {
        width: 100%;
    }
    .profile-side-bar {
        background: #fff;
        padding: 10px;
        height: auto;
    }
    a#v-pills-update-profile-tab {
        border-bottom: solid 1px #0d6efd;
        border-radius: 0px;
    }
    a#v-pills-change-password-tab {
    border-bottom: solid 1px #0d6efd;
    border-radius: 0px;
    }
</style>

<section class="header-padding">
  <div class="container py-5">
    <div class="row">
    @if (session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
      <div class="col-lg-4">
        <!-- Vertical Tabs Navigation -->
        <div class="nav flex-column nav-pills me-3 profile-side-bar" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="nav-link active" id="v-pills-overview-tab" data-bs-toggle="pill" href="#v-pills-overview" role="tab" aria-controls="v-pills-overview" aria-selected="true">
            Overview
          </a>
          <a class="nav-link" id="v-pills-update-profile-tab" data-bs-toggle="pill" href="#v-pills-update-profile" role="tab" aria-controls="v-pills-update-profile" aria-selected="false">
            Update Profile
          </a>
          <a class="nav-link" id="v-pills-change-password-tab" data-bs-toggle="pill" href="#v-pills-change-password" role="tab" aria-controls="v-pills-change-password" aria-selected="false">
            Change Password
          </a>
          <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>          
        </div>
      </div>

      <div class="col-lg-8">
        <!-- Tabs Content -->
        <div class="tab-content" id="v-pills-tabContent">
          <!-- Overview Tab -->
          <div class="tab-pane fade show active" id="v-pills-overview" role="tabpanel" aria-labelledby="v-pills-overview-tab">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Full Name</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ Auth::user()->name }}</p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Email</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Phone</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ Auth::user()->phone }}</p>
                  </div>
                </div>
                @if(auth()->check() && auth()->user()->organizer === 'yes')
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Alternate Number</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ Auth::user()->alternate_number }}</p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Organization Name</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ Auth::user()->organization_name }}</p>
                  </div>
                </div>
                @endif
              </div>
            </div>
          </div>

          <!-- Update Profile Tab -->
          <div class="tab-pane fade" id="v-pills-update-profile" role="tabpanel" aria-labelledby="v-pills-update-profile-tab">
            <div class="card">
              <div class="card-body">
                <!-- Display Success/Error Messages -->

                <!-- Profile Update Form -->
                <form action="{{ route('user.profile.update') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" maxlength="50" name="name" value="{{ Auth::user()->name }}">
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" maxlength="15" name="email" value="{{ Auth::user()->email }}">
                  </div>
                  <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" class="form-control" id="phone" maxlength="12" name="phone" value="{{ Auth::user()->phone }}">
                  </div>
                  @if(auth()->check() && auth()->user()->organizer === 'yes')
                  <div class="mb-3">
                    <label for="phone" class="form-label">Alternate Number</label>
                    <input type="number" class="form-control" id="alternate_number" maxlength="12" name="alternate_number" value="{{ Auth::user()->alternate_number }}">
                  </div>
                  <div class="mb-3">
                    <label for="phone" class="form-label">Organization Name</label>
                    <input type="text" class="form-control" id="organization_name" maxlength="50" name="organization_name" value="{{ Auth::user()->organization_name }}">
                  </div>
                  @endif
                  <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
              </div>
            </div>
          </div>

          <!-- Change Password Tab -->
          <div class="tab-pane fade" id="v-pills-change-password" role="tabpanel" aria-labelledby="v-pills-change-password-tab">
            <div class="card">
              <div class="card-body">
                <!-- Password Change Form -->
                <form action="{{ route('user.profile.change-password') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password">
                  </div>
                  <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password">
                  </div>
                  <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                  </div>
                  <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
