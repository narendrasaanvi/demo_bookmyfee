@extends('backend.layouts.master')
@section('title','Admin-Panel || Banner Create')
@section('main-content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <ol class="breadcrumb my-0 ms-2">
               <li class="breadcrumb-item"><a href="{{ URL::asset('admin/dashboard')}}"><i
                  class="fas fa-cubes"></i> Dashboard</a></li>
               <li class="breadcrumb-item active">
                  <span><i class="fas fa-file-alt"></i> tournament</span>
               </li>
            </ol>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item active">
                  <div id="clock"></div>
               </li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <div class="col-md-12">
            <div class="card card-primary">
               <div class="card-header">
                  <div class="d-flex justify-content-between">
                     <h4 class="card-title mb-0">Tournament</h4>
                     <div>
                        <a href="{{ route('tournament.create') }}" class="btn btn-success btn-sm"><i
                           class="fas fa-plus"></i> Add More</a>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  @if (session('status'))
                  <script type="text/javascript">
                     toastr.success('{{ session("status") }}')
                  </script>
                  @elseif(session('failed'))
                  <script type="text/javascript">
                     toastr.warning('{{ session("failed") }}')
                  </script>
                  @endif
                  <div id="example1_wrapper" class="tournamentTables_wrapper dt-bootstrap4">
                     <div class="row">
                        <div class="col-sm-12">
                           <table id="example1"
                              class="table table-bordered table-hover table-responsive-sm tournamentTable no-footer"
                              aria-describedby="example1_info">
                              <thead>
                                 <tr>
                                    <td><i class="fa fa-picture-o" aria-hidden="true"></i></td>
                                    <td>Tournament</td>
                                    <td>Price</td>
                                    <td>Category</td>
                                    <td>Participate List </td>
                                    <td>Action</td>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($tournaments as $tournament)
                                 <tr>
                                    <td><img src="{{url('uploads/tournament/'.$tournament->image)}}" alt=""
                                       style="width:45px"></td>
                                    <td><a href="{{url('tournament/'.$tournament->slug )}}" target="_blank">{{ $tournament->title }}</a></td>
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
                                    <td><a href="{{url('players-list/'.$tournament->id)}}"  target="_blank">View Player List</a></td>
                                    <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- Edit Tournament -->
                                            <a href="{{ route('tournament.edit', $tournament->id) }}" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a>

                                            <form id="deleteForm{{$tournament->id}}" method="POST" action="{{ route('tournament.destroy', [$tournament->id]) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="dropdown-item delete-btn" type="submit" data-id="{{$tournament->id}}">
                                                   <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                             </form>

                                            <!-- Download Player List -->
                                            <form method="GET" action="{{ route('export-player-list', [$tournament->id]) }}">
                                                @csrf
                                                <button class="dropdown-item" type="submit">
                                                    <i class="fas fa-download"></i> Download Player List
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>

                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                        <!-- /.card-body -->
                     </div>
                  </div>
               </div>
               <br>
            </div>
         </div>
      </div>
</section>
<!-- /.content -->
</div>
<script type="text/javascript">
   $('.all-tournament').addClass('active');
   $('.tournament').addClass('active');
</script>
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const tournamentId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this tournament?')) {
                document.getElementById(`deleteForm${tournamentId}`).submit();
            }
        });
    });
</script>
@endsection
