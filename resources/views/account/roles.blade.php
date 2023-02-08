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
                        <li class="breadcrumb-item active">User Roles</li>
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
                            <button class="btn btn-primary btn-sm btn-launch-modal" data-bs-toggle="modal" data-bs-target="#roleModal"><i
                                    class='fas fa-plus'></i> Add Role</button>
                        </div>

                        <div class="table-responsive">
                            <table class='table w-100'>
                                <thead>
                                    <tr>
                                        <th>#</th>
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
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-user-lock'></i> <span>New Role</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('users/roles/add') }}">
                    @csrf
                    <input type='hidden' name='id' value='0'>
                    <div class='form-group'>
                        <label>Role Name</label>
                        <input type='text' placeholder="Role Name" name="name" class='form-control' autofocus
                            required />
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
            ajax: "{{ url('users/datatable/roles') }}",
            dom: 'lBtrip', //'lfBtrip'
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
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
        $('.btn-launch-modal').click(function(){
            $('#roleModal .modal-title span').text("Add Role");
            $('#roleModal input[name=id]').val(0);
            $('#roleModal input[name=name]').val("");
        });
        $('#roleModal .btnSave').click(function () {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('#roleModal .feedback').removeClass('d-none');
            $('#roleModal .feedback').removeClass('alert-danger');
            $('#roleModal .feedback').removeClass('alert-success');
            $('#roleModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
            var formData = $('#roleModal form').serialize();
            $.ajax({
                url: '{{ url("users/roles/add") }}',
                type: 'POST',
                data: formData
            }).done(function (data) {
                $('#roleModal .feedback').addClass('alert-success');
                $('#roleModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.success);
                table.draw();
                setTimeout(() => {
                    $('#roleModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            }).fail(function (response) {
                let data = response.responseJSON;
                $('#roleModal .feedback').addClass('alert-danger');
                $('#roleModal .feedback').html("");
                if (data.errors) {
                    if (data.errors.name) {
                        $('#roleModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.name + "<br>");
                    }
                    if (data.errors.email) {
                        $('#roleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.email + "<br>");
                    }
                    if (data.errors.password) {
                        $('#roleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.password + "<br>");
                    }
                    if (data.errors.confirm_password) {
                        $('#roleModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.confirm_password + "<br>");
                    }
                } else if (data.error) {
                    $('#roleModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.error);
                } else {
                    $('#roleModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                }
                setTimeout(() => {
                    $('#roleModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            });
        });
        $(document).on('click', '.table .btn-edit', function($query){
            var row = $(this).closest('tr');
            var id = row.find('.id').text();
            var name = row.find('td:nth-child(2)').text();

            $('#roleModal .modal-title span').text("Edit Role");
            $('#roleModal input[name=id]').val(id);
            $('#roleModal input[name=name]').val(name);
        });
    });
</script>
@endpush