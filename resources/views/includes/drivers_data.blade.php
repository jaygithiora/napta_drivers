@foreach($drivers as $driver)
    <div class='col-sm-6'>
        <a href=''>
            <div class='alert bg-white border'>
                <div class='row'>
                    <div class='col-sm-4 col-md-3'>
                        <img src='{{$driver->user->image != ""?asset("images/profiles/".$driver->user->image):asset("images/male_avatar.svg")}}' class='img-fluid rounded shadow-sm bg-white'/>
                    </div>
                    <div class='col-sm-8 col-md-9'>
                        <span style='font-size:1.3em;'><b><!--<i class='fas fa-circle text-primary small'></i>--> {{$driver->user->firstname}} {{$driver->user->lastname}}</b></span><br>
                        <!--<span class='text-muted'><i class='fas fa-check-circle text-green'></i> 123 Orders</span><br>-->
                        Joined: {{\Carbon\Carbon::parse($driver->created_at)->diffForHumans()}} <span class='badge bg-primary'>{{$driver->user->country->name}}</span><br>
                        @foreach($driver->vehicle_types as $vehicle_type)
                            <span class='badge border text-success border-success'><!--<i class='fas fa-check-circle text-green'></i>--> {{$vehicle_type->vehicle_type->name}}</span>
                        @endforeach
                        <br>
                        {{$driver->description}}
                        <i class='fas fa-star text-danger small'></i><i class='fas fa-star text-danger small'></i><i class='fas fa-star text-danger small'></i>
                        <i class='fas fa-star text-danger small'></i><i class='fas fa-star-half text-danger small'></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach
@if($drivers->count() == 0)   
<div class='col-sm-12 text-center'>
    <div class='alert border-secondary'>
        <i class='fas fa-ban'></i> No results found
    </div>
</div>
@endif
<div class='col-sm-12 text-center'>
    {!! $drivers->links() !!}
</div>