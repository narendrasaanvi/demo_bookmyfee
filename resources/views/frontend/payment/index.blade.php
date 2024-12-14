@extends('frontend.layouts.master')
@section('title', 'Complete Your Payment')
@section('main-content')

<style>
    .header-padding {
        margin-top: 100px;
        background: #f5f5f5;
    }

    .payment-card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .btn-pay {
        background-color: #007bff;
        border: none;
        color: #ffffff;
        padding: 10px 20px;
        font-size: 1.2rem;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-pay:hover {
        background-color: #0056b3;
        color: #ffffff;
    }

    #processing-spinner {
        margin-top: 20px;
    }
</style>

<section id="payment-now" class="header-padding">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center">
                    <h4 class="display-5">Complete Your Payment</h4>
                    <p class="lead">Proceed to payment to finalize your order</p>
                </div>
                <!-- Payment Info -->
                <div class="card payment-card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>
                        <p class="card-text">Product: <strong>{{ $payment->product_name ?? 'Tournament Registration' }}</strong></p>
                        <p class="card-text">Amount: <strong>Rs{{ number_format($payment->amount, 2) }}</strong></p>
                        <p class="card-text">Order ID: <strong>{{ $payment->order_id }}</strong></p>
                    </div>
                </div>
                <!-- Payment Form -->
                <div class="text-center">
                    <form action="{{ route('payment-store') }}" method="post">
                        @csrf
                        <input type="hidden" name="orderId" value="{{ $payment->order_id }}">
                        <input type="hidden" name="amount" value="{{ number_format($payment->amount, 2) }}">
                        <button type="submit" class="btn-pay">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
