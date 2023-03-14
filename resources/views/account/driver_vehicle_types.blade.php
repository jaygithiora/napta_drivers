@extends('layouts.account')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"><i class='fas fa-truck'></i> My Vehicle Types</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">My Vehicle Types</li>
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
            <div class="col-md-12 mb-3">

                <!-- small box -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-end">
                            <button class="btn btn-primary btn-sm btn-launch-modal" data-bs-toggle="modal" data-bs-target="#vehicleTypeModal"><i
                                    class='fas fa-plus'></i> Add Vehicle Type</button>
                        </div>
                        <div class="table-responsive">
                            <table class='table w-100'>
                                <thead>
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class='text-end'>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ./col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Profile Modal -->
<div class="modal fade" id="vehicleTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-plus'></i> <span>Select Vehicle Types for your profile</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('settings/driver/vehicle_types/add') }}">
                    @csrf
                    <input type='hidden' name='id' value='0'>
                    <input type='hidden' name='driver_id' value='{{$driver->id}}'>
                    
                    <div class='form-group'>
                        <label>Status</label>
                        <select name="vehicle_types[]" class='form-control' id='vehicle_types' multiple="multiple">
                        </select>
                    </div>
                    <div class='alert feedback border d-none'>
                        <i class='fas fa-spinner fa-pulse'></i> Saving... Please wait
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i
                        class='fas fa-times'></i> Close</button>
                <button type="button" class="btn btn-primary btn-sm btnSave"><i class='fas fa-paper-plane'></i> Save
                    changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        $('#vehicle_types').select2({
            width: '100%',
            placeholder: 'Select',
            dropdownParent: $('#vehicleTypeModal'),
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
        var table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('settings/driver/datatable/vehicle_types') }}",
            dom: 'lBtrip', //'lfBtrip'
            columns: [
                //{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'vehicle_type.name', name: 'vehicle_type.name' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });
        
        $('#vehicleTypeModal .btnSave').click(function () {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('#vehicleTypeModal .feedback').removeClass('d-none');
            $('#vehicleTypeModal .feedback').removeClass('alert-danger');
            $('#vehicleTypeModal .feedback').removeClass('alert-success');
            $('#vehicleTypeModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
            var formData = $('#vehicleTypeModal form').serialize();
            $.ajax({
                url: '{{ url("settings/driver/vehicle_types/add") }}',
                type: 'POST',
                data: formData
            }).done(function (data) {
                $('#vehicleTypeModal .feedback').addClass('alert-success');
                $('#vehicleTypeModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.success);
                table.draw();
                setTimeout(() => {
                    $('#vehicleTypeModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            }).fail(function (response) {
                let data = response.responseJSON;
                $('#vehicleTypeModal .feedback').addClass('alert-danger');
                $('#vehicleTypeModal .feedback').html("");
                if (data.errors) {
                    if (data.errors.id) {
                        $('#vehicleTypeModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.id + "<br>");
                    }
                    if (data.errors.driver_id) {
                        $('#vehicleTypeModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.driver_id + "<br>");
                    }
                    if (data.errors.vehicle_types) {
                        $('#vehicleTypeModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.vehicle_types + "<br>");
                    }
                } else if (data.error) {
                    $('#vehicleTypeModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.error);
                } else {
                    $('#vehicleTypeModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                }
                setTimeout(() => {
                    $('#vehicleTypeModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            });
        });
    });
</script>
@endpush