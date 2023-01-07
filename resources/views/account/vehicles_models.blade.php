@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"><i class='fas fa-cog'></i> Vehicle Models</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
       <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Vehicle Models</li>
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
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modelModal"><i
                                    class='fas fa-plus'></i> Add Model</button>
                        </div>
                        <div class="table-responsive">
                            <table class='table w-100'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Make</th>
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
<div class="modal fade" id="modelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-plus'></i> New Model</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('vehicles/model/add') }}">
                    @csrf
                    <input type='hidden' name='id' value='0'>
                    <div class='form-group'>
                        <label>Vehicle Model</label>
                        <input type='text' placeholder="Vehicle Model" name="name" class='form-control' autofocus
                            required />
                    </div>
                    <div class='form-group'>
                        <label>Vehicle Make</label>
                        <select name="vehicle_make_id" class='form-control' id='vehicle_make'>
                            <option></option>
                        </select>
                    </div>
                    <div class='form-group'>
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
            ajax: "{{ url('datatable/vehicles/models') }}",
            dom: 'lBtrip', //'lfBtrip'
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'make', name: 'make' },
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
        $('#vehicle_make').select2({
            width: '100%',
            placeholder: 'Select',
            dropdownParent: $('#modelModal'),
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
        $('#modelModal .btnSave').click(function () {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('#modelModal .feedback').removeClass('d-none');
            $('#modelModal .feedback').removeClass('alert-danger');
            $('#modelModal .feedback').removeClass('alert-success');
            $('#modelModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
            var formData = $('#modelModal form').serialize();
            $.ajax({
                url: '{{ url("vehicles/model/add") }}',
                type: 'POST',
                data: formData
            }).done(function (data) {
                $('#modelModal .feedback').addClass('alert-success');
                $('#modelModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.success);
                table.draw();
                setTimeout(() => {
                    $('#modelModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            }).fail(function (response) {
                let data = response.responseJSON;
                $('#modelModal .feedback').addClass('alert-danger');
                $('#modelModal .feedback').html("");
                if (data.errors) {
                    if (data.errors.name) {
                        $('#modelModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.name + "<br>");
                    }
                    if (data.errors.email) {
                        $('#modelModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.email + "<br>");
                    }
                    if (data.errors.password) {
                        $('#modelModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.password + "<br>");
                    }
                    if (data.errors.confirm_password) {
                        $('#modelModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.confirm_password + "<br>");
                    }
                } else if (data.error) {
                    $('#modelModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.error);
                } else {
                    $('#modelModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                }
                setTimeout(() => {
                    $('#modelModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            });
        });
    });
</script>
@endpush