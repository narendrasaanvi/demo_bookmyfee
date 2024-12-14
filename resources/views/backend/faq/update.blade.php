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

              <form method="POST" action="{{ route('faqs.update', $faq->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
              @csrf
              @method('PUT')
                <div class="form-group">
                  <div class="form-group">
                    <label>FAQ Question:</label>
                    <input type="text" name="title" id="title" class=" form-control col-sm-12" value="{{ $faq->title }}" required />
                  </div>
                </div>
                <div class="form-group">
                  <label>FAQ Answer:</label>
                  <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3">{{ $faq->content }}</textarea>
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