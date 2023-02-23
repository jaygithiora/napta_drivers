@extends('layouts.account')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class='fas fa-tachometer-alt'></i> Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                @if($driver != null)
                    @if(!$driver->status)
                        <div class='alert border border-warning bg-white'>
                            <i class='fas fa-exclamation-circle'></i> Hi <b>{{ $driver->user->firstname }}</b>. Welcome to <b>{{ config('app.name', 'Laravel') }}</b>. You profile is under review and you're start getting clients once your profile is approved
                        </div>
                    @endif
                    @if($driver->suspended)
                        <div class='alert border border-danger bg-white'>
                            <i class='fas fa-exclamation-circle'></i> Hi <b>{{ $driver->user->firstname }}</b>. Your account has been <b class='text-danger'>suspended</b> for non-compliance. If you'd wish to lodge a contestation <a href='#' class='btn btn-danger btn-sm'><span class='text-white'>click here</span></a>
                        </div>
                    @endif
                @endif
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box small-box1">
                        <div class="inner">
                            <h3>150</h3>

                            <p>Driver Requests</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box small-box2">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>

                            <p>Drivers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box small-box3">
                        <div class="inner">
                            <h3>44</h3>

                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box small-box4">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Vehicles</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
