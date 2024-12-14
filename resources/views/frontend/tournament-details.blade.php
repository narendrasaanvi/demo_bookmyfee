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
<section class="header-padding">
   <div class="container py-3">
      <!-- Tournament Details -->
      <div class="row">
         <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
               <div class="card-header">
                  <h4>{{ $tournament->title }}</h4>
               </div>
               <div class="card-body">
                  <ul class="tournaments-points">
                    <li><b>Organized by:</b> {{ $tournament->organizer }}</li>
                    <li><i class="far fa-calendar-alt"></i><span class="tournaments-date"> {{ \Carbon\Carbon::parse($tournament->start_date)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($tournament->end_date)->format('d/m/Y') }}</span></li>
                    <li><i class="fa-solid fa-location-dot"></i> {{ $tournament->address }}</span> <a href="{{ $tournament->google_map_link }}" target="_blank">View on Google Maps</a></li>
                    <li><i class="fa-solid fa-indian-rupee-sign"></i><span  class="tournaments-price"> Rs.{{ $tournament->price }}</span></li>
                    <li><i class="fa-solid fa-trophy"></i><span  class="tournaments-prize"> {{ $tournament->prize->title }}</span></li>
                     <li><b>Level:</b> {{ $tournament->tournamenttype->title }}</li>
                     <li><b>State:</b> {{ $tournament->state->title }}</li>
                  </ul>
                  <hr>
                  <p>Contact Details</p>
                  <ul class="tournaments-points">
                     <li><i class="fa-solid fa-headset"></i> {{ $tournament->contact_person ?? 'N/A' }}</li>
                     <li><i class="fa-solid fa-envelope"></i> {{ $tournament->contact_email ?? 'N/A' }}</li>
                     <li><i class="fa-solid fa-phone"></i> {{ $tournament->contact_number ?? 'N/A' }}</li>
                  </ul>
                  <hr>
                  <p>Tournament Details</p>
                  <ul class="tournaments-points">
                     <li>{{ $tournament->content ?? 'N/A' }}</li>
                  </ul>
                  <div class="btn-group" role="group">
                     <a class="btn btn-outline-primary" href="{{url('uploads/tournament/'.$tournament->document)}}" download>Brochure</a>
                     <a class="btn btn-primary theme-button" href="{{ url('/booking-tournament/'.$tournament->slug) }}">Book Now</a>
                  </div>
               </div>
            </div>
         </div>
         <!-- Related Tournaments -->
         <div class="col-md-4">
            <div class="ovaev-event-info">
               <ul class="info-contact list-unstyled">
                  <li class="mb-3">
                     <span class="info d-block fw-bold">
                     <span>{{ \Carbon\Carbon::parse($tournament->start_date)->format('h:i a') }}</span>
                     </span>
                     <span class="label text-muted">Timing</span>
                  </li>
                  <li class="mb-3">
                     <span class="info d-block fw-bold">{{ \Carbon\Carbon::parse($tournament->start_date)->format('F d, Y') }}</span>
                     <span class="label text-muted">Date</span>
                  </li>

                  <li class="mb-3">
                     <span class="info d-block fw-bold">{{ $tournament->organizer }}</span>
                     <span class="label text-muted">Organizer Name</span>
                  </li>
                  <li class="mb-3">
                     <a href="tel:{{ $tournament->contact_number }}" class="info d-block fw-bold text-decoration-none">{{ $tournament->contact_number }}</a>
                     <span class="label text-muted">Phone</span>
                  </li>
                  <li class="mb-3">
                     <a href="mailto:{{ $tournament->contact_email }}" class="info d-block fw-bold text-decoration-none">{{ $tournament->contact_email }}</a>
                     <span class="label text-muted">Email</span>
                  </li>
                  <li class="mb-3">
                     <a href="{{ $tournament->website }}" class="info d-block fw-bold text-decoration-none" target="_blank">{{ $tournament->website }}</a>
                     <span class="label text-muted">Website</span>
                  </li>
                  <li class="mb-3">
                     <span class="info d-block fw-bold">{{ $tournament->address }}</span>
                     <span class="label text-muted">Location</span>
                  </li>
               </ul>
               <div class="ovaev-event-share mt-4">
                  <ul class="share-social-icons list-inline mb-0">
                     <li class="list-inline-item">
                        <a class="share-ico ico-facebook text-decoration-none" target="_blank" href="{{ $tournament->facebook }}">
                        <i class="fab fa-facebook"></i>
                        </a>
                     </li>
                     <li class="list-inline-item">
                        <a class="share-ico ico-twitter text-decoration-none" target="_blank" href="{{ $tournament->instgram }}">
                        <i class="fab fa-instagram"></i>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
