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
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<section class="header-padding">
    <div class="container py-3">
        <!-- Category Section -->
        <div class="row">
            <div class="col-md-12">
                @include('frontend.tournament.side-menu')
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                <table id="example1"
                              class="table table-bordered table-hover table-responsive-sm tournamentTable no-footer"
                              aria-describedby="example1_info">
                              <thead>
                                 <tr>
                                    <td>Image</td>
                                    <td>Tournament</td>
                                    <td>Price</td>
                                    <td>Category</td>
                                    <td>Participate List </td>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($tournaments as $tournament)
                                 <tr>
                                    <td><img src="{{url('uploads/tournament/'.$tournament->image)}}" alt=""
                                       style="width:45px"></td>
                                    <td>{{ $tournament->title }}</td>
                                    <td>{{ $tournament->price }}</td>
                                    <td>
                                            @foreach(explode(',', $tournament->category_id) as $categoryId)
                                                @php
                                                    $category = \App\Models\Category::find($categoryId);
                                                @endphp
                                                @if($category)
                                                    <span>{{ $category->title }}</span>{{ !$loop->last ? ',' : '' }}
                                                @endif
                                            @endforeach
                                    </td>
                                    <td><a href="{{route('players.list',$tournament->id)}}">View Player List</a></td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- DataTables Bootstrap 5 JS -->
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            language: {
                paginate: {
                    previous: "Previous",
                    next: "Next"
                },
                search: "Search Players:"
            },
            lengthMenu: [5, 10, 25, 50] // Options for number of rows to display
        });
    });
</script>

@endsection
