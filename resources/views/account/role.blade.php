@extends('layouts.account')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
          <h1 class="m-0"><i class='fas fa-user-lock'></i> User Roles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('users/roles') }}">User Roles</a></li>
                        <li class="breadcrumb-item active">View Role</li>
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
                    <div class="card-body box-profile row d-flex align-items-center">
                        <div class='col-8'>
                            <h3>{{$role->name}}</h3>
                        </div>
                        <div class='col-4 text-end'>
                            <button class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#permissionsModal"><i
                                    class='fas fa-plus'></i> Add Permissions</button>
                        </div>
                    </div>
                </div>
                <!-- small box -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="">
                            <h5><strong><i class='fas fa-user-lock'></i> | {{$role->name}}</strong> Permissions</h5>
                        </div>

                        <div class="table-responsive">
                            <table class='table w-100'>
                                <thead>
                                    <tr>
                                        <th><input type='checkbox' name='all' value='0'></th>
                                        <th>Name</th>
                                        <th>Users</th>
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
<div class="modal fade" id="permissionsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-user-lock'></i> <span><strong>{{$role->name}}</strong> Permissions</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('users/role/permissions/add') }}">
                    @csrf
                    <input type='hidden' name='id' value='{{ $role->id }}'>
                    <div class='form-group'>
                        <label>Role Name</label>
                        <select name="permissions[]" id='permissions' class='form-control' multiple="multiple"></select>
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
            ajax: "{{ url('users/datatables/role/permissions/'.$role->id) }}",
            dom: 'lBtrip', //'lfBtrip'
            columns: [
                { data: 'checkbox', name: 'checkbox', sortable:false },
                { data: 'name', name: 'name' },
                { data: 'role', name: 'role' },
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
        $('#permissionsModal .btnSave').click(function () {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('#permissionsModal .feedback').removeClass('d-none');
            $('#permissionsModal .feedback').removeClass('alert-danger');
            $('#permissionsModal .feedback').removeClass('alert-success');
            $('#permissionsModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
            var formData = $('#permissionsModal form').serialize();
            $.ajax({
                url: '{{ url("users/role/permissions/add") }}',
                type: 'POST',
                data: formData
            }).done(function (data) {
                $('#permissionsModal .feedback').addClass('alert-success');
                $('#permissionsModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.success);
                table.draw();
                setTimeout(() => {
                    $('#permissionsModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            }).fail(function (response) {
                let data = response.responseJSON;
                $('#permissionsModal .feedback').addClass('alert-danger');
                $('#permissionsModal .feedback').html("");
                if (data.errors) {
                    if (data.errors.name) {
                        $('#permissionsModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.name + "<br>");
                    }
                    if (data.errors.email) {
                        $('#permissionsModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.email + "<br>");
                    }
                    if (data.errors.password) {
                        $('#permissionsModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.password + "<br>");
                    }
                    if (data.errors.confirm_password) {
                        $('#permissionsModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.confirm_password + "<br>");
                    }
                } else if (data.error) {
                    $('#permissionsModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.error);
                } else {
                    $('#permissionsModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                }
                setTimeout(() => {
                    $('#permissionsModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            });
        });
        $(document).on('click', '.table .btn-edit', function($query){
            var row = $(this).closest('tr');
            var id = row.find('.id').text();
            var name = row.find('td:nth-child(2)').text();

            $('#permissionsModal .modal-title span').text("Edit Role");
            $('#permissionsModal input[name=id]').val(id);
            $('#permissionsModal input[name=name]').val(name);
        });
        $('#permissions').select2({
                width: '100%',
                placeholder: 'Select',
                dropdownParent: $('#permissionsModal'),
                allowClear: true,
                ajax: {
                    url: '{{url("users/permissions/search")}}',
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
</script>
@endpush