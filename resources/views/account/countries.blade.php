@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"><i class='fas fa-globe'></i> Countries</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Countries</li>
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
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#countryModal"><i
                                    class='fas fa-plus'></i> Add Country</button>
                        </div>
                        <div class="table-responsive">
                            <table class='table w-100'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Country Code</th>
                                        <th>Phone Code</th>
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
<div class="modal fade" id="countryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-plus'></i> New Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('countries/add') }}">
                    @csrf
                    <input type='hidden' name='id' value='0'>
                    <div class='form-group'>
                        <label>Country Name</label>
                        <input type='text' placeholder="Country Name" name="name" class='form-control' autofocus
                            required />
                    </div>
                    <div class='form-group'>
                        <label>Country Code</label>
                        <input type='text' name="country_code" class='form-control' placeholder='Country Code' required>
                    </div>
                    <div class='form-group'>
                        <label>Phone Code</label>
                        <input type='text' name="phone_code" class='form-control' placeholder='Phone Code' required>
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
            ajax: "{{ url('datatable/countries') }}",
            dom: 'lBtrip', //'lfBtrip'
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'country_code', name: 'country_code' },
                { data: 'phone_code', name: 'phone_code' },
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
        
        $('#countryModal .btnSave').click(function () {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('#countryModal .feedback').removeClass('d-none');
            $('#countryModal .feedback').removeClass('alert-danger');
            $('#countryModal .feedback').removeClass('alert-success');
            $('#countryModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
            var formData = $('#countryModal form').serialize();
            $.ajax({
                url: '{{ url("countries/add") }}',
                type: 'POST',
                data: formData
            }).done(function (data) {
                $('#countryModal .feedback').addClass('alert-success');
                $('#countryModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.success);
                table.draw();
                setTimeout(() => {
                    $('#countryModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            }).fail(function (response) {
                let data = response.responseJSON;
                $('#countryModal .feedback').addClass('alert-danger');
                $('#countryModal .feedback').html("");
                if (data.errors) {
                    if (data.errors.name) {
                        $('#countryModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.name + "<br>");
                    }
                    if (data.errors.email) {
                        $('#countryModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.email + "<br>");
                    }
                    if (data.errors.password) {
                        $('#countryModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.password + "<br>");
                    }
                    if (data.errors.confirm_password) {
                        $('#countryModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.confirm_password + "<br>");
                    }
                } else if (data.error) {
                    $('#countryModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.error);
                } else {
                    $('#countryModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                }
                setTimeout(() => {
                    $('#countryModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            });
        });
    });
</script>
@endpush