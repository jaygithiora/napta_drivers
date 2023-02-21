@extends('layouts.app')

@section('content')
<div class="container-fluid main">
    <div class="row d-flex align-items-center dark">
        <div class="col-sm-12">
            <div class="container">
                <div class="col-md-6 pt-5 pb-5">
                    <h3>NAPTA <span class='text-warning'>Professional</span> Drivers</h3>
                    <p>Napta Professional Drivers is a subsidiary of the National Public Transport Alliance –Napta, 
                        a non-profit organization working to improve public transport through research, innovation, 
                        training, advocacy and investments.</p>
                    <a href='{{url("register?role=user")}}' class='btn btn-warning'><i class='fas fa-search'></i> Find a Driver</a>&nbsp;
                    <a href='{{url("register?role=driver")}}' class='btn btn-white'><i class='fas fa-user-plus'></i> Join as Driver</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class='container'>
    <div class='row pt-5 pb-5'>
        <div class='col-sm-12'>
            <h4><i class='fas fa-truck'></i> &nbsp;Vehicle Categories</h4>
        </div>
        @foreach($vehicle_types as $vehicle_type)
            <div class='col-sm-3 mt-3'>
                <div class='card border h-100'>
                    <div class='card-body'>
                        <h5><i class='fas fa-circle text-primary'></i> {{$vehicle_type->name}}</h5>
                        <span class='text-muted'><i class='fas fa-check-circle text-green'></i> 123 drivers</span>
                        <p>{{$vehicle_type->description}}</p>
                    </div>
                    <!--
                    <div class='card-footer bg-white border-0 text-center'>
                        <button class='btn btn-primary btn-sm w-100'><i class='fas fa-search'></i> Find Drivers</button>
                    </div>-->
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class='container-fluid bg-white'>
    <div class='container'>
        <div class='row pt-5 pb-5'>
            <div class='col-sm-12'>
                <h4><i class='fas fa-user'></i> &nbsp;Our Top Drivers</h4>
            </div>
            @foreach($drivers as $driver)
                <div class='col-sm-3 mt-3'>
                    <div class='card border h-100'>
                        <img src='{{asset("images/bg.jpg")}}' class='card-img-top '/>
                        <div class='card-body'>
                            <h5><i class='fas fa-circle text-primary small'></i> {{$driver->user->firstname}} {{$driver->user->lastname}}</h5>
                            <span class='text-muted'><i class='fas fa-check-circle text-green'></i> 123 Orders</span><br>
                            @foreach($vehicle_types as $vehicle_type)
                                <span class='badge bg-primary'>{{$vehicle_type->name}}</span>
                            @endforeach<br>
                            <i class='fas fa-star text-danger'></i><i class='fas fa-star text-danger'></i><i class='fas fa-star text-danger'></i>
                            <i class='fas fa-star text-danger'></i><i class='fas fa-star-half text-danger'></i>
                        </div>
                        <!--
                        <div class='card-footer bg-white border-0 text-center'>
                            <button class='btn btn-warning btn-sm w-100'><i class='fas fa-search'></i> Find Drivers</button>
                        </div>-->
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class='container-fluid'>
    <div class='container'>
        <div class='row pt-5 pb-5'>
            <div class='col-sm-12'>
                <h4><i class='fas fa-comments'></i> &nbsp;What our customers had to say</h4>
            </div>
            @foreach($drivers as $driver)
                <div class='col-sm-3 mt-3'>
                    <div class='card border h-100'>
                        <img src='{{asset("images/bg.jpg")}}' class='card-img-top '/>
                        <div class='card-body'>
                            <h5><i class='fas fa-circle text-primary small'></i> {{$driver->user->firstname}} {{$driver->user->lastname}}</h5>
                            <span class='text-muted'><i class='fas fa-check-circle text-green'></i> 123 Orders</span><br>
                            @foreach($vehicle_types as $vehicle_type)
                                <span class='badge bg-primary'>{{$vehicle_type->name}}</span>
                            @endforeach<br>
                            <i class='fas fa-star text-danger'></i><i class='fas fa-star text-danger'></i><i class='fas fa-star text-danger'></i>
                            <i class='fas fa-star text-danger'></i><i class='fas fa-star-half text-danger'></i>
                        </div>
                        <!--
                        <div class='card-footer bg-white border-0 text-center'>
                            <button class='btn btn-warning btn-sm w-100'><i class='fas fa-search'></i> Find Drivers</button>
                        </div>-->
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        var header = $(".navbar");
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();

            if (scroll >= 30) {
                header.addClass('bg-light');
                header.removeClass('navbar-dark');
                header.addClass('navbar-light');
                header.addClass('shadow-sm');
            } else {
                header.removeClass('bg-light');
                header.addClass('navbar-dark');
                header.removeClass('navbar-light');
                header.removeClass('shadow-sm');
            }
        });
    });
</script>
@endpush