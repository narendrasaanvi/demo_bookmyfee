@extends('backend.layouts.master')
@section('pageTitle', 'Admin | Edit Tournament')
@section('main-content')
<div class="content-wrapper">
   <!-- Content Header -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <ol class="breadcrumb my-0 ms-2">
                  <li class="breadcrumb-item"><a href="{{ URL::asset('admin/dashboard') }}"><i class="fas fa-cubes"></i> Dashboard</a></li>
                  <li class="breadcrumb-item active">
                     <span><i class="fas fa-file-alt"></i> Edit Tournament</span>
                  </li>
               </ol>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">
                     <div id="clock"></div>
                  </li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <!-- Main Content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <h4 class="card-title mb-0">Edit Tournament</h4>
                  </div>
                  <div class="card-body">
                  @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div style="color: red;font-size: 14px;text-align: center;">{{$error}}</div>
                    @endforeach
                    @endif
                     <x-toastr-notifications />
                     <form method="POST" action="{{ route('tournament.update', $tournament->id) }}"
                        class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="organizer">Organizer Name</label>
                                    <select name="organizer" id="organizer" class="form-control @error('organizer') is-invalid @enderror" readyonly>
                                        <option value="">Select Organizer</option>
                                        @foreach($orgnizers as $orgnizer)
                                            <option value="{{ $orgnizer->id }}" {{ $tournament->user_id == $orgnizer->id ? 'selected' : '' }}>
                                                {{ $orgnizer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('organizer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                           <div class="col-md-6 mb-3">
                              <div class="form-group">
                                 <label for="title">Tournament Name</label>
                                 <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $tournament->title) }}" placeholder="Enter tournament name" required onchange="generateSlug()">
                                 @error('title')
                                 <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                              </div>
                           </div>
                           <div class="col-md-12 mb-3">
                              <div class="form-group">
                                 <label for="content">Tournament Description</label>
                                 <textarea name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content', $tournament->content) }}</textarea>
                                 @error('content')
                                 <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                              </div>
                           </div>
                           <div class="col-md-6 form-group mb-3">
                              <label for="price">Entry Fee</label>
                              <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $tournament->price) }}" placeholder="Enter fees" required>
                              @error('price')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-6 form-group mb-3">
                              <label for="payment_mode">Payment Mode</label>
                              <select name="payment_mode" id="payment_mode" class="form-control" required>
                              <option value="Online" {{ old('payment_mode', $tournament->payment_mode) == 'Online' ? 'selected' : '' }}>Online</option>
                              <option value="Offline" {{ old('payment_mode', $tournament->payment_mode) == 'Offline' ? 'selected' : '' }}>Offline</option>
                              </select>
                           </div>
                           <div class="col-md-4 form-group mb-3">
                              <label for="start_date">Start Date</label>
                              <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $tournament->start_date) }}" required>
                              @error('start_date')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-4 form-group mb-3">
                              <label for="end_date">End Date</label>
                              <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $tournament->end_date) }}" required>
                              @error('end_date')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-4 form-group mb-3">
                              <label for="time">Tournament Time</label>
                              <input type="text" name="time" id="time" class="form-control @error('time') is-invalid @enderror" value="{{ old('time', $tournament->time) }}" required>
                              @error('time')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                          <div class="col-md-12 form-group mb-3">
                            <label for="category">Category</label>
                            <select name="category[]" id="category" class="form-control @error('category') is-invalid @enderror" required multiple>
                                <option value="">Select Category</option>
                                @foreach($categories as $data)
                                <option value="{{ $data->id }}" {{ in_array($data->id, old('category', explode(',', $tournament->category_id))) ? 'selected' : '' }}>{{ $data->title }}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                           <div class="col-md-4 form-group mb-3">
                              <label for="prize_id">Prize</label>
                              <select name="prize_id" id="prize_id" class="form-control @error('prize_id') is-invalid @enderror" required>
                                 <option value="">Select Prize</option>
                                 @foreach($prizes as $prize)
                                 <option value="{{ $prize->id }}" {{ old('prize_id', $tournament->prize_id) == $prize->id ? 'selected' : '' }}>{{ $prize->title }}</option>
                                 @endforeach
                              </select>
                              @error('prize_id')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-4 form-group mb-3">
                              <label for="tournament_type_id">Tournament Type</label>
                              <select name="tournament_type_id" id="tournamenttype" class="form-control @error('tournament_type_id') is-invalid @enderror" required>
                                 <option value="">Select Level</option>
                                 @foreach($tournamenttypes as $tournamenttype)
                                 <option value="{{ $tournamenttype->id }}" {{ old('tournament_type_id', $tournament->tournament_type_id) == $tournamenttype->id ? 'selected' : '' }}>{{ $tournamenttype->title }}</option>
                                 @endforeach
                              </select>
                              @error('tournament_type_id')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-4 form-group mb-3">
                              <label for="contact_person">Contact Person</label>
                              <input type="text" name="contact_person" id="contact_person" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person', $tournament->contact_person) }}" required>
                              @error('contact_person')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-6 form-group mb-3">
                              <label for="contact_number">Contact Number</label>
                              <input type="text" name="contact_number" id="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number', $tournament->contact_number) }}" required>
                              @error('contact_number')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-6 form-group mb-3">
                              <label for="contact_email">Contact Email</label>
                              <input type="text" name="contact_email" id="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $tournament->contact_email) }}" required>
                              @error('contact_email')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="form-group col-md-12 mb-3">
                              <label for="address">Venue </label>
                              <textarea   name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address' , $tournament->address) }}</textarea>
                              @error('address')
                              <div class="invalid-feedback">{{ $address }}</div>
                              @enderror
                           </div>
                           <div class="col-md-6 mb-3">
                              <div class="form-group">
                                 <label for="title">City</label>
                                 <input type="city" name="city" id="city" class="form-control" value="{{ old('city' , $tournament->city) }}" >
                              </div>
                           </div>
                           <div class="col-md-6 mb-3">
                              <div class="form-group">
                                 <label for="title">Google Map Link</label>
                                 <input type="text" name="google_map_link" id="google_map_link" class="form-control" value="{{ old('google_map_link' , $tournament->google_map_link) }}" >
                              </div>
                           </div>


                           <div class="col-md-4 mb-3">
                              <div class="form-group">
                                 <label for="title">Facebook Link</label>
                                 <input type="text" name="facebook" id="facebook" class="form-control" value="{{ old('facebook', $tournament->facebook) }}" >
                              </div>
                           </div>
                           <div class="col-md-4 mb-3">
                              <div class="form-group">
                                 <label for="title">Instgram Link</label>
                                 <input type="text" name="instgram" id="instgram" class="form-control" value="{{ old('instgram', $tournament->instgram) }}" >
                              </div>
                           </div>
                           <div class="col-md-4 mb-3">
                              <div class="form-group">
                                 <label for="title">website</label>
                                 <input type="text" name="website" id="website" class="form-control" value="{{ old('website', $tournament->website) }}" >
                              </div>
                           </div>
                           <div class="col-md-6 form-group mb-6">
                              <label for="document">Image</label>
                              <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}" required>
                              @error('image')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-6 form-group mb-6">
                              <label for="document">Doument</label>
                              <input type="file" name="document" id="document" class="form-control @error('document') is-invalid @enderror" value="{{ old('document') }}" required>
                              @error('document')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-12 form-group mb-6">
                            <hr>
                            <h4 class="text-success">Admin Work</h4>
                           </div>
                           <div class="col-md-4 form-group mb-3">
                                <label for="status">Tournament Approve</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="1" {{ $tournament->status == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $tournament->status == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                           <div class="col-md-4 form-group mb-3">
                              <label for="order_number">Tournament Order</label>
                              <input type="text" name="order_number" id="order_number" class="form-control @error('order_number') is-invalid @enderror" value="{{ old('order_number', $tournament->order_number) }}" required>
                              @error('document')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-4 form-group mb-3">
                              <label for="text">Tournament Admin Commission</label>
                              <input type="text" name="admin_commission" id="admin_commission" class="form-control @error('admin_commission') is-invalid @enderror" value="{{ old('admin_commission', $tournament->admin_commission) }}" required>
                              @error('document')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>

                        </div>
                        <div class="text-end">
                           <button type="submit" class="btn btn-primary">Update Tournament</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
@endsection
