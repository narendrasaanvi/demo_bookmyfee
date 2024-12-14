@extends('backend.layouts.master')
@section('pageTitle', 'Admin | Add Tournament')
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
                     <span><i class="fas fa-file-alt"></i> Tournament</span>
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
                     <h4 class="card-title mb-0">Add New Tournament</h4>
                  </div>
                  <div class="card-body">
                     <x-toastr-notifications />
					 <form method="POST" class="needs-validation" action="{{ route('tournament.store') }}" enctype="multipart/form-data">
               @csrf
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <div class="form-group">
                        <label for="title">Select Organizer</label>
                         <select  name="organizer" id="organizer" class="form-control @error('organizer') is-invalid @enderror" required>
                         <option value="">Select Organizer</option>
                            @foreach($orgnizers as $orgnizer)
                            <option value="{{$orgnizer->id}}">{{ $orgnizer->name }}</option>
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
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter tournament name" required onchange="generateSlug()">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-12 mb-3">
                     <div class="form-group">
                        <label for="content">Tournament Description</label>
                        <textarea   name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-6  form-group mb-3">
                     <label for="price">Entry Fee</label>
                     <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Enter Amount" required>
                     @error('price')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-6  form-group mb-3">
                     <label for="price">Payment Mode</label>
                     <select name="payment_mode" id="payment_mode" class="form-control " required="">
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                     </select>
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="start_date">Start Date</label>
                     <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                     @error('start_date')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="end_date">End Date</label>
                     <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                     @error('end_date')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 mb-3">
                     <div class="form-group">
                        <label for="title">Tournament Start Time (Optional)</label>
                        <input type="text" name="time" id="time" class="form-control" value="{{ old('time') }}" >
                     </div>
                  </div>                  
                  <div class="col-md-12 form-group mb-3">
                        <label for="category">Category</label>
                        <select name="category[]" id="category" class="form-control @error('category') is-invalid @enderror" required multiple>
                            <option value="">Select Category</option>
                            @foreach($categories as $data)
                            <option value="{{ $data->id }}" {{ in_array($data->id, old('category', [])) ? 'selected' : '' }}>{{ $data->title }}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="category">Prize</label>
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
                     <label for="tournament_type_id">Tournament Type </label>
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
                     <label for="contact_person">Contact Person *</label>
                     <input type="text" name="contact_person" id="contact_person" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person') }}" required>
                     @error('contact_person')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-6 form-group mb-3">
                     <label for="contact_number">Contact Number *</label>
                     <input type="text" name="contact_number" id="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number') }}" required>
                     @error('contact_number')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-6 form-group mb-3">
                     <label for="contact_email">Contact Email *</label>
                     <input type="text" name="contact_email" id="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email') }}" required>
                     @error('contact_email')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>

                  <div class="form-group col-md-12 mb-3">
                     <label for="address">Venue *</label>
                     <textarea   name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                     @error('address')
                     <div class="invalid-feedback">{{ $address }}</div>
                     @enderror
                  </div>

                  <div class="col-md-4 form-group mb-3">
                     <label for="city">City *</label>
                     <input type="text" name="city" id="contact_email" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                     @error('city')
                     <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-4 form-group mb-3">
                     <label for="category">State</label>
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
                        <label for="title">Google Map Link</label>
                        <input type="text" name="google_map_link" id="google_map_link" class="form-control" value="{{ old('google_map_link') }}" >
                     </div>
                  </div>






                <div class="col-md-4 mb-3">
                     <div class="form-group">
                        <label for="title">Facebook Link (Optional)</label>
                        <input type="text" name="facebook" id="facebook" class="form-control" value="{{ old('facebook') }}" >
                     </div>
                  </div>

                <div class="col-md-4 mb-3">
                     <div class="form-group">
                        <label for="title">Instgram Link (Optional)</label>
                        <input type="text" name="instgram" id="instgram" class="form-control" value="{{ old('instgram') }}" >
                     </div>
                  </div>

                  <div class="col-md-4 mb-3">
                     <div class="form-group">
                        <label for="title">Website (Optional)</label>
                        <input type="text" name="website" id="website" class="form-control" value="{{ old('website') }}" >
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

               </div>



                  <div class="text-center mt-3">
                    <div class="d-none">
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
                        <input type="text" name="seo_title" id="seo_title" class="form-control @error('seo_title') is-invalid @enderror" value="{{ old('seo_title') }}" required>
                        <textarea name="seo_description" id="seo_description" class="form-control @error('seo_description') is-invalid @enderror">{{ old('seo_description') }}</textarea>
                   </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
               </div>
            </form>
            </div>
            </div>
            </div>
         </div>
      </div>
   </section>
</div>
<script type="text/javascript">
   $('.all-tournament').addClass('active');
   $('.tournament').addClass('active');
</script>
<script>
   function previewFile() {
       var preview = document.getElementById('profile-image1');
       var file = document.getElementById('profile-image-upload').files[0];
       var reader = new FileReader();

       reader.addEventListener("load", function() {
           preview.src = reader.result;
       }, false);

       if (file) {
           reader.readAsDataURL(file);
       }
   }

   document.addEventListener('DOMContentLoaded', function() {
       document.getElementById('profile-image1').addEventListener('click', function() {
           document.getElementById('profile-image-upload').click();
       });
   });
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
<script>
   $(function() {
       // Summernote
       $('#summernote').summernote({
           height: 300 // Set the height in pixels
       });

       // CodeMirror
       CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
           mode: "htmlmixed",
           theme: "monokai"
       });
   });
</script>
@endsection
