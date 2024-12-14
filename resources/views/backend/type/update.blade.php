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

              <form method="POST" action="{{ route('type.update', $type->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
              @csrf
              @method('PUT')
                 <div class="form-group">
                  <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" id="title" class=" form-control col-sm-12" value="{{ $type->title }}" required />
                  </div>
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
   $('.all-type').addClass('active');
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