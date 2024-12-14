@extends('backend.layouts.master')
@section('title','Admin-Panel || Banner Create')
@section('main-content')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0"><a href="{{ URL::asset('admin/dashboard')}}" class="dashbord">Dashboard</a></h1>
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
         <div class="card mb-4 ">
            <div class="card-body">
               <div class="d-flex justify-content-between">
                     <h4 class="card-title mb-0">
                        Welcome {{Auth::user()->name}} to Bookmyfee Dashboard.
                     </h4>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-3 col-6">
               <div class="small-box bg-info">
                  <div class="inner">
                     <h3>{{$tournament}}</h3>
                     <p>Total Live Tournaments</p>
                  </div>
                  <div class="icon">
                     <i class="ion ion-map"></i>
                  </div>
                  <a href="{{ URL::asset('admin/tournament')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
               </div>
            </div>
            <div class="col-lg-3 col-6">
               <div class="small-box bg-warning">
                  <div class="inner">
                     <h3>{{$players}}</h3>
                     <p>Total Players</p>
                  </div>
                  <div class="icon">
                     <i class="ion ion-person-add"></i>
                  </div>
                  <a href="{{ URL::asset('admin/players')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
               </div>
            </div>
            <div class="col-lg-3 col-6">
               <div class="small-box bg-success">
                  <div class="inner">
                     <h3>{{$organizer}}</h3>
                     <p>Total Organizer</p>
                  </div>
                  <div class="icon">
                     <i class="ion ion-person-add"></i>
                  </div>
                  <a href="{{ URL::asset('admin/subscriber')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
               </div>
            </div>
            <div class="col-lg-3 col-6">
               <div class="small-box bg-danger">
                  <div class="inner">
                     <h3>{{$user}}</h3>
                     <p>Total Users</p>
                  </div>
                  <div class="icon">
                     <i class="ion ion-person-add"></i>
                  </div>
                  <a href="{{ URL::asset('admin/users')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
               </div>
            </div>
            <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tournament Chart</h3>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="height: 250px; width: 100%;"></canvas>
                </div>
            </div>
            </div>
         </div>
      </div>
   </section>
   <!-- /.content -->
</div>
<script type="text/javascript">
   $('.dashboard').addClass('active');
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    $.ajax({
        url: '/api/sales-data', // Replace with your API route
        method: 'GET',
        success: function (response) {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.months, // ['January', 'February', ...]
                    datasets: [
                        {
                            label: 'Tournaments Count',
                            data: response.tournaments_count, // [10, 15, ...]
                            backgroundColor: 'rgba(60,141,188,0.4)',
                            borderColor: 'rgba(60,141,188,1)',
                            borderWidth: 1,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Tournaments Count'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Months'
                            }
                        }
                    }
                }
            });
        },
        error: function (error) {
            console.error("Error fetching sales data:", error);
        }
    });
});
</script>



@endsection
