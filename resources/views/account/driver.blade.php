@extends('layouts.account')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"><i class='fas fa-id-card-alt'></i> Driver</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Driver</li>
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
            <div class="col-sm-5 col-md-4 col-lg-3 mb-3">
                <!-- small box -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile h-100">
                        <img src='{{$driver->user->image != ""?asset("images/profiles/".$driver->user->image):asset("images/male_avatar.svg")}}' class='img-fluid rounded w-100' alt='avatar image'>
                        <table class='table border mt-1'>
                            <tr>
                                <td>{{$driver->user->firstname}} {{$driver->user->lastname}}</td>
                            <tr>
                                <td><span class='text-muted'><i class='fas fa-envelope'></i> {{$driver->user->email}}</span></td>
                            <tr>
                                <td>
                                    <span class='text-muted  pt-2 pb-2'><i class='fas fa-phone'></i> {{$driver->user->phone}}</span>
                                </td>
                            <tr>
                                <td>
                                    <span class='text-muted  pt-2 pb-2'><i class='fas fa-globe'></i> {{$driver->user->country->name}}</span>
                                </td>
                            <tr>
                                <td>
                                    <span class='text-success  pt-2 pb-2'><i class='fas fa-certificate'></i> 123 Requests</span>
                                </td>
                            <tr>
                                <td>
                                    {!!$driver->suspended?"<span class='badge bg-danger'>Suspended</span>":($driver->status?"<span class='badge bg-primary'>Active</span>":"<span class='badge bg-secondary'>Pending</span>")!!}
                                </td>
                            <tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class='col-sm-7 col-md-8 col-lg-9'>
                <div class='card mb-3'>
                    <div class='card-body row d-flex align-items-center'>
                        <div class='col'>
                            <h5><i class='far fa-user'></i> Driver's Profile</h5>
                        </div>
                        <div class='col text-right'>
                            <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#reviewModal'><i class='fas fa-cog'></i> Review</button>
                        </div>
                    </div>
                </div>
                <div class='card mb-3'>
                    <div class='card-header'>
                        <div class='row'>
                            <div class='col'>
                                <h5><i class='fas fa-cloud-upload-alt'></i> Driver's Uploads</h5>
                            </div>
                        </div>
                    </div>
                    <div class='card-body'>
                        <div class="table-responsive">
                            <table class='table w-100 uploads'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Document Type</th>
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
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-cog'></i> <span>Review Status</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('drivers/review') }}" class="row">
                    @csrf
                    <input type='hidden' name='id' value='{{ $driver->id }}'>
                    <div class='col-sm-12 form-group'>
                        <label>Review Notes</label>
                        <textarea placeholder="Comments" name="comments" rows='4' class='form-control' required>{{$driverApproval != null?$driverApproval->comments:""}}</textarea>
                    </div>
                    <div class='col-sm-12 form-group'>
                        <label>Status</label>
                        <select name="status" class='form-control'>
                            <option disabled>Approval Status</option>
                            <option value='1' {{$driverApproval != null?($driverApproval->status==1?"selected":""):""}}>Approve</option>
                            <option value='2' {{$driverApproval != null?($driverApproval->status==2?"selected":""):""}}>Reject</option>
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


<!-- Profile Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!--<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-cog'></i> <span>Review Status</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>-->
            <div class="modal-body m-0">
                <div class='alert border-secondary text-muted'>
                    <i class='fas fa-spinner fa-pulse'></i> <b>Approving...</b> Please wait
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i
                        class='fas fa-times'></i> Close</button>
                <button type="button" class="btn btn-primary btn-sm btnSave"><i class='fas fa-paper-plane'></i> Save
                    changes</button>
            </div>-->
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        var table = $('.uploads').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('documents/datatable/my_documents/'.$driver->user_id) }}",
            dom: 'lBtrip', //'lfBtrip'
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'document_type.name', name: 'document_type.name' },
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
            $('#userModal .modal-title span').text("New User");
            $('#userModal input[name=id]').val(0);
            $('#userModal input[name=firstname]').val("");
            $('#userModal input[name=lastname]').val("");
            $('#userModal input[name=email').val("");
            $('#userModal input[name=phone]').val("");
            $('#roles').empty();
            $('#countries').empty();
        });
        $('#userModal .btnSave').click(function () {
            var btn = $(this);
            btn.attr('disabled', 'disabled');
            $('#userModal .feedback').removeClass('d-none');
            $('#userModal .feedback').removeClass('alert-danger');
            $('#userModal .feedback').removeClass('alert-success');
            $('#userModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
            var formData = $('#userModal form').serialize();
            $.ajax({
                url: '{{ url("users/add") }}',
                type: 'POST',
                data: formData
            }).done(function (data) {
                $('#userModal .feedback').addClass('alert-success');
                $('#userModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.success);
                table.draw();
                setTimeout(() => {
                    $('#userModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            }).fail(function (response) {
                let data = response.responseJSON;
                $('#userModal .feedback').addClass('alert-danger');
                $('#userModal .feedback').html("");
                if (data.errors) {
                    if (data.errors.firstname) {
                        $('#userModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.firstname + "<br>");
                    }
                    if (data.errors.lastname) {
                        $('#userModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.errors.lastname + "<br>");
                    }
                    if (data.errors.email) {
                        $('#userModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.email + "<br>");
                    }
                    if (data.errors.phone) {
                        $('#userModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.phone + "<br>");
                    }
                    if (data.errors.country) {
                        $('#userModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.country + "<br>");
                    }
                    if (data.errors.status) {
                        $('#userModal .feedback').append("<i class='fas fa-exclamation-circle'></i> " + data.errors.status + "<br>");
                    }
                } else if (data.error) {
                    $('#userModal .feedback').html("<i class='fas fa-exclamation-circle'></i> " + data.error);
                } else {
                    $('#userModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                }
                setTimeout(() => {
                    $('#userModal .feedback').addClass('d-none');
                }, 3000);
                btn.removeAttr('disabled');
            });
        });
        $('#feedbackModal').modal({backdrop: 'static', keyboard: false});
        $(document).on('click', '.table .btn-approve', function(e){
            e.preventDefault();
            var form = $(this).closest('td').find('form');
            form.find('input[name=status]').val(1);
            var formData = form.serialize();
            $('#feedbackModal .alert').addClass('border-secondary');
            $('#feedbackModal .alert').addClass('text-muted');
            $('#feedbackModal .alert').html("<i class='fas fa-spinner fa-pulse'></i> <b>Approving</b>. Please wait...");
            $('#feedbackModal').modal('show');
            $('#feedbackModal').on('shown.bs.modal', function(){
                $.ajax({
                    url: "{{ url('documents/review') }}",
                    type: 'POST',
                    data: formData
                }).done(function(data){
                    alert("success");
                    $('#feedbackModal').modal('hide');
                }).fail(function(data){
                    $('#feedbackModal .alert').removeClass('border-secondary');
                    $('#feedbackModal .alert').removeClass('text-muted');
                    $('#feedbackModal .alert').addClass('border-danger');
                    $('#feedbackModal .alert').addClass('text-danger');
                    $('#feedbackModal .alert').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b>. Something went wrong!");
                    setTimeout(function(){
                        $('#feedbackModal').modal('hide');
                    }, 3000);
                });
            });
            
        });
    });
</script>
@endpush