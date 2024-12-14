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
   span.tournaments-date {
   color: red;
   font-weight: 700;
   }
   ol, ul {
   padding-left: 0rem;
   }
   .custome-boader{
      border-right: solid 1px #eee;
   }
   @media screen and (max-width: 768px) {
    .custome-boader {
        border-right: none;
    }
}
.custome-bold {
    font-weight: 900;
}
.custome-font-size {
   font-size: 18px;
}
</style>
<section class="header-padding">
   <div class="container py-3">
      <!-- Tournament Details -->
      <div class="row">
         <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
               <div class="card-header text-center">
                  <h4>{{ $tournament->title }}</h4>
               </div>
               <div class="card-body">
               <div class="row">
                     <div class="col-md-6 custome-boader">
                        <ul class="tournaments-points">
                           <!-- <li><b>Organized by:</b> {{ $tournament->organizer }}</li> -->
                           <li class="d-flex align-items-center">
                                        <i class="far fa-calendar-alt me-2"></i>
                                        <span class="tournaments-date">
                                            {{ \Carbon\Carbon::parse($tournament->start_date)->format('d-M-Y') }}
                                            to
                                            {{ \Carbon\Carbon::parse($tournament->end_date)->format('d-M-Y') }}
                                        </span>
                           </li>
                           <!-- <li><i class="fa-solid fa-location-dot"></i>  {{ $tournament->address }}</li> -->
                           <li><i class="fa-solid fa-location-dot"></i> <a href="{{ $tournament->google_map_link }}" target="_blank">View on Google Maps</a></li>
                           <!-- <li><i class="fa-solid fa-indian-rupee-sign"></i><span class="tournaments-price"> Rs.{{ $tournament->price }}</span></li>
                           <li><i class="fa-solid fa-trophy"></i><span class="tournaments-prize"> {{ $tournament->prize->title }}</span></li> -->
                           <li><b>Tournament Type:</b> {{ $tournament->tournamenttype->title }}</li>
                           <!-- <li><b>State:</b> {{ $tournament->state->title }}, {{ $tournament->city }} </li> -->
                           <li class="text-success"><b>Payment Mode:</b> {{ $tournament->payment_mode }}</li>
                        </ul>
                     </div>
                     <div class="col-md-6">
                        <span>Contact Details: </span>
                        <ul class="tournaments-points">
                        <li><i class="fa-solid fa-headset"></i>  {{ $tournament->contact_person ?? 'N/A' }}</li>
                        <li><i class="fa-solid fa-envelope"></i> <a href="mailto:{{ $tournament->contact_email ?? '#' }}">{{ $tournament->contact_email ?? 'N/A' }}</a></li>
                        <li><i class="fa-solid fa-phone"></i> <a href="tel:{{ $tournament->contact_number ?? '#' }}">{{ $tournament->contact_number ?? 'N/A' }}</a></li>
                        </ul>
                     </div>
                  </div>
                  <hr>
                  <ul>
                     <li>🎯 Select Player(s) for the Tournament Registration</li>
                     <li class="custome-bold">💰 Entry Fee: <span class="text-success font-weight-bold">Rs.{{ $tournament->price ?? 'N/A' }}/- <span style="font-size: 10px;">( Gateway charges applicable )</span></span></li>
                  </ul>
                  @if ($errors->any())
                  @foreach ($errors->all() as $error)
                  <div style="color: red;font-size: 18px;text-align: center;">{{$error}}</div>
                  @endforeach
                  @endif
                  <form id="registration-form" action="{{ route('save.tournament.registration') }}" method="POST">
                     @csrf
                     <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">
                     <input type="hidden" name="admin_commission" value="{{ $tournament->admin_commission }}">
                     <input type="hidden" name="total_amount" value="{{ $tournament->price }}">
                     <input type="hidden" name="payment_mode" value="{{ $tournament->payment_mode }}">
                     <input type="hidden" name="online_amount" id="total-amount" value="0">
                     <div class="table-responsive">
                     <table class="table table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>DOB</th>
                              <th>Category</th>
                              <th>Rating</th>
                              <th>Gender</th>

                           </tr>
                        </thead>
                        <tbody>
                           @forelse ($players as $player)
                           <tr>
                              <td><input class="player-checkbox" type="checkbox" name="player_id[]"  value="{{ $player->id }}" data-price="{{ $tournament->price }}" data-player-id="{{ $player->id }}"></td>
                              <td>{{ $player->player_name }}</td>
                              <td>
                                    {{ \Carbon\Carbon::parse($player->dob)->format('d-m-Y') }} 
                                    ({{ \Carbon\Carbon::parse($player->dob)->age + 1 }} years)
                                </td>
                              <td>
                              <select name="category[]">
                                    <option>Select Category</option>
                                    @foreach($category as $data)
                                        @php
                                            // Extract the age limit from the category title
                                            $categoryAgeLimit = null;
                                            $categoryTitle = $data->title;

                                            if (preg_match('/U-(\d+)/', $categoryTitle, $matches)) {
                                                $categoryAgeLimit = (int) $matches[1];
                                            } elseif (strpos($categoryTitle, '+ Age') !== false) {
                                                $categoryAgeLimit = (int) filter_var($categoryTitle, FILTER_SANITIZE_NUMBER_INT);
                                            }

                                            // Get the player's age
                                            $playerAge = \Carbon\Carbon::parse($player->dob)->age;
                                        @endphp

                                        @if($categoryAgeLimit && $playerAge < $categoryAgeLimit)
                                            <option value="{{ $data->title }}">{{ $data->title }}</option>
                                        @elseif(!$categoryAgeLimit && strpos($categoryTitle, '+ Age') !== false && $playerAge >= $categoryAgeLimit)
                                            <option value="{{ $data->title }}" disabled>{{ $data->title }} (Not eligible)</option>
                                        @elseif($categoryAgeLimit && $playerAge >= $categoryAgeLimit)
                                            <option value="{{ $data->title }}" disabled>{{ $data->title }} (Not eligible)</option>
                                        @else
                                            <option value="{{ $data->title }}">{{ $data->title }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                    <span class="error-message" style="color: red; display: none;"></span>
                              </td>
                              <td>{{ $player->fide_rating }}</td>
                              <td>{{ $player->gender }}</td>
                           </tr>
                           @empty
                           <tr>
                              <td colspan="5" class="text-center">No Players Found</td>
                           </tr>
                           @endforelse
                        </tbody>
                     </table>
                    </div>
                     <div>
                        <div>
                         <div  class="my-2">
                         <a href="{{url('player-registration?tournament='.$tournament->slug)}}" class="custome-font-size">+ Add a New Player</a>
                        </div>
                         <div  class="my-2">
                         <a href="{{url('player-registration/view')}}" class="custome-font-size">* Edit Player</a>
                        </div>
                        <h5>Total Amount: Rs.<span id="total-amount-display">0</span> /-</h5>
                        <h5 class="d-none">Admin Commission ({{ $tournament->admin_commission }}%): Rs.<span id="admin-commission-display">0</span> /-</h5>
                     </div>
                     @php
                        $currentDate = \Carbon\Carbon::now();
                        $endDate = \Carbon\Carbon::parse($tournament->end_date);
                     @endphp
                     @if($currentDate->greaterThan($endDate))
                        <button type="button" class="btn btn-danger my-2" disabled>Registration Closed</button>
                     @else
                        <button type="submit" class="btn btn-success my-2">Submit Registration</button>
                     @endif
                  </form>
               </div>
            </div>
         </div>
         <!-- Related Tournaments -->
      </div>
   </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.player-checkbox');
    const totalAmountDisplay = document.getElementById('total-amount-display');
    const adminCommissionDisplay = document.getElementById('admin-commission-display');
    const totalAmountInput = document.getElementById('total-amount');
    const adminCommission = parseFloat('{{ $tournament->admin_commission }}'); // Admin commission percentage
    const totalPayableAmountDisplay = document.createElement('h5'); // New element for total payable amount
    let totalAmount = 0;

    // Add total payable amount to the DOM
    totalPayableAmountDisplay.textContent = "Total Payable Amount: Rs. 0 /-";
    totalPayableAmountDisplay.id = "total-payable-amount-display";
    adminCommissionDisplay.parentElement.appendChild(totalPayableAmountDisplay);

    // Function to update total, admin commission, and payable amounts
    function updateAmounts() {
        const adminCommissionAmount = (totalAmount * adminCommission) / 100;
        const totalPayableAmount = totalAmount + adminCommissionAmount;

        totalAmountDisplay.textContent = totalAmount.toFixed(2);
        adminCommissionDisplay.textContent = adminCommissionAmount.toFixed(2);
        totalPayableAmountDisplay.textContent = `Total Payable Amount: Rs. ${totalPayableAmount.toFixed(2)} /-`;
        totalAmountInput.value = totalPayableAmount.toFixed(2); // Set total payable amount in the hidden input
    }

    // Update the total amount and admin commission on checkbox change
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const price = parseFloat(checkbox.dataset.price);
            if (checkbox.checked) {
                totalAmount += price;
            } else {
                totalAmount -= price;
            }
            updateAmounts();
        });
    });

    // Add form submission validation
    const form = document.getElementById('registration-form');
    form.addEventListener('submit', function(event) {
        let isValid = true;

        // Check if category is selected for each player checkbox that is checked
        checkboxes.forEach((checkbox, index) => {
            const categorySelect = document.querySelectorAll('select[name="category[]"]')[index];
            const errorMessage = categorySelect.nextElementSibling; // Assuming the error message element is immediately after the select

            if (checkbox.checked) {
                if (!categorySelect || !categorySelect.value || categorySelect.value === 'Select Category') {
                    isValid = false;
                    categorySelect.style.borderColor = 'red';

                    // Show error message
                    if (errorMessage) {
                        errorMessage.textContent = 'Please select a category.';
                        errorMessage.style.display = 'block';
                    }
                } else {
                    categorySelect.style.borderColor = '';

                    // Hide error message
                    if (errorMessage) {
                        errorMessage.textContent = '';
                        errorMessage.style.display = 'none';
                    }
                }
            } else {
                // Hide error message if checkbox is not checked
                if (errorMessage) {
                    errorMessage.textContent = '';
                    errorMessage.style.display = 'none';
                }
            }
        });

        // If any validation fails, prevent form submission
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Initialize the display amounts on page load
    updateAmounts();
});
</script>
@endsection
