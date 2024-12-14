@extends('backend.layouts.master')
@section('pageTitle', 'Admin | brands')
@section('main-content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">

    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">

            <div class="card-header">Update</div>
            <div class="card-body">
              @if (session('status'))
              <script type="text/javascript">
                toastr.success('{{ session("status") }}')
              </script>
              @elseif(session('failed'))
              <script type="text/javascript">
                toastr.warning('{{ session("praksh") }}')
              </script>
              @endif

              <form method="POST" action="{{ route('category.update', $category->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
              @csrf
              @method('PUT')
                <div class="form-group">
                  <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" id="title" class=" form-control col-sm-12" value="{{ $category->title }}" required />
                  </div>
                </div>
                <div class="form-group">
                  <label>Details:</label>
                  <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3">{{ $category->content }}</textarea>
                </div>
                <div class="form-group">
                           <label>Parent Category:</label>
                           <select name="parent" id="parent" class="form-control @error('parent') is-invalid @enderror">
                              <option value="">None</option>
                              @foreach($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->title }}</option>
                              @endforeach
                           </select>
                           @error('title')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        <div class="form-group">
                           <label>Image:</label> 
                           <div class="profile-pic">
                              <img alt="User Pic" src="{{ URL::asset('uploads/category/'.$category->image) }}" id="profile-image1" height="200">
                              <input id="profile-image-upload" value="" class="hidden {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" onchange="previewFile()" style="display: none;" name="image">
                              <div style="color:#999;"></div>
                           </div>
                           @error('image')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        <div class="form-group">
                           <label>Slug:</label>
                           <input type="text" name="slug" id="slug" value="{{$category->slug}}" class="form-control col-sm-12 @error('slug') is-invalid @enderror"  required />
                           @error('slug')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        <div class="form-group">
                           <label>Seo Title:</label>
                           <input type="text" name="seo_title" id="seo_title" class="form-control col-sm-12 @error('seo_title') is-invalid @enderror" value="{{$category->seo_title}}" required />
                           @error('seo_title')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        <div class="form-group">
                           <label>Seo Description:</label>
                           <textarea class="form-control @error('seo_description') is-invalid @enderror" name="seo_description" id="seo_description" rows="3">{{$category->seo_description}}</textarea>
                           @error('seo_description')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>                
                <button type="submit" class="btn btn-primary">Save</button>
              </form>
            </div>
          </div>
          <br>
        </div>

      </div>



    </div>
  </section>
  <!-- /.content -->
</div>

<script type="text/javascript">
   $('.all-category').addClass('active');
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
       document.getElementById('slug').value =  productSlug; 
       document.getElementById('seo_description').value =  productSlug; 
       document.getElementById('seo_title').value =  productSlug; 
   }
</script>

@endsection