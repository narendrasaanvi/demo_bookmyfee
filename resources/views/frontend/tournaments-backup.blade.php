@extends('frontend.layouts.master')
@section('title','Welcome')
@section('main-content')
<style>
   .header-padding {
   background: #f5f5f5;
   }
   .search-padding {
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
   span.tournaments-date {
    color: red;
    font-weight: 700;
}
.search-form{
   background: #ffffff54;
    padding: 10px;
    border-radius: 10px;
}
.custome-h4{
   font-size: 16px;
    font-weight: 900;
    padding-top: 8px;
}
</style>
<section class="search-padding" style="background-image: url(/assets/images/group.png);">
    <div class="container py-5">
         <form action="/tournaments" method="GET" class="search-form" id="searchForm">
         <div class="row d-flex align-items-end">
            <!-- Location Field -->
            <div class="col-md-3 mb-3">
                  <label for="location" class="form-label">Location</label>
                  <select id="location" name="state[]" class="form-select">
                     <option value="">Select Location</option>
                     @foreach($states as $data)
                     <option value="{{ $data->id }}">{{ $data->title }}</option>
                     @endforeach
                  </select>
            </div>
            <!-- Gender Field -->
            <div class="col-md-3 mb-3">
                  <label for="gender" class="form-label">Gender</label>
                  <select id="gender" name="gender[]" class="form-select">
                     <option value="">Select Gender</option>
                     <option value="boy">Boy</option>
                     <option value="girl">Girl</option>
                  </select>
            </div>
            <!-- Category Field -->
            <div class="col-md-3 mb-3">
                  <label for="category" class="form-label">Category</label>
                  <select id="category" name="categories[]" class="form-select">
                     <option value="">Select Category</option>
                     @foreach($category as $data)
                     <option value="{{ $data->id }}">{{ $data->title }}</option>
                     @endforeach
                  </select>
            </div>
            <!-- Submit Button -->
            <div class="col-md-3 mb-3">
                  <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
         </div>
      </form>
    </div>
</section>

<section class="header-padding">
   <div class="container py-5">
   <div class="row">
      <div class="col-md-4">
         <div class="accordion" id="filterAccordion">
            <form method="GET" action="{{ url()->current() }}" id="filterForm">
               <!-- Date Section -->

               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingDate">
                     <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDate" aria-expanded="true" aria-controls="collapseDate">
                     Date
                     </button>
                  </h2>
                  <div id="collapseDate" class="accordion-collapse collapse show" aria-labelledby="headingDate" data-bs-parent="#filterAccordion">
                     <div class="accordion-body">
                        <!-- This Week Option -->
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="date" value="this_week" id="thisWeek" {{ request('date') == 'this_week' ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label" for="thisWeek">This Week</label>
                        </div>
                        <!-- Next Week Option -->
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="date" value="next_week" id="nextWeek" {{ request('date') == 'next_week' ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label" for="nextWeek">Next Week</label>
                        </div>
                        <!-- Weekends Option -->
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="date" value="weekends" id="weekends" {{ request('date') == 'weekends' ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label" for="weekends">Weekends</label>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Day Section -->
               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingDay">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDay" aria-expanded="false" aria-controls="collapseDay">
                     Day
                     </button>
                  </h2>
                  <div id="collapseDay" class="accordion-collapse collapse" aria-labelledby="headingDay" data-bs-parent="#filterAccordion">
                     <div class="accordion-body">
                        @foreach($days as $data)
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="day" value="{{ $data->title }}" id="day-{{ $data->title }}" {{ request('day') == $data->title ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label" for="day-{{ $data->title }}">{{ $data->title }}</label>
                        </div>
                        @endforeach
                     </div>
                  </div>
               </div>
               <!-- Tournament Type Section -->
               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTournamentType">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTournamentType" aria-expanded="false" aria-controls="collapseTournamentType">
                     Tournament Type
                     </button>
                  </h2>
                  <div id="collapseTournamentType" class="accordion-collapse collapse" aria-labelledby="headingTournamentType" data-bs-parent="#filterAccordion">
                     <div class="accordion-body">
                        @foreach($tournamenttype as $data)
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="tournamenttype[]" value="{{ $data->id }}" {{ in_array($data->id, request('tournamenttype', [])) ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label">{{ $data->title }}</label>
                        </div>
                        @endforeach
                     </div>
                  </div>
               </div>
               <!-- Category Section -->
               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingCategory">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                     Category
                     </button>
                  </h2>
                  <div id="collapseCategory" class="accordion-collapse collapse" aria-labelledby="headingCategory" data-bs-parent="#filterAccordion">
                     <div class="accordion-body">
                        @foreach($category as $data)
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $data->id }}" {{ in_array($data->id, request('categories', [])) ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label">{{ $data->title }}</label>
                        </div>
                        @endforeach
                     </div>
                  </div>
               </div>
               <!-- Entry Fee Section -->
               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingEntryFee">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEntryFee" aria-expanded="false" aria-controls="collapseEntryFee">
                     Entry Fee
                     </button>
                  </h2>
                  <div id="collapseEntryFee" class="accordion-collapse collapse" aria-labelledby="headingEntryFee" data-bs-parent="#filterAccordion">
                     <div class="accordion-body">
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="entry_fee[]" value="0" {{ in_array('0', request('entry_fee', [])) ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label">Free</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="entry_fee[]" value="0-500" {{ in_array('0-500', request('entry_fee', [])) ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label">0 - 500</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="entry_fee[]" value="500-1500" {{ in_array('500-1500', request('entry_fee', [])) ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label">500 - 1500</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="entry_fee[]" value="1500" {{ in_array('1500', request('entry_fee', [])) ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label">Above 1500</label>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Prizes Section -->
               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingPrizes">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrizes" aria-expanded="false" aria-controls="collapsePrizes">
                     Prizes
                     </button>
                  </h2>
                  <div id="collapsePrizes" class="accordion-collapse collapse" aria-labelledby="headingPrizes" data-bs-parent="#filterAccordion">
                     <div class="accordion-body">
                        @foreach($prizes as $data)
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="prizes[]" value="{{ $data->id }}" {{ in_array($data->id, request('prizes', [])) ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label">{{ $data->title }}</label>
                        </div>
                        @endforeach
                     </div>
                  </div>
               </div>
               <!-- State Section -->
               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingState">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseState" aria-expanded="false" aria-controls="collapseState">
                     State
                     </button>
                  </h2>
                  <div id="collapseState" class="accordion-collapse collapse" aria-labelledby="headingState" data-bs-parent="#filterAccordion">
                     <div class="accordion-body">
                        @foreach($states as $data)
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="state[]" value="{{ $data->id }}" {{ in_array($data->id, request('state', [])) ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label">{{ $data->title }}</label>
                        </div>
                        @endforeach
                     </div>
                  </div>
               </div>
               <!-- State Section -->
               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingGender">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGender" aria-expanded="false" aria-controls="collapseGender">
                     Gender
                     </button>
                  </h2>
                  <div id="collapseGender" class="accordion-collapse collapse" aria-labelledby="headingGender" data-bs-parent="#filterAccordion">
                     <div class="accordion-body">

                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="gender[]" value="boy" {{ in_array('boy', request('gender', [])) ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label">Boy</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="gender[]" value="girl" {{ in_array('girl', request('gender', [])) ? 'checked' : '' }} onchange="applyFilters()">
                           <label class="form-check-label">Girl</label>
                        </div>

                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <!-- Tournaments Section -->
      <div class="col-md-8  mb-4">
         <div class="row text-start">
                @if($tournament->isEmpty())
                <p>No tournaments available at the moment.</p>
                @else
                @foreach($tournament as $data)
                    <div class="col-md-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h4 class="custome-h4"><a href="{{ url('/tournament/'.$data->slug) }}" class="text-white">{{ $data->title }}</a></h4>
                            </div>
                            <div class="card-body">
                                <ul class="tournaments-points list-unstyled">
                                    <!-- <li class="d-flex align-items-center">
                                        <b class="me-2">Organized by:</b> {{ $data->organizer }}
                                    </li> -->
                                    <li class="d-flex align-items-center">
                                        <i class="far fa-calendar-alt me-2"></i>
                                        <span class="tournaments-date"> {{ \Carbon\Carbon::parse($data->start_date)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($data->end_date)->format('d/m/Y') }}</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-layer-group me-2"></i>
                                        <span class="tournaments-category">
                                            @foreach(explode(',', $data->category_id) as $categoryId)
                                                @php
                                                    $category = \App\Models\Category::find($categoryId);
                                                @endphp
                                                @if($category)
                                                    <span>{{ $category->title }}</span>{{ !$loop->last ? ',' : '' }}
                                                @endif
                                            @endforeach
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-indian-rupee-sign me-2"></i>
                                        <span class="tournaments-price"> {{ $data->price }}/-</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-location-dot me-2"></i>
                                        {{ $data->state->title }}
                                        <a href="{{ $data->google_map_link }}" target="_blank" class="ms-2">View on Google Maps</a>
                                    </li>

                                    <!-- Displaying Multiple Categories -->



                                    <!-- <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-trophy me-2"></i>
                                        <span class="tournaments-prize"> {{ $data->prize->title }}</span>
                                    </li> -->
                                    <!-- <li class="d-flex align-items-center">
                                    <i class="fa-solid fa-person-half-dress  me-2"></i>
                                        <span class="tournaments-prize text-capitalize"> {{ $data->gender }}</span>
                                    </li> -->
                                </ul>

                                <div class="btn-group" role="group">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-outline-primary" href="{{url('uploads/tournament/' .$data->document) }}" download>Brochure</a>
                                    <!-- <a class="btn btn-primary theme-button" href="{{ url('/tournament/'.$data->slug) }}">View Now</a> -->
                                    <a class="btn btn-success ms-auto" href="{{ url('/booking-tournament/'.$data->slug) }}">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                @endforeach
                @endif
         </div>
      </div>
      <!-- Pagination -->
      <div class="d-flex justify-content-center">
         {{ $tournament ->links('pagination::bootstrap-5') }}
      </div>
   </div>
</section>
<script>
   function applyFilters() {
       // Get the form element and submit it
       document.getElementById('filterForm').submit();
   }
</script>
<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        const form = event.target;
        const inputs = form.querySelectorAll('select');

        inputs.forEach(input => {
            if (!input.value) {
                input.name = ''; // Clear name to exclude it from the submission
            }
        });
    });
</script>
@endsection
