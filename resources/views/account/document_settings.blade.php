@extends('layouts.account')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"><i class='fas fa-folder-plus'></i> Document Types</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Document Types</li>
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
                            <button class="btn btn-primary btn-sm btn-launch-modal" data-bs-toggle="modal" data-bs-target="#documentTypeModal"><i
                                    class='fas fa-plus'></i> Add Document Type</button>
                        </div>
                        <div class="table-responsive">
                            <table class='table w-100'>
                                <thead>
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Required</th>
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
<div class="modal fade" id="documentTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-plus'></i> <span>Add Document Type</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('settings/document_type/add') }}" class='row'>
                    @csrf
                    <input type='hidden' name='id' value='0'>
                    <div class='col-12 form-group'>
                        <label>Document Name</label>
                        <input type='text' placeholder="Document Name" name="name" class='form-control' autofocus
                            required />
                    </div>
                    <div class='col-12 form-group'>
                        <label>Description</label>
                        <textarea name='description' class='form-control' placeholder='document type descripion' rows='4'></textarea>
                    </div>
                    <div class='col form-group'>
                        <label>Required</label>
                        <select name="required" class='form-control'>
                            <option disabled>Select Status</option>
                            <option value='1'>Yes</option>
                            <option value='0'>No</option>
                        </select>
                    </div>
                    <div class='col form-group'>
                        <label>Status</label>
                        <select name="status" class='form-control'>
                            <option disabled>Select Status</option>
                            <option value='1'>Active</option>
                            <option value='0'>In-Active</option>
                        </select>
                    </div>
                    <div class='col-12 alert feedback border d-none'>
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
            ajax: "{{ url('settings/datatable/document_types') }}",
            dom: 'lBtrip', //'lfBtrip'
            columns: [
                //{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'required', name: 'required' },
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
            $('#documentTypeModal input[name=id]').val(0);
            $('#documentTypeModal input[name=name]').val("");
            $('#documentTypeModal input[name=description]').val("");
            $('#documentTypeModal select[name=required]').val(1);
            $('#documentTypeModal select[name=status]').val(1);
        });
        
        $('#documentTypeModal .btnSave').click(function () {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('#documentTypeModal .feedback').removeClass('d-none');
            $('#documentTypeModal .feedback').removeClass('alert-danger');
            $('#documentTypeModal .feedback').removeClass('alert-success');
            $('#documentTypeModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
            var formData = $('#documentTypeModal form').serialize();
            $.ajax({
                url: '{{ url("settings/document_type/add") }}',
                type: 'POST',
                data: formData
            }).done(function (data) {
                $('#documentTypeModal .feedback').addClass('alert-success');
                $('#documentTypeModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.success);
                table.draw();
                setTimeout(() => {
                    $('#documentTypeModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            }).fail(function (response) {
                let data = response.responseJSON;
                $('#documentTypeModal .feedback').addClass('alert-danger');
                $('#documentTypeModal .feedback').html("");
                if (data.errors) {
                    if (data.errors.name) {
                        $('#documentTypeModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.name + "<br>");
                    }
                    if (data.errors.description) {
                        $('#documentTypeModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.description + "<br>");
                    }
                    if (data.errors.required) {
                        $('#documentTypeModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.required + "<br>");
                    }
                    if (data.errors.status) {
                        $('#documentTypeModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.status + "<br>");
                    }
                } else if (data.error) {
                    $('#documentTypeModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.error);
                } else {
                    $('#documentTypeModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                }
                setTimeout(() => {
                    $('#documentTypeModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            });
        });
        $(document).on('click', '.table .btn-edit', function(){
            var row = $(this).closest('tr');
            var id = row.find('.id').text();
            var name = row.find('.name').text();
            var phone_code = row.find('.description').text();
            var country_code = row.find('.required').text();
            var status = row.find('.status').text();

            $('#documentTypeModal input[name=id]').val(id);
            $('#documentTypeModal input[name=name]').val(name);
            $('#documentTypeModal textarea[name=description]').val(phone_code);
            $('#documentTypeModal select[name=required]').val(country_code);
            $('#documentTypeModal select[name=status]').val(status);
        });
    });
</script>
@endpush