@extends('backend.layouts.master')
@section('pageTitle', 'Admin | brands')
@section('main-content')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <ol class="breadcrumb my-0 ms-2">
                  <li class="breadcrumb-item"><a href="{{ URL::asset('admin/dashboard')}}"><i class="fas fa-cubes"></i> Dashboard</a></li>
                  <li class="breadcrumb-item active">
                     <span><i class="fas fa-file-alt"></i> FAQ</span>
                  </li>
               </ol>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">
                     <div id="clock"></div>
                  </li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <!-- Small boxes (Stat box) -->
         <div class="row">
            <div class="col-md-12">
               <div class="card card-primary">
                  <div class="card-header">
                     <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">FAQ</h4>
                        <div>
                           <a href="{{ route('faqs.index') }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> View ALL</a>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     @if (session('success'))
                     <script type="text/javascript">
                        toastr.success('{{ session("success") }}')
                     </script>
                     @elseif(session('failed'))
                     <script type="text/javascript">
                        toastr.warning('{{ session("warning") }}')
                     </script>
                     @endif
                     <form method="POST" action="{{ route('faqs.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                           <label>FAQ Question:</label>
                           <input type="text" name="title" id="title" class="form-control col-sm-12 @error('title') is-invalid @enderror" value="{{old('title')}}" required />
                           @error('title')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        <div class="form-group">
                           <label>FAQ Answer:</label>
                           <textarea class="form-control @error('title') is-invalid @enderror" name="content" rows="3">{{old('content')}}</textarea>
                           @error('content')
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
@endsection