@extends('layouts.account')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"><i class='fas fa-folder-plus'></i> Document Type View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Document Type View</li>
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
                        <div class="row d-flex align-items-center">
                            <div class="col-sm-9">
                                <h4>{{$document_type->name}}</h4>
                            </div>
                            <div class="col-sm-3 text-end">
                                <button class="btn btn-primary btn-sm btn-launch-modal" data-bs-toggle="modal" data-bs-target="#rolesModal"><i
                                        class='fas fa-plus'></i> Add Role</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class='table w-100'>
                                <thead>
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th>Document Name</th>
                                        <th>Role</th>
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
<div class="modal fade" id="rolesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-plus'></i> <span>Add Role</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('settings/document_type/roles/add') }}">
                    @csrf
                    <input type='hidden' name='id' value='{{$document_type->id}}'>
                    
                    <div class='form-group'>
                        <label>Select Role</label>
                        <select id='roles' name="roles[]" class='form-control' multiple="multiple">
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
            ajax: "{{ url('settings/document_types/datatable/view/roles/'.$document_type->id) }}",
            dom: 'lBtrip', //'lfBtrip'
            columns: [
                //{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'document_type.name', name: 'document_type.name' },
                { data: 'role.name', name: 'role.name' },
                { data: 'created_at', name: 'created_at' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });
        $('#roles').select2({
            width: '100%',
            placeholder: 'Select Role',
            //dropdownParent: $('#modelModal'),
            allowClear: true,
            ajax: {
                url: '{{url("users/search/roles")}}',
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
        $('.btn-launch-modal').click(function(){
        });
        
        $('#rolesModal .btnSave').click(function () {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('#rolesModal .feedback').removeClass('d-none');
            $('#rolesModal .feedback').removeClass('alert-danger');
            $('#rolesModal .feedback').removeClass('alert-success');
            $('#rolesModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
            var formData = $('#rolesModal form').serialize();
            $.ajax({
                url: '{{ url("settings/document_type/roles/add") }}',
                type: 'POST',
                data: formData
            }).done(function (data) {
                $('#rolesModal .feedback').addClass('alert-success');
                $('#rolesModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.success);
                table.draw();
                setTimeout(() => {
                    $('#rolesModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            }).fail(function (response) {
                let data = response.responseJSON;
                $('#rolesModal .feedback').addClass('alert-danger');
                $('#rolesModal .feedback').html("");
                if (data.errors) {
                    if (data.errors.id) {
                        $('#rolesModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.id + "<br>");
                    }
                    if (data.errors.roles) {
                        $('#rolesModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.roles + "<br>");
                    }
                } else if (data.error) {
                    $('#rolesModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.error);
                } else {
                    $('#rolesModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                }
                setTimeout(() => {
                    $('#rolesModal .feedback').addClass('d-none');
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

            $('#rolesModal input[name=id]').val(id);
            $('#rolesModal input[name=name]').val(name);
            $('#rolesModal textarea[name=description]').val(phone_code);
            $('#rolesModal select[name=required]').val(country_code);
            $('#rolesModal select[name=status]').val(status);
        });
    });
</script>
@endpush