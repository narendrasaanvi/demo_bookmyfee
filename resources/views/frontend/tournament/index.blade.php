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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
<section class="header-padding">
   <div class="container py-3">
      <!-- Category Section -->
      <div class="row">
         <div class="col-md-12">
            @include('frontend.tournament.side-menu')
         </div>
         <div class="col-md-12 card">
            <h3 class="text-center my-4">Tournament Details</h3>
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div style="color: red;font-size: 14px;text-align: center;">{{$error}}</div>
            @endforeach
            @endif
            <x-sweet-alert :message="session('success')" type="success" />
            <form action="{{ route('tournament.organizer.store') }}" method="POST" class="needs-validation" novalidate  enctype="multipart/form-data">
               @csrf
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <div class="form-group">
                        <label for="title">Organizer Name <span class="text-danger">*</span></label>
                        <input type="text" name="organizer" id="organizer" class="form-control @error('organizer') is-invalid @enderror" value="{{ old('organizer', Auth::user()->organization_name) }}" placeholder="Enter Organizer name" required>
                        @error('organizer')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-6 mb-3">
                     <div class="form-group">
                        <label for="title">Tournament Name <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter tournament name" required onchange="generateSlug()">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-12 mb-3">
                     <div class="form-group">
                        <label for="content">Tournament Description <span class="text-secondary">(Optional)</span></label>
                        <textarea   name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-6  form-group mb-3">
                     <label for="price">Entry Fee <span class="text-danger">*</span></label>
                     <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Enter Amount" required>
                     @error('price')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-6  form-group mb-3">
                     <label for="price">Payment Mode <span class="text-danger">*</span></label>
                     <select name="payment_mode" id="payment_mode" class="form-control " required>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                     </select>
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="start_date">Start Date <span class="text-danger">*</span></label>
                     <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                     @error('start_date')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="end_date">End Date <span class="text-danger">*</span></label>
                     <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                     @error('end_date')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 mb-3">
                     <div class="form-group">
                        <label for="title">Tournament Start Time <span class="text-secondary">(Optional)</span></label>
                        <input type="text" name="time" id="time" class="form-control" value="{{ old('time') }}">
                        @error('time')
                        <div class="invalid-feedback">{{ $time }}</div>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-12 form-group mb-3">
                     <label for="category">Category <span class="text-danger">*</span></label>
                     <select name="category[]" id="category" class="form-control @error('category') is-invalid @enderror" required multiple data-placeholder="Select Category">
                     @foreach($categories as $data)
                     <option value="{{ $data->id }}" {{ in_array($data->id, old('category', [])) ? 'selected' : '' }}>
                     {{ $data->title }}
                     </option>
                     @endforeach
                     </select>
                     @error('category')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="category">Prize <span class="text-danger">*</span></label>
                     <select name="prize_id" id="prize_id" class="form-control @error('prize_id') is-invalid @enderror" required>
                        <option value="">Select Prize</option>
                        @foreach($prizes as $prize)
                        <option value="{{ $prize->id }}" {{ old('prize_id') == $prize->id ? 'selected' : '' }}>{{ $prize->title }}</option>
                        @endforeach
                     </select>
                     @error('prize_id')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="tournament_type_id">Tournament Type <span class="text-danger">*</span></label>
                     <select name="tournament_type_id" id="tournamenttype" class="form-control @error('tournament_type_id') is-invalid @enderror" required>
                        <option value="">Select Level</option>
                        @foreach($tournamenttypes as $tournamenttype)
                        <option value="{{ $tournamenttype->id }}" {{ old('tournament_type_id') == $tournamenttype->id ? 'selected' : '' }}>{{ $tournamenttype->title }}</option>
                        @endforeach
                     </select>
                     @error('tournament_type_id')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="contact_person">Contact Person <span class="text-danger">*</span></label>
                     <input type="text" name="contact_person" id="contact_person" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person') }}" required>
                     @error('contact_person')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-6 form-group mb-3">
                     <label for="contact_number">Contact Number <span class="text-danger">*</span></label>
                     <input type="text" name="contact_number" id="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number') }}" required>
                     @error('contact_number')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-6 form-group mb-3">
                     <label for="contact_email">Contact Email <span class="text-danger">*</span></label>
                     <input type="text" name="contact_email" id="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email') }}" required>
                     @error('contact_email')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="form-group col-md-12 mb-3">
                     <label for="address">Venue  <span class="text-danger">*</span></label>
                     <textarea   name="address" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                     @error('address')
                     <div class="invalid-feedback">{{ $address }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="city">City <span class="text-danger">*</span></label>
                     <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                     @error('city')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="category">State <span class="text-danger">*</span></label>
                     <select name="state_id" id="state_id" class="form-control @error('state_id') is-invalid @enderror" required>
                        <option value="">Select State</option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ old('category') == $state->id ? 'selected' : '' }}>{{ $state->title }}</option>
                        @endforeach
                     </select>
                     @error('state_id')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 mb-3">
                     <div class="form-group">
                        <label for="title">Google Map Link <span class="text-danger">*</span></label>
                        <input type="text" name="google_map_link" id="google_map_link" class="form-control" value="{{ old('google_map_link') }}" required>
                     </div>
                  </div>
                  <div class="col-md-4 mb-3">
                     <div class="form-group">
                        <label for="title">Facebook Link <span class="text-secondary">(Optional)</span></label>
                        <input type="text" name="facebook" id="facebook" class="form-control" value="{{ old('facebook') }}" >
                     </div>
                  </div>
                  <div class="col-md-4 mb-3">
                     <div class="form-group">
                        <label for="title">Instgram Link <span class="text-secondary">(Optional)</span></label>
                        <input type="text" name="instgram" id="instgram" class="form-control" value="{{ old('instgram') }}" >
                     </div>
                  </div>
                  <div class="col-md-4 mb-3">
                     <div class="form-group">
                        <label for="title">Website <span class="text-secondary">(Optional)</span></label>
                        <input type="text" name="website" id="website" class="form-control" value="{{ old('website') }}" >
                     </div>
                  </div>
                  <div class="col-md-6 form-group mb-6">
                     <label for="image">Tournament Banner <span class="text-danger">*</span></label>
                     <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}">
                     @error('image')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-6 form-group mb-6">
                     <label for="document">Tournament Brochure <span class="text-danger">*</span></label>
                     <input type="file" name="document" id="document" class="form-control @error('document') is-invalid @enderror" value="{{ old('document') }}" required>
                     @error('document')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
               </div>
               <div class="col-md-12 mb-3 mt-3">
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
               <div class="text-center mt-3">
                  <div class="d-none">
                     <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
                     <input type="text" name="seo_title" id="seo_title" class="form-control @error('seo_title') is-invalid @enderror" value="{{ old('seo_title') }}" required>
                     <textarea name="seo_description" id="seo_description" class="form-control @error('seo_description') is-invalid @enderror">{{ old('seo_description') }}</textarea>
                  </div>
                  <button type="submit" class="btn btn-primary mb-3">Submit</button>
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
<script>
   function generateSlug() {
       const title = document.getElementById('title').value;
       const productSlug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
       document.getElementById('slug').value = productSlug;
       document.getElementById('seo_description').value = productSlug;
       document.getElementById('seo_title').value = productSlug;
   }
</script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
<script>
   $(document).ready(function() {
       $('#category').select2({
           placeholder: "Select Category",
           allowClear: true
       });
   });
</script>
@endsection
