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
   .thanks-message {
      margin: 40px 0;
      font-size: 18px;
      color: #333;
   }
   .cta-btn {
      background: #007bff;
      color: #fff;
      padding: 12px 25px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      margin-top: 20px;
   }
</style>

<section class="contact-sec aos-init aos-animate header-padding" data-aos="zoom-in" data-aos-duration="1000">
   <div class="container">
      <div class="col-xl-5 section-head text-center m-auto mb-5">
         <span class="label">Thanks </span>
         <h2 class="title mx-2">
            Thanks for Your Interest! Your Booking Id : {{$orderId}}
         </h2>
      </div>

      <div class="thanks-message text-center">
         <p>We truly appreciate your interest in our tournament event. Our team will review your details and get back to you shortly.</p>
         <p>If you have any questions in the meantime, feel free to reach out to us.</p>
         <p>Your participation in the tournament will bring valuable contributions to the community!</p>
         <a href="{{ url('/payment-receipt/' . $orderId) }}" class="cta-btn">Downlaod Invoice</a>
      </div>
   </div>
</section>
@endsection
