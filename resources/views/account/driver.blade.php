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
                        <div class='alert alert-secondary'>
                            <img src="{{asset('images/male_avatar.svg')}}" class='img-fluid'>
                        </div>
                        <table class='table border'>
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
                    <div class='card-header row'>
                        <div class='col'>
                            <h5><i class='fas fa-cloud-upload-alt'></i> Driver's Uploads</h5>
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
                    <div class='col-sm-6 form-group'>
                        <label>Review Notes</label>
                        <input type='text' placeholder="First Name" name="firstname" class='form-control' autofocus
                            required />
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Last Name</label>
                        <input type='text' placeholder="Last Name" name="lastname" class='form-control' autofocus
                            required />
                    </div>
                    <div class='col-sm-12 form-group'>
                        <label>Email Address</label>
                        <input type='email' placeholder="Email Address" name="email" class='form-control' required />
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Country</label>
                        <select id='countries' name="country" class='form-control'></select>
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>User Role</label>
                        <select id='roles' name="role" class='form-control' id='roles'></select>
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Phone Number</label>
                        <input type='text' placeholder="Phone Number" name="phone"
                            class='form-control' required />
                    </div>
                    <div class='col-sm-6 form-group'>
                        <label>Status</label>
                        <select name="status" class='form-control'>
                            <option disabled>Status</option>
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
        var table = $('.uploads').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('documents/datatable/my_documents/'.Auth::user()->id) }}",
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
        $('#countries').select2({
            width: '100%',
            placeholder: 'Select Country',
            //dropdownParent: $('#modelModal'),
            allowClear: true,
            ajax: {
                url: '{{url("index/search/countries")}}',
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
        $(document).on('click', '.table .btn-edit', function(){
            $('#userModal .modal-title span').text("Edit User");
            $('#roles').empty();
            $('#countries').empty();
            var row = $(this).closest('tr');
            var id = row.find('.id').text();
            var firstname = row.find('.firstname').text();
            var lastname = row.find('.lastname').text();
            var email = row.find('.email').text();
            var phone = row.find('.phone').text();
            var status = row.find('.status').text();
            var roleId = parseInt(row.find('.role_id').text());
            var roleName = row.find('.role_name').text();
            var countryId = parseInt(row.find('.country_id').text());
            var countryName = row.find('.country_name').text();
            if(roleId > 0){
                var data = {
                    id: roleId,
                    text: roleName
                };
                var newOption = new Option(data.text, data.id, false, false);
                $('#roles').append(newOption).trigger('change');
            }
            var data = {
                id: countryId,
                text: countryName
            };
            var newOption = new Option(data.text, data.id, false, false);
            $('#countries').append(newOption).trigger('change');

            $('#userModal input[name=id]').val(id);
            $('#userModal input[name=firstname]').val(firstname);
            $('#userModal input[name=lastname]').val(lastname);
            $('#userModal input[name=email').val(email);
            $('#userModal input[name=phone]').val(phone);
            $('#userModal select[name=status]').val(status);
        });
    });
</script>
@endpush