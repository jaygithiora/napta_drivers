@extends('layouts.account')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"><i class='fas fa-truck'></i> Vehicles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
       <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Vehicles</li>
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
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#vehicleModal"><i
                                    class='fas fa-plus'></i> Add Vehicle</button>
                        </div>
                        <div class="table-responsive">
                            <table class='table w-100'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Make</th>
                                        <th>Model</th>
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
<div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-plus'></i> New Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('vehicles/add') }}" class="row">
                    @csrf
                    <input type='hidden' name='id' value='0'>
                    <div class='col-sm-6 form-group'>
                        <label>Number Plate</label>
                        <input type='text' placeholder="Number Plate" name="plate" class='form-control' autofocus
                            required />
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Vehicle Make</label>
                        <select name="vehicle_make" id='vehicle_make' class='form-control'>
                        </select>
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Vehicle Model</label>
                        <select name="vehicle_model" id='vehicle_model' class='form-control'>
                        </select>
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Country</label>
                        <select name="country" id='countries' class='form-control'>
                        </select>
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Engine Number</label>
                        <input type='text' placeholder="Engine Number" name="engine_number"
                            class='form-control' required />
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Chasis Number</label>
                        <input type='text' placeholder="Chasis Number" name="chasis_number"
                            class='form-control' required />
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Registration Date</label>
                        <input type='date' placeholder="Confirm Password" name="registration_date"
                            class='form-control' required />
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Expiry Date</label>
                        <input type='date' placeholder="Confirm Password" name="expiry_date"
                            class='form-control' required />
                    </div>
                    <div class='col-sm-12 form-group'>
                        <label>Status</label>
                        <select name="status" class='form-control'>
                            <option disabled>Select Status</option>
                            <option value='1'>Active</option>
                            <option value='0'>In-Active</option>
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
        var table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('datatable/vehicles') }}",
            dom: 'lBtrip', //'lfBtrip'
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'plate', name: 'plate' },
                { data: 'make', name: 'make' },
                { data: 'model', name: 'model' },
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
        var vehicle_make = 0;
        $('#vehicle_make').select2({
            width: '100%',
            placeholder: 'Select',
            dropdownParent: $('#vehicleModal'),
            allowClear: true,
            ajax: {
                url: '{{url("search/vehicles/make")}}',
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
        $('#vehicle_model').select2({
            width: '100%',
            placeholder: 'Select',
            dropdownParent: $('#vehicleModal'),
            allowClear: true,
        });
        $('#vehicle_make').change(function() {
            $('#vehicle_model').select2({
                width: '100%',
                placeholder: 'Select',
                dropdownParent: $('#vehicleModal'),
                allowClear: true,
                ajax: {
                    url: '{{url("search/vehicles/model")}}?vehicle_make_id='+$('#vehicle_make').val(),
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
        });
        
        $('#countries').select2({
            width: '100%',
            placeholder: 'Select',
            dropdownParent: $('#vehicleModal'),
            allowClear: true,
            ajax: {
                url: '{{url("search/countries")}}',
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
        
        $('#vehicleModal .btnSave').click(function () {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('#vehicleModal .feedback').removeClass('d-none');
            $('#vehicleModal .feedback').removeClass('alert-danger');
            $('#vehicleModal .feedback').removeClass('alert-success');
            $('#vehicleModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
            var formData = $('#vehicleModal form').serialize();
            $.ajax({
                url: '{{ url("vehicles/add") }}',
                type: 'POST',
                data: formData
            }).done(function (data) {
                $('#vehicleModal .feedback').addClass('alert-success');
                $('#vehicleModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.success);
                table.draw();
                setTimeout(() => {
                    $('#vehicleModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            }).fail(function (response) {
                let data = response.responseJSON;
                $('#vehicleModal .feedback').addClass('alert-danger');
                $('#vehicleModal .feedback').html("");
                if (data.errors) {
                    if (data.errors.plate) {
                        $('#vehicleModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.plate + "<br>");
                    }
                    if (data.errors.engine_number) {
                        $('#vehicleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.engine_number + "<br>");
                    }
                    if (data.errors.chasis_number) {
                        $('#vehicleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.chasis_number + "<br>");
                    }
                    if (data.errors.registration_date) {
                        $('#vehicleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.registration_date + "<br>");
                    }
                    if (data.errors.expiry_date) {
                        $('#vehicleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.expiry_date + "<br>");
                    }
                    if (data.errors.vehicle_make) {
                        $('#vehicleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.vehicle_make + "<br>");
                    }
                    if (data.errors.vehicle_model) {
                        $('#vehicleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.vehicle_model + "<br>");
                    }
                    if (data.errors.country) {
                        $('#vehicleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.country + "<br>");
                    }
                    if (data.errors.status) {
                        $('#vehicleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.status + "<br>");
                    }
                } else if (data.error) {
                    $('#vehicleModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.error);
                } else {
                    $('#vehicleModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                }
                setTimeout(() => {
                    $('#vehicleModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            });
        });
    });
</script>
@endpush