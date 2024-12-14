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
                  <div class="">
                     <h2 class="title">
                     About Us
                     </h2>
                     <p class="desc">
                     Introduction: Welcome to Book My Fee, your premier platform for organizing
                     and registering chess tournaments. We aim to simplify event management and
                     ensure secure payments, helping organizers and participants connect
                     effortlessly.
                     </p>
                     <h3>Our Mission: </h3>
                     <p class="desc">At Book My Fee, our mission is to provide a seamless and secure
                     platform for chess enthusiasts worldwide. We strive to promote chess by
                     offering a centralized space for listing, managing, and participating in
                     tournaments.
                     </p>
                     <h2 class="text-start">Our Services</h2>
                     <ul class="list-unstyled">
                        <li><strong>Tournament Listings:</strong> Easily list your chess tournaments and reach a global audience.</li>
                        <li><strong>Event Management:</strong> Efficiently manage registrations and communicate event updates.</li>
                        <li><strong>Secure Payments:</strong> Safe and secure payment processing for hassle-free transactions.</li>
                     </ul>              
                     <h2 class="text-start">Why Choose Us</h2>
                     <ul class="list-unstyled">
                        <li><strong>Increased Visibility:</strong> Gain exposure to a vast community of chess players.</li>
                        <li><strong>Effortless Registration:</strong> Simplify the registration process with our user-friendly interface.</li>
                        <li><strong>Dedicated Support:</strong> Receive responsive support from our team to ensure a smooth experience.</li>
                     </ul> 
                     <p>Join us at Book My Fee and elevate your chess tournaments to new heights!</p>           
                  </div>
               </div>
            </div>
         </div>
      </section>
@endsection
