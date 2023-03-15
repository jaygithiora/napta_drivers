@extends('layouts.account')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header" >
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"><i class='fas fa-truck'></i> View Vehicle Type</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Vehicle Types</li>
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
                <div class="card card-primary card-outline h-100">
                    <div class="card-body box-profile">
                        <div class='row'>
                            <div class='col-4 border-right h-100 p-3'>
                                <img src='{{$vehicleType->image != null?asset("images/vehicle_types/".$vehicleType->image):asset("images/electric_car.svg")}}'  class='img-fluid'/>
                            </div>
                            <div class='col-8 h-100 p-3'>
                                <div class='row'>
                                    <div class='col'>
                                        <h5>{{$vehicleType->name}}</h5>
                                        {!! $vehicleType->status?"<span class='badge bg-primary badge-pill'>Active</span>":"<span class='badge bg-secondary badge-pill'>In-Active</span>"!!}
                                    </div>
                                    <div class='col'>
                                        <div class='text-right'>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#vehicleTypeModal"><i
                                            class='fas fa-edit'></i> Edit</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                {!!$vehicleType->description!!}
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
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-truck'></i> <span>New Vehicle Type</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('settings/vehicle_type/add') }}" class="row" enctype="multipart/form-data">
                    @csrf
                    <input type='hidden' name='id' value='{{$vehicleType->id}}'>
                    <div class='form-group'>
                        <label>Name</label>
                        <input type='text' placeholder="Name" name="name" class='form-control' autofocus
                            required value='{{$vehicleType->name}}'/>
                    </div>
                    <div class='form-group'>
                        <label>Description</label>
                        <textarea placeholder="Description" name="description" class='form-control'
                            required >{{$vehicleType->description}}</textarea>
                    </div>
                    <div class='form-group'>
                        <label>Banner</label>
                        <input type="file" name="image" id="inputImage" class="form-control">
                    </div>
                    <div class='form-group'>
                        <label>Status</label>
                        <select name="status" class='form-control'>
                            <option disabled>Status</option>
                            <option value='1' {{$vehicleType->status?'selected':''}}>Active</option>
                            <option value='0' {{$vehicleType->status == 0?'selected':''}}>In-Active</option>
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
        
        $('.btn-launch-modal').click(function(){
            $('#vehicleTypeModal .modal-title span').text("New Vehicle type");
            $('#vehicleTypeModal input[name=id]').val(0);
            $('#vehicleTypeModal textarea[name=description]').val("");
            $('#vehicleTypeModal input[name=name]').val("");
            $('#vehicleTypeModal select[name=status]').val(1);
        });
        
        $('#vehicleTypeModal .btnSave').click(function () {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('#vehicleTypeModal .feedback').removeClass('d-none');
            $('#vehicleTypeModal .feedback').removeClass('alert-danger');
            $('#vehicleTypeModal .feedback').removeClass('alert-success');
            $('#vehicleTypeModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
            
            var form = $('#vehicleTypeModal form')[0];
            var formData = new FormData(form)
            $.ajax({
                url: '{{ url("settings/vehicle_type/add") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
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
                    if (data.errors.name) {
                        $('#vehicleTypeModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.name + "<br>");
                    }
                    if (data.errors.description) {
                        $('#vehicleTypeModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.description + "<br>");
                    }
                    if (data.errors.status) {
                        $('#vehicleTypeModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.status + "<br>");
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
        $(document).on('click', '.table .btn-edit', function(){
            $('#vehicleTypeModal .modal-title span').text("Edit Vehicle Type");
            var row = $(this).closest('tr');
            var id = row.find('.id').text();
            var name = row.find('.name').text();
            var description = row.find('.description').text();
            var status = row.find('.status').text();

            $('#vehicleTypeModal input[name=id]').val(id);
            $('#vehicleTypeModal input[name=name]').val(name);
            $('#vehicleTypeModal textarea[name=description]').val(description);
            $('#vehicleTypeModal select[name=status]').val(status);
        });
    });
</script>
@endpush