@extends('frontend.layouts.master')
@section('title', 'Tournament Details')
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
   .accordion-item {
   margin-bottom: 6px;
   }
</style>

      <!-- Payment Now Section -->
<section id="payment-now" class="header-padding">
    <div class=" container py-5">
    <div class="row justify-content-center">
    <div class="col-md-6 text-center">
      <h2 class="display-4">Complete Your Payment</h2>
      <p class="lead">Proceed to payment to complete your order</p>
      <!-- Payment Info (Optional) -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Order Summary</h5>
          <p class="card-text">Product: <strong>Item Name</strong></p>
          <p class="card-text">Amount: <strong>Rs100.00</strong></p>
        </div>
      </div>
      <!-- Payment Button -->
      <button class="btn btn-primary btn-lg" onclick="window.location.href='payment-processor-url'">
        Pay Now
      </button>
    </div>
  </div>
    </div>

</section>

<!-- Optionally, you can add a spinner to indicate processing if needed -->
<div id="processing-spinner" class="d-none text-center">
  <div class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>

@endsection
