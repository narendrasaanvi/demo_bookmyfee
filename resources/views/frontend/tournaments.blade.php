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
    font-family: ui-sans-serif;
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
.card-header {
    background: #c377f2;
    border: #c377f2;
    text-align: center;
    color: #fff;
    border-radius: 0px!important;
}
</style>
<section class="search-padding" style="background-image: url(/assets/images/group.png);">
    <div class="container py-3">
         <form action="/tournaments" method="GET" class="search-form pb-3" id="searchForm">
         <div class="row d-flex align-items-end">
            <!-- Location Field -->
            <div class="col-md-4 mt-2">
                  <select id="location" name="state[]" class="form-select">
                     <option value="">State</option>
                     @foreach($states as $data)
                     <option value="{{ $data->id }}">{{ $data->title }}</option>
                     @endforeach
                  </select>
            </div>
            <!-- Category Field -->
            <div class="col-md-4  mt-2">
                  <select id="category" name="tournamenttype[]" class="form-select">
                     <option value="">Tournament Type</option>
                     @foreach($tournamenttype as $data)
                     <option value="{{ $data->id }}">{{ $data->title }}</option>
                     @endforeach
                  </select>
            </div>
            <!-- Submit Button -->
            <div class="col-md-4  mt-2">
                  <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
         </div>
      </form>
    </div>
</section>

<section class="header-padding">
   <div class="container py-3">
   <div class="row">
      <!-- Tournaments Section -->
      <div class="col-md-12 mb-4">
      <div class="row text-start">
    @if($tournament->isEmpty())
        <p>No tournaments available at the moment.</p>
    @else
        @foreach($tournament as $data)
            <div class="col-md-12 mb-3">
                <div class="card shadow-sm">
                    <div class="row g-0">
                        <!-- Image Section -->
                        <div class="col-md-2 d-none d-md-block">
                            <a href="{{ url('/booking-tournament/'.$data->slug) }}">
                                <img src="{{url('uploads/tournament/'.$data->image)}}" class="img-fluid h-100 w-100" alt="{{ $data->title }}" style="object-fit: cover;">
                            </a>
                        </div>

                        <!-- Content Section -->
                        <div class="col-md-10">
                            <div class="card-header">
                                <h4 class="custome-h4">
                                    <a href="{{ url('/booking-tournament/'.$data->slug) }}" class="text-white">{{ $data->title }}</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <ul class="tournaments-points list-unstyled">
                                    <li class="d-flex align-items-center">
                                        <i class="far fa-calendar-alt me-2"></i>
                                        <span class="tournaments-date">
                                            {{ \Carbon\Carbon::parse($data->start_date)->format('d-M-Y') }}
                                            to
                                            {{ \Carbon\Carbon::parse($data->end_date)->format('d-M-Y') }}
                                        </span>
                                    </li>
                                    @php
                                        $categoryIds = explode(',', $data->category_id);
                                        $categories = \App\Models\Category::whereIn('id', $categoryIds)->get();
                                    @endphp

                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-layer-group me-2"></i>
                                        <span class="tournaments-category">
                                            @foreach($categories as $category)
                                                <span>{{ $category->title }}</span>{{ !$loop->last ? ',' : '' }}
                                            @endforeach
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-indian-rupee-sign me-2"></i>
                                        <span class="tournaments-price">{{ $data->price }}/-</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-location-dot me-2"></i>
                                        {{ $data->city }}
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-location-dot me-2"></i>
                                        {{ $data->state->title }}
                                        <a href="{{ $data->google_map_link }}" target="_blank" class="ms-2">View on Google Maps</a>
                                    </li>
                                </ul>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-outline-primary" href="{{ url('uploads/tournament/' .$data->document) }}" download>Brochure</a>
                                    @php
                                $currentDate = \Carbon\Carbon::now();
                                $startDate = \Carbon\Carbon::parse($data->start_date);
                                $endDate = \Carbon\Carbon::parse($data->end_date);
                                @endphp

                                <!-- Check if the tournament is expired -->
                                @if($currentDate->greaterThan($endDate))
                                    <button class="btn btn-secondary" disabled>Expired</button>
                                @else
                                    <a class="btn btn-success ms-auto" href="{{ url('/booking-tournament/'.$data->slug) }}">Book Now</a>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

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
