@extends('frontend.layouts.master')
@section('title','Welcome')
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
   .searc-form{
    background: linear-gradient(97.14deg, #7579FF 7.11%, #B224EF 97.04%);
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 10px;
    color: #fff;
    }
   
</style>

<!-- Search Group with Location and Category Filters -->


      <section id="schedule" class="schedule-sec header-padding">
         <div class="container">
            <div class="section-head text-center col-xl-8 m-auto mb-5">
               <span class="label mb-4">Search Tournaments lists</span>
            </div>

            <div class="container mt-5">
            <form action="/tournaments" method="GET" class="searc-form">
                <div class="row">
                <!-- Location Field -->
                <div class="col-md-4 mb-3">
                    <label for="location" class="form-label">Location</label>
                    <select id="location" name="state[]" class="form-select">
                    <option value="">Select Location</option>
                    @foreach($states as $data)
                    <option value="{{ $data->id }}">{{ $data->title }}</option>
                    @endforeach
                    </select>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="location" class="form-label">Gender</label>
                    <select id="location" name="gender[]" class="form-select">
                    <option value="">Select Gender</option>
                    <option value="boy">Boy</option>
                    <option value="girl">Girl</option>
                    </select>
                    </select>
                </div>

                <!-- Category Field -->
                <div class="col-md-4 mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" name="categories[]" class="form-select">
                    <option value="">Select Category</option>
                    @foreach($categories as $data)
                    <option value="{{ $data->id }}">{{ $data->title }}</option>
                    @endforeach
                    </select>
                </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            </div>

            <div class="schedule-content-wrap">
               <div class="tab-content schedule-tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-day-1" role="tabpanel" aria-labelledby="pills-day-1-tab" tabindex="0">
                  @foreach($tournamentslists as $tournamentslist)
                  <div class="row schedule-item" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(assets/images/schedule1.png);">
                        <div class="col-lg-4">
                           <div class="d-flex align-items-center justify-content-around">
                              <div class="card-thumb item-thumb">
                                 <img src="{{ url('uploads/tournament/'.$tournamentslist->image) }}" onerror="this.onerror=null; this.src='{{ url('uploads/tournament/17331332101.png') }}';"  class="circule-image" alt="{{$tournamentslist->title}}"/>
                              </div>
                              <div class="card-description">
                                 <span class="name d-block">Event Date</span>
                                 <span class="date d-block">{{$tournamentslist->start_date}}</span>
                                 <span class="time d-block">{{$tournamentslist->end_date}}</span>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-8">
                           <div class=" d-flex align-items-center justify-content-between">
                              <div class="card-title-area col-7">
                                 <h4 class="title">{{$tournamentslist->title}}</h4>
                                 <p class="title-desc"> {{ \Illuminate\Support\Str::words($tournamentslist->content, 10) }} <a href="{{url('tournament/'.$tournamentslist->slug)}}">Read More</a></p>
                              </div>
                              <div class="card-button col-5">
                                <a href="{{ url('/booking-tournament/'.$tournamentslist->slug) }}">
                                    <button class="custom-btn2">Join Now</button>
                                </a>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
               <div class=" text-center py-3">
                    <a href="{{url('tournaments')}}">
                  <button class="custom-btn schedule-btn">View All</button>
                  </a>
               </div>
               <div class="dots img-moving-anim1">
                  <img src="assets/images/dots2.png" alt="Shadow Image">
               </div>
            </div>
         </div>
         <div class="shape">
            <img src="assets/images/2.svg" alt="Shape">
         </div>
      </section>

      <section class="contact-sec" data-aos="zoom-in" data-aos-duration="1000">
         <div class="container">
            <div class="col-xl-5 section-head text-center m-auto mb-5">
               <span class="label">Contact The Eventor Sales Team</span>
               <h2 class="title mx-2">
                  We are here when you need us.
                  Need immediate assistance?
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
                              <a class="icon d-block mb-3">
                                 <img src="assets/images/mail1.svg" alt="Mail" style="color: #fff;">
                                 support@bookmyfee.com
                              </a>
                              <a class="location d-block mb-3">
                                 <img src="assets/images/map-pin2.svg" alt="Map">
                                 support@bookmyfee.com
                              </a>
                              <a class="phone d-block">
                                 <img src="assets/images/phone3.svg" alt="Phone">
                                 support@bookmyfee.com
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
      <!-- contact sec end -->
      <div class="container">
         <hr>
      </div>



@endsection
