@extends('layouts.app')

@section('content')
<div class="container-fluid bg-white">
    <div class='container'>
        <div class='row pt-5 pb-5 mt-5'>
            <div class='col-sm-12 mt-2'>
                <h4><i class='fas fa-search'></i> &nbsp;Browse Drivers</h4>
                <form class='search-form row d-flex align-items-center'>
                    <div class='col-sm-4 form-group mb-1'>
                        <input type='text' name='search' class='form-control' placeholder='Search Driver Name'>
                    </div>
                    <div class='col-sm-3 form-group mb-1'>
                        <input type='text' name='search' class='form-control' placeholder='Vehicle Type'>
                    </div>
                    <div class='col-sm-3 form-group mb-1'>
                        <input type='text' name='search' class='form-control' placeholder='Location'>
                    </div>
                    <div class='col-sm-2 form-group mb-1'>
                        <button class='btn btn-primary btn-sm w-100'><i class='fas fa-search'></i> Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class='container-fluid' style='min-height: 80vh;'>
    <div class='container'>
        <div class='row pt-5 pb-5'>
            
            <div class='col-sm-12 drivers'>
                
            </div>
            <div class='col-sm-12'>
                <div class='alert text-muted text-center loading'>
                    <i class='fas fa-spinner fa-pulse fa-3x'></i><br>
                    <b>Loading...</b>
                </div>
            </div>
            <!--<div class='col-sm-12'>
                <h4><i class='fas fa-user'></i> &nbsp;Our Top Drivers</h4>
            </div>-->
            <div class='col-sm-12 d-flex align-items-center pages'></div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        var header = $(".navbar");
        header.addClass('bg-primary');
        header.removeClass('navbar-dark');
        header.addClass('navbar-dark');
        header.addClass('shadow-sm');
        getDrivers();
        function getDrivers(){
            var form = $('.search-form').serialize();
            $.ajax({
                url: '{{url("get/drivers")}}',
                type: "GET",
                data: form,
            }).done(function(data){
                
                $('.pages').html(data.links);
            }).fail(function(data){
                alert('rerr');
            });
        }
        //header.removeClass('fixed-top');
    });
</script>
@endpush