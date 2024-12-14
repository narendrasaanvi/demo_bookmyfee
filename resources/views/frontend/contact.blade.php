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

<section class="contact-sec aos-init aos-animate header-padding" data-aos="zoom-in" data-aos-duration="1000">
         <div class="container">
            <div class="col-xl-5 section-head text-center m-auto mb-5">
               <h2 class="title mx-2">
                  We are here when you need us.
                  Need immediate assistance?
                    <a href="https://wa.me/09159166464" target="_blank">
                    <span><i class="fa-brands fa-whatsapp text-success"></i> (+91) 915 916 6464</span>
                    </a>
               </h2>
            </div>
            <div class="contact-wrap bg-none p-0">
               <div class="dots">
                  <img src="assets/images/dots13.png" alt="Shadow Image" class="contact-dots-1 img-moving-anim2">
               </div>
               <div class="contact-wrap row py-4 px-3 contact align-items-center m-0">
                  <div class="col-lg-4">
                     <div class="contact-thumb-wrap" style="background-image: url(assets/images/contact-bg.png);">
                        <div class="contact-content">
                           <h5 class="title text-white">Contact Us</h5>
                           <p class="desc">
                              Get in touch and let us know how
                              we can help.
                           </p>
                           <div class="info">
                            <a class="icon d-block mb-3" href="mailto:info@bookmyfee.com">
                            <img src="assets/images/mail1.svg" alt="Mail" style="color: #fff;">
                            info@bookmyfee.com
                            </a>
                              <a class="location d-block mb-3" href="https://maps.google.com/?q=13.0772706,80.1178481" target="_blank">
                                 <img src="assets/images/map-pin2.svg" alt="Map">
                                 No : 207, Vinayagar Kovil Road, Kasthuribhai Avenue, (Near by Abirami Nagar) Thiruverkadu, Chennai - 600077
                              </a>
                            <a class="phone d-block" href="https://wa.me/09159166464">
                            <img src="assets/images/phone3.svg" alt="Phone">
                            (+91) 915 916 6464
                            </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-8 mt-4 mt-lg-0">
                  <x-sweet-alert :message="session('success')" type="success" />
                  <form class="contact-form" action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="hidden" name="form_name"  value="contact" required>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Your Mobile" value="{{ old('mobile') }}" required>
                                @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject" value="{{ old('subject') }}" required>
                                @error('subject')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="text-area col-12 mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Enter Your Message" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="custom-btn2" type="submit">Submit</button>
                    </form>
                  </div>
               </div>

               <div class="dots">
                  <img src="assets/images/dots14.png" alt="Shadow Image" class="contact-dots-2 img-moving-anim3">
               </div>
            </div>
         </div>
      </section>
@endsection
