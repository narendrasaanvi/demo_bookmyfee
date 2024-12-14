@extends('frontend.layouts.master')
@section('title', 'Welcome')
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
    .list-group-item.active {
        z-index: 2;
        color: #fff;
        background-color: #7f6cfd;
        border-color: #7f6cfd;
    }
    table {
        border: 1px solid #ddd;
        width: 100%;
    }
    table thead th {
        border-bottom: 1px solid #ddd;
    }
    table tbody td {
        border-bottom: 1px solid #ddd;
    }
    a {
        text-decoration: none!important;
        color: #000;
    }
    .download-btn {
        margin-bottom: 20px;
        padding: 10px 15px;
        background-color: #7f6cfd;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    td {
    text-transform: capitalize;
}
</style>

<section class="header-padding">
    <div class="p-3">
        <!-- Category Section -->
        <div class="row">
        <div class="col-md-12">
            @if(auth()->check() && auth()->user()->role != 'admin')
                @include('frontend.tournament.side-menu')
            @endif
        </div>
            <div class="col-md-12 card">
                <div class="table-responsive">
                    <p class="text-primary pt-3">Tournament: {{$tournament->title}}</p>
                    <p class="text-primary">Date: {{$tournament->start_date}}</p>
                    <table id="gender-category-total-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Gender</th>
                            <th>Category</th>
                            <th>Total Players</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Group players by gender and category
                            $groupedData = $playerlists->groupBy(function($playerlist) {
                                return $playerlist->player->gender . '-' . $playerlist->category;
                            });
                        @endphp

                        @foreach($groupedData as $key => $players)
                            @php
                                // Split the gender-category key back into gender and category
                                list($gender, $category) = explode('-', $key);
                            @endphp
                            <tr>
                                <td>{{ $gender }}</td>
                                <td>{{ $category }}</td>
                                <td>{{ count($players) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                    <br><hr>
                    <table id="player-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Player Name</th>
                                <th>Pay Status</th>
                                <th>Gender</th>
                                <th>Category</th>
                                <th>Fide Id</th>
                                <th>Rating</th>
                                <th>Date of Birth</th>
                                <th>Enter Fee</th>
                                <th>Payment</th>
                                <th>Payment Date</th>
                                <th>District</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>State Membership</th>
                                <th> AICE ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($playerlists as $playerlist)
                            <tr>
                                <td>{{ $playerlist->player->player_name }}</td>
                                <td>
                                    @if($playerlist->payment)
                                        {{ $playerlist->payment->payment_status }}
                                    @else
                                        Not Paid
                                    @endif
                                </td>
                                <td>{{ $playerlist->player->gender }}</td>
                                <td>{{ $playerlist->category }}</td>
                                <td>{{ $playerlist->player->fide_id }}</td>
                                <td>{{ $playerlist->player->fide_rating }}</td>
                                <td>{{ \Carbon\Carbon::parse($playerlist->player->dob)->format('d-m-Y') }}</td>
                                <td>{{ $playerlist->tournament->price }}</td>
                                <td>{{ $playerlist->tournament->payment_mode }}</td>
                                <td>
                                    @if($playerlist->payment && $playerlist->payment->created_at)
                                        {{ \Carbon\Carbon::parse($playerlist->payment->payment_date)->format('d-m-Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $playerlist->player->district }}</td>
                                <td>{{ $playerlist->player->mobile_1 }}</td>
                                <td>{{ $playerlist->player->email }}</td>
                                <td>{{ $playerlist->player->state_membership_id }}</td>
                                <td>{{ $playerlist->player->aicf_id }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="download-btn" onclick="downloadCSV()">Download Excel</button>
                    <br>


                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function downloadCSV() {
        const table = document.getElementById('player-table');
        let csvContent = "Player Name,Pay Status,Gender,Category,Fide Id,Rating,Date of Birth,Enter Fee,Payment,Payment Date,District,Contact,Email,State Membership,AICE ID\n";

        for (let i = 1; i < table.rows.length; i++) {
            let row = table.rows[i];
            let rowData = [];
            for (let j = 0; j < row.cells.length; j++) {
                rowData.push(row.cells[j].innerText);
            }
            csvContent += rowData.join(",") + "\n";
        }

        const tournamentTitle = '{{ $tournament->title }}'.replace(/\s+/g, '_'); // Replace spaces with underscores
        const filename = tournamentTitle + '.csv'; // Set filename to tournament title with .csv extension

        const encodedUri = encodeURI("data:text/csv;charset=utf-8," + csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", filename); // Use dynamic filename based on tournament title
        document.body.appendChild(link);
        link.click();
    }
</script>

@endsection
