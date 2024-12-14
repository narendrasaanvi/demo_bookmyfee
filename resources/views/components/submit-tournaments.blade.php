<div class="modal popup-box fade" id="exampleModal" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog popup-box-dialog modal-dialog-centered">
      <div class="modal-content popup-box-content">
         <div class="popup-card" style="width:100%">
            <button type="button" class="btn popup2-btn ms-auto" data-bs-dismiss="modal">
               <i class="fa-solid fa-xmark"></i>
            </button>
            <img src="{{url('assets/images/popup.png')}}" class="card-img-top" alt="popup-bg">
            <div class="card-body popup-card-body">
               <div class="popup-title-area">
                  <h5 class="card-title popup-title">List Your Tournament</h5>
               </div>
               <a href="#" class="btn popup-play" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                  <i class="fa-solid fa-play"></i>
               </a>
            </div>
            <x-sweet-alert :message="session('success')" type="success" />
                  <form class="contact-form p-4" action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="hidden" name="form_name"  value="tournament" required>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Your Mobile" value="{{ old('mobile') }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject" value="{{ old('subject') }}" required>
                            </div>
                        </div>
                        <div class="text-area col-12 mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Enter Your Message" required>{{ old('message') }}</textarea>
                        </div>
                        <button class="custom-btn2" type="submit">Submit</button>
                    </form>
         </div>
      </div>
   </div>
</div>
