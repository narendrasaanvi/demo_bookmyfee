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
    .list-group-item.active {
        z-index: 2;
        color: #fff;
        background-color: #7f6cfd;
        border-color: #7f6cfd;
    }
    table {
        border: 1px solid #ddd;
        width: 100%;
    }
    table thead th {
        border-bottom: 1px solid #ddd;
    }
    table tbody td {
        border-bottom: 1px solid #ddd;
    }
    a {
        text-decoration: none!important;
        color: #000;
    }
    .download-btn {
        margin-bottom: 20px;
        padding: 10px 15px;
        background-color: #7f6cfd;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    td {
    text-transform: capitalize;
}
</style>

<section class="header-padding">
    <div class="container py-3 ">
        <!-- Category Section -->
        <div class="row ">
            <div class="col-md-12 bg-white py-3">
                <p>Payment Receipt</p>
                <div class="table-responsive">
                    @if($invoices->isEmpty())
                        <p class="text-center">No receipts available, as you have not registered for any Events.</p>
                    @else
                        <table id="player-table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tournament</th>
                                    <th>Order No</th>
                                    <th>Order By</th>
                                    <th>Amount</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->tournament->title }}</td>
                                    <td>{{ $invoice->order_id }}</td>
                                    <td>{{ $invoice->user->name }}</td>
                                    <td>{{ $invoice->amount }}</td>
                                    <td><a href="{{url('/payment-receipt/'.$invoice->order_id)}}">Download</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
