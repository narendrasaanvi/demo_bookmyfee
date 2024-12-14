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
                        <li class="breadcrumb-item"><a href="{{ URL::asset('admin/dashboard')}}"><i
                                    class="fas fa-cubes"></i> Dashboard</a></li>
                        <li class="breadcrumb-item active">
                            <span><i class="fas fa-file-alt"></i> tournament</span>
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
                                <h4 class="card-title mb-0">Tournament</h4>
                                <div>
                                    <a href="{{ route('tournament.create') }}" class="btn btn-success btn-sm"><i
                                            class="fas fa-plus"></i> Add More</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                            <script type="text/javascript">
                            toastr.success('{{ session("status") }}')
                            </script>
                            @elseif(session('failed'))
                            <script type="text/javascript">
                            toastr.warning('{{ session("failed") }}')
                            </script>
                            @endif
                            <div id="example1_wrapper" class="tournamentTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example1"
                                            class="table table-bordered table-hover table-responsive-sm tournamentTable no-footer"
                                            aria-describedby="example1_info">
                                            <thead>
                                                <tr>
                                                    <th>Personal Info</th>
                                                    <th>Address</th>
                                                    <th>Additional Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($playerlists as $playerlist)
                                                <tr>
                                                    <!-- Personal Info Group -->
                                                    <td>
                                                        <strong>Name:</strong> {{ $playerlist->player_name }}<br>
                                                        <strong>Mobile:</strong> {{ $playerlist->mobile_1 }}<br>
                                                        <strong>Email:</strong> {{ $playerlist->email }}
                                                    </td>
                                                    <!-- Address Group -->
                                                    <td>
                                                        <strong>Address:</strong> {{ $playerlist->residential_address }}<br>
                                                        <strong>State:</strong> {{ $playerlist->state }}<br>
                                                        <strong>District:</strong> {{ $playerlist->district }}<br>
                                                        <strong>Pin Code:</strong> {{ $playerlist->pin_code }}
                                                    </td>
                                                    <!-- Additional Details Group -->
                                                    <td>
                                                        <strong>Gender:</strong> {{ $playerlist->gender }}<br>
                                                        <strong>Date of Birth:</strong> {{ $playerlist->dob }}<br>
                                                        <strong>Father's Name:</strong> {{ $playerlist->father_name }}<br>
                                                        <strong>School/College:</strong> {{ $playerlist->school_college_name }}<br>
                                                        <strong>Online Chess ID:</strong> {{ $playerlist->online_chess_id }}
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
$('.all-tournament').addClass('active');
$('.tournament').addClass('active');
</script>
<script>
// Add a click event listener to the delete button
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Show a confirmation dialog
        if (confirm('Are you sure you want to delete this tournament?')) {
            // If the user confirms, submit the form
            document.getElementById('deleteForm' + this.getAttribute('tournament-id')).submit();
        }
    });
});
</script>
@endsection
