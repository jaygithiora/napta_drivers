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
                    <div class='col-sm-4 form-group mb-1'>
                        <select class='form-control' name='vehicle_types[]'  id='vehicle_types'></select>
                    </div>
                    <div class='col-sm-4 form-group mb-1'>
                        <button class='btn btn-primary btn-sm w-100'><i class='fas fa-search'></i> Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class='container-fluid' style='min-height: 80vh;'>
    <div class='container'>
        <div class='row table-data pt-5 pb-5'>
            @include('includes/drivers_data')
        </div>
        
        <div class='row'>
            <div class='col-sm-12 feedback'>
                <div class='alert text-muted text-center loading'>
                    <i class='fas fa-spinner fa-pulse fa-3x'></i><br>
                    <b>Loading...</b>
                </div>
            </div>
            <!--<div class='col-sm-12'>
                <h4><i class='fas fa-user'></i> &nbsp;Our Top Drivers</h4>
            </div>
            <div class='col-sm-12 d-flex align-items-center pages'></div>-->
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        $('.feedback').addClass('d-none');
        $('.pagination').addClass('justify-content-center');
        var header = $(".navbar");
        header.addClass('bg-primary');
        header.removeClass('navbar-dark');
        header.addClass('navbar-dark');
        header.addClass('shadow-sm');

        $('#vehicle_types').select2({
            width: '100%',
            placeholder: 'Choose Vehicle Types',
            //dropdownParent: $('#vehicleTypeModal'),
            allowClear: true,
            ajax: {
                url: '{{url("index/search/vehicle_types")}}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $(document).on('click', '.pagination a', function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            getDrivers(page);
        });
        //getDrivers();
        function getDrivers(page){
            $('.feedback').removeClass('d-none');
            var form = $('.search-form').serialize();
            $.ajax({
                url: '{{url("get/drivers")}}?page='+page,
                type: "GET",
                data: form,
            }).done(function(data){
                $('.feedback').addClass('d-none');
                //alert(data);
                $('.table-data').html(data);
                $('.pagination').addClass('justify-content-center');
            }).fail(function(data){
                //alert('error');
                $('.feedback').addClass('d-none');
            });
        }
        $('.search-form').submit(function(e){
            e.preventDefault();
            getDrivers(1);
        });
        //header.removeClass('fixed-top');
    });
</script>
@endpush