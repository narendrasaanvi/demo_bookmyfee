@extends('backend.layouts.master')
@section('title','Admin-Panel || Banner Create')
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
                  <span><i class="fas fa-file-alt"></i> Enquiries</span>
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
                    <h4 class="card-title mb-0">Enquiries</h4>
                </div>
            </div>

               <div class="card-body">
                <x-toastr-notifications />
                  <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                     <div class="row">
                        <div class="col-sm-12">
                           <table id="example1" class="table table-bordered table-hover table-responsive-sm dataTable no-footer" aria-describedby="example1_info">
                              <thead>
                                 <tr>
                                    <td>Request From</td>
                                    <td>Name</td>
                                    <td>Mobile</td>
                                    <td>Subject</td>
                                    <td>Message</td>
                                    <td>Action</td>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($enquiries as $data)
                                 <tr>
                                    <td class="{{ $data->form_name === 'contact' ? 'text-danger' : ($data->form_name === 'tournament' ? 'text-success' : '') }} {{ in_array($data->form_name, ['contact', 'tournament']) ? 'text-uppercase' : '' }}">
                                        {{ $data->form_name }}
                                    </td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->mobile }}</td>
                                    <td>{{ $data->subject }}</td>
                                    <td>{{ $data->message }}</td>
                                    <td>
                                       <div class="btn-group">
                                          <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Actions
                                          </button>
                                          <div class="dropdown-menu">

                                             <form id="deleteForm{{$data->id}}" method="POST" action="{{ route('enquiry-list.destroy', [$data->id]) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="dropdown-item delete-btn" type="button" data-id="{{$data->id}}">
                                                <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                             </form>
                                          </div>
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                        <!-- /.card-body -->
                     </div>
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
   $('.enquiry-all').addClass('active');
</script>
<script>
    // Add a click event listener to the delete button
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Show a confirmation dialog
            if (confirm('Are you sure you want to delete this FAQ?')) {
                // If the user confirms, submit the form
                document.getElementById('deleteForm' + this.getAttribute('data-id')).submit();
            }
        });
    });
</script>
@endsection
