@extends('backend.layouts.master')

@section('title','Admin-Panel || Tournament Create')

@section('main-content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb my-0 ms-2">
                        <li class="breadcrumb-item">
                            <a href="{{ URL::asset('admin/dashboard') }}">
                                <i class="fas fa-cubes"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span><i class="fas fa-file-alt"></i> Payment History</span>
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
            <!-- Tournament List -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0"> Payment History</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <script type="text/javascript">
                                    toastr.success('{{ session("status") }}');
                                </script>
                            @elseif(session('failed'))
                                <script type="text/javascript">
                                    toastr.warning('{{ session("failed") }}');
                                </script>
                            @endif

                            <div id="example1_wrapper" class="tournamentTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example1"
                                            class="table table-bordered table-hover table-responsive-sm tournamentTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>Order Id</th>
                                                    <th>User Name</th>
                                                    <th>organizer & Tournament</th>
                                                    <th>Payment Status</th>
                                                    <th>Amount</th>
                                                    <th>Payment Mode</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($payments as $payment)
                                                <tr style="background-color: {{ $loop->even ? '#ffffff' : '#f9f9ff' }}; color: #555;">
                                                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $payment->order_id }}</td>
                                                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $payment->user->name ?? 'N/A' }}</td>
                                                    <td style="padding: 10px; border: 1px solid #ddd;">
                                                        {{ $payment->tournament->organizer ?? 'N/A' }}<br>
                                                        <a href="{{ url('booking-tournament/' . ($payment->tournament->slug ?? '')) }}" target="_blank" style="color: #007bff; text-decoration: none;">
                                                            {{ $payment->tournament->title ?? 'N/A' }}
                                                        </a>
                                                    </td>
                                                    <td style="padding: 10px; border: 1px solid #ddd;">
                                                        Payment Status: 
                                                        <span style="color: {{ $payment->payment_status === 'approve' ? 'green' : 'red' }};">
                                                            {{ $payment->payment_status }}
                                                        </span>
                                                        <br>
                                                        Transaction ID: {{ $payment->provider_reference_id }}
                                                    </td>
                                                    <td style="padding: 10px; border: 1px solid #ddd;">Rs {{ $payment->amount}}/-</td>
                                                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $payment->payment_mode }}</td>
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
   $('.payment').addClass('active');
</script>

@endsection
