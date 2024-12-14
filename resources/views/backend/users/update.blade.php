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

              <form method="POST" action="{{ route('users.update', $users->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label>Name:</label>
                  <input type="text" name="name" id="name" class=" form-control col-sm-12" value="{{ $users->name }}" required />
                </div>
                <div class="form-group">
                  <label>Email:</label>
                  <input type="email" name="email" id="email" class=" form-control col-sm-12" value="{{ $users->email }}" required />
                </div>
                <div class="form-group">
                  <label>Mobile No:</label>
                  <input type="number" name="phone" id="phone" class=" form-control col-sm-12" value="{{ $users->phone }}" required />
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" name="status">
                    <option value="1" {{ $users->is_active == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $users->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                  </select>
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
  $('.users').addClass('active');
</script>


@endsection
