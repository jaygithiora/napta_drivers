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
            @if($user->hasRole('Driver'))
                @if(!$can_proceed)
                    <div class='row alert border-dark d-flex align-items-center bg-white'>
                        <div class='col-2 col-sm-1 text-right '>
                            <i class='fas fa-info-circle fa-3x'></i>
                        </div>
                        <div class='col-10 col-sm-8'>
                            Hi <b>{{$user->firstname}}</b>, Welcome to the driver Dashoard. <br>
                            <span class='bg-danger pt-1 pb-1 pe-2 ps-2 small' style='border-radius: 5px;'><i class='fas fa-exclamation-triangle'></i> &nbsp;Please complete your profile by uploading all documents for verification</span>
                            
                        </div>
                        <div class='col-12 col-sm-3 text-right'>
                            <a href='{{url("profile")}}' class='btn btn-danger btn-sm'><i class='fas fa-cloud-upload-alt'></i> Upload Documents</a>
                        </div>
                    </div>
                @endif
            @endif
            <!-- Small boxes (Stat box) -->
            <div class="row">
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
