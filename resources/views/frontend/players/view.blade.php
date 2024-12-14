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
        color: var(--bs-list-group-active-color);
        background-color: #7f6cfd;
        border-color: #7f6cfd;
    }
    table.dataTable {
        border: 1px solid #ddd;
    }
    table.dataTable thead th {
        border-bottom: 1px solid #ddd;
    }
    table.dataTable tbody td {
        border-bottom: 1px solid #ddd;
    }
    a {
        text-decoration: none!important;
        color: #000;
    }
    .list-group-item.active {
        z-index: 2;
        color: var(--bs-list-group-active-color);
        background-color: #7f6cfd;
        border-color: #7f6cfd;
    }
</style>


<section class="header-padding">
    <div class="container py-3">
        <!-- Category Section -->
        <div class="row">
            <div class="col-md-12">
                @include('frontend.players.side-menu')
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Player Name</th>
                                <th>Date of Birth</th>
                                <th>Gender</th>
                                <th>Contact</th>
                                <th>FIDE Rating</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($players as $player)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $player->player_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($player->dob)->format('d-m-Y') }}</td>
                                    <td>{{ $player->gender }}</td>
                                    <td>Mobile:{{ $player->mobile_1 }}<br>Email:{{ $player->email }}</td>
                                    <td>{{ $player->fide_rating }}</td>
                                    <td>
                                    <a href="{{route('player.registration.destroy', $player->id)}}" class="delete-player">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </a>

                                        <a href="{{route('player.registration.edit',$player->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Users Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

<script>
        $('body').on('click', '.delete-player', function (e) {
            e.preventDefault(); // Prevent default action
            let url = $(this).attr('href'); // Get the delete URL
            let playerName = $(this).closest('tr').find('td:nth-child(2)').text(); // Get the player name from the row

            Swal.fire({
                title: 'Are you sure?',
                text: `This action will delete the player "${playerName}" and cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url; // Proceed with the deletion
                }
            });
        });
</script>

@endsection
