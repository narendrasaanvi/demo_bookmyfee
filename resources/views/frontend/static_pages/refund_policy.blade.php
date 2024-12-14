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
<section class="video-sec header-padding" data-src="assets/images/home-conference-video-bg.svg" data-parallax="">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-lg-12">
         <div class="container">
    <h2 class="text-center mb-4">Cancellation and Refund Policy</h2>
    <p class="mb-3">
        This Cancellation and Refund Policy (<strong>“Policy”</strong>) applies to all chess tournament registrations made through the BookMyFee website (<strong>“Website”</strong>).
    </p>

    <h4 class="mb-3">Cancellations by Organizers:</h4>
    <ul class="mb-3">
        <li><strong>Tournament Cancellation:</strong> Organizers have the right to cancel their tournaments due to unforeseen circumstances. In such cases, BookMyFee will notify registered players via email and facilitate full refunds to the original payment method used for registration.</li>
        <li><strong>Date/Time Change:</strong> Organizers can reschedule or change the date and time of a tournament. If the new date/time significantly conflicts with a player's schedule, players can request a full refund by contacting BookMyFee within 48 hours of the announced change. After 48 hours, the standard refund policy (below) applies.</li>
    </ul>

    <h4 class="mb-3">Cancellations by Players:</h4>
    <ul class="mb-3">
        <li><strong>Full Refund:</strong> Players can receive a full refund if they cancel their registration before the tournament registration deadline set by the organizer. This deadline will be clearly displayed on the tournament page.</li>
        <li><strong>Partial Refund:</strong> Players who cancel after the registration deadline but at least 7 days before the tournament start date will receive a 50% refund.</li>
        <li><strong>No Refund:</strong> Unfortunately, refunds will not be granted for cancellations made within 7 days of the tournament start date.</li>
    </ul>

    <h4 class="mb-3">Processing Refunds:</h4>
    <p class="mb-3">
        Refunds will be credited to the original payment method used for registration within 5-7 working days.
    </p>

    <h4 class="mb-3">Tournament Fees:</h4>
    <p class="mb-3">
        Please note that some tournament organizers may charge additional fees beyond the registration fee. These may include late registration fees or processing fees. These additional fees are non-refundable under any circumstances.
    </p>

    <h4 class="mb-3">Exceptions:</h4>
    <p class="mb-3">
        BookMyFee reserves the right to deviate from this policy in exceptional circumstances, such as technical issues with the Website or unforeseen events beyond our control. We will communicate any such exceptions clearly to affected players.
    </p>

    <h4 class="mb-3">Contact Us:</h4>
    <p class="mb-3">
        If you have any questions regarding this Cancellation and Refund Policy, please contact BookMyFee by emailing <a href="mailto:support@bookmyfee.com">support@bookmyfee.com</a>.
    </p>
</div>

      </div>
   </div>
</section>
@endsection
