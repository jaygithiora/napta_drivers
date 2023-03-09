@extends('layouts.account')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class='far fa-user'></i> Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
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
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class='row d-flex align-items-center'>
                                <div class='col'>
                                    <h5><i class='fas fa-user'></i> Profile</h5>
                                </div>
                                <div class='col text-right'>
                                    <!--<button class='btn btn-primary  btn-sm'>Save Profile</button>-->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-6 col-md-5 col-lg-4 text-center">
                                    <img src='{{Auth::user()->image != ""?asset("images/profiles/".Auth::user()->image):asset("images/male_avatar.svg")}}' class="img-fluid w-100 img-rounded shadow">
                                    <button class='mt-3 btn btn-outline-primary btn-sm' data-bs-toggle="modal" data-bs-target="#profilePictureModal"><i class='fas fa-cloud-upload'></i> Change Profile</button>
                                </div>
                                <div class='col-sm-6 col-md-7 col-lg-8'>
                                    <table>
                                        <tr>
                                            <td><b>Name:</b></td>
                                            <td class='p-1'>{{ \Auth::user()->firstname }} {{ \Auth::user()->lastname }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Role:</b></td>
                                            <td class='p-1'>
                                                @foreach($user->roles as $role)
                                                    <span class='badge border border-primary text-primary'>{{$role->name}}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Email:</b></td>
                                            <td class='p-1'><span class="text-muted">{{ \Auth::user()->email }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Phone:</b></td>
                                            <td class='p-1'><span class="text-muted">{{ \Auth::user()->phone }}</span></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class='card-footer border-top text-end bg-white'>
                            <button class='btn btn-white btn-sm border'  data-bs-toggle="modal" data-bs-target="#changePasswordModal"> <i class='fas fa-edit'></i>&nbsp;Change Password</button>&nbsp;
                            <button class='btn btn-primary btn-sm' data-bs-toggle="modal" data-bs-target="#profileModal"> <i class='fas fa-edit'></i>&nbsp;Edit Profile</button>
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
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-edit'></i>Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ url('profile/update/name') }}">
                        @csrf
                        <input type='hidden' name='id' value='{{ \Auth::user()->id }}'>
                        <div class='form-group'>
                            <label>First Name</label>
                            <input type='text' placeholder="First Name" name="firstname" value="{{ \Auth::user()->firstname }}" class='form-control' autofocus required/>
                        </div>
                        <div class='form-group'>
                            <label>Last Name</label>
                            <input type='text' placeholder="Last Name" name="lastname" value="{{ \Auth::user()->lastname }}" class='form-control' autofocus required/>
                        </div>
                        <div class='form-group'>
                            <label>Email Address</label>
                            <input type='email' placeholder="Email Address" name="email" value="{{ \Auth::user()->email }}" class='form-control' required readonly/>
                        </div>
                        <div class='alert feedback border d-none'>
                            <i class='fas fa-spinner fa-pulse'></i> Saving... Please wait
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class='fas fa-times'></i> Close</button>
                    <button type="button" class="btn btn-primary btn-sm btnSave"><i class='fas fa-paper-plane'></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-edit'></i> Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ url('profile/change/password') }}">
                        @csrf
                        <div class='form-group'>
                            <label>Current Password</label>
                            <input type='password' placeholder="Current Password" name="current_password" class='form-control' autofocus required/>
                        </div>
                        <div class='form-group'>
                            <label>New Password</label>
                            <input type='password' placeholder="New Password" name="new_password" class='form-control' autofocus required/>
                        </div>
                        <div class='form-group'>
                            <label>Confirm New Password</label>
                            <input type='password' placeholder="Confirm New Password" name="confirm_password" class='form-control' autofocus required/>
                        </div>
                        <div class='alert feedback border d-none'>
                            <i class='fas fa-spinner fa-pulse'></i> Saving... Please wait
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class='fas fa-times'></i> Close</button>
                    <button type="button" class="btn btn-primary btn-sm btnSave"><i class='fas fa-paper-plane'></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Change Profile Picture Modal -->
    <div class="modal fade" id="profilePictureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class='fas fa-edit'></i> Change Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class='img-div-preview'>
                        <img src='{{Auth::user()->image != ""?asset("images/profiles/".Auth::user()->image):asset("images/male_avatar.svg")}}' class="img-fluid w-100 img-rounded shadow">
                    </div>
                    <div class='img-div d-none'>
                        <input type="file" id="upload" class='d-none' accept="image/png, image/jpeg, image/jpg">
                        <div class='preview'></div>
                    </div>
                    <div class='mt-1 alert'></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary btn-sm btn-upload"><i class='fas fa-cloud-upload-alt'></i> Upload Photo</button>
                    <button type="button" class="btn btn-primary btn-sm btnSave" disabled='disabled'><i class='fas fa-paper-plane'></i> Update Profile</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $uploadCrop = $('.preview').croppie({
                url: '{{Auth::user()->image != ""?asset("images/profiles/".Auth::user()->image):asset("images/male_avatar.svg")}}',
                enableExif: true,
                viewport: {
                    width: 280,
                    height: 280,
                    //type: 'circle'
                },
                boundary: {
                    width: 300,
                    height: 300
                }
            });
            $('.btn-upload').click(function(){
                $('#upload').click();
            });
            $('#upload').on('change', function () { 
                var reader = new FileReader();
                reader.onload = function (e) {
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                        $('.modal-body .img-div').removeClass('d-none');
                        $('.modal-body .img-div-preview').addClass('d-none');
                        $('.modal-body .img-div-preview').addClass('d-none');
                        $('#profilePictureModal .btnSave').removeAttr('disabled');
                    });
                }
                reader.readAsDataURL(this.files[0]);
            });
            $('#profilePictureModal .btnSave').on('click', function (ev) {
                var btn = $(this);
                btn.attr('disabled', 'disabled');
                $('#profilePictureModal .alert').removeClass('d-none');
                $('#profilePictureModal .alert').addClass('border-secondary');
                $('#profilePictureModal .alert').addClass('text-secondary');
                $('#profilePictureModal .alert').html('<i class="fas fa-spinner fa-pulse"></i> <b>Loading!</b> Please wait...');
                $uploadCrop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {
                    $.ajax({
                        url: "{{ url('profile/upload/picture') }}",
                        type: "POST",
                        data: {"image":resp},
                        success: function (data) {
                            /*html = '<img src="' + resp + '" />';
                            $("#upload-demo-i").html(html);*/
                            $('#profilePictureModal .alert').removeClass('border-secondary');
                            $('#profilePictureModal .alert').removeClass('text-secondary');
                            $('#profilePictureModal .alert').addClass('border-success');
                            $('#profilePictureModal .alert').addClass('text-success');
                            $('#profilePictureModal .alert').html('<i class="far fa-check-circle"></i> <b>Success!</b> Profile Uploaded successfully');
                            setTimeout(() => {
                                $('#profilePictureModal .alert').removeClass('border-success');
                                $('#profilePictureModal .alert').removeClass('text-success');
                            }, 3000);
                            location.href="{{url('profile')}}";
                        },
                        error: function(data) {
                            $('#profilePictureModal .alert').removeClass('border-secondary');
                            $('#profilePictureModal .alert').removeClass('text-secondary');
                            $('#profilePictureModal .alert').addClass('border-danger');
                            $('#profilePictureModal .alert').addClass('text-danger');
                            $('#profilePictureModal .alert').html('<i class="fas fa-exclamation-circle"></i> <b>Whoops!</b> Something went wrong');
                            setTimeout(() => {
                                $('#profilePictureModal .alert').removeClass('border-danger');
                                $('#profilePictureModal .alert').removeClass('text-danger');
                                btn.removeAttr('disabled', 'disabled');
                            }, 3000);
                        }
                    });
                });
            });
        });
        Dropzone.options.dropzone =
            {
                maxFiles: 5,
                maxFilesize: 4,
                acceptedFiles: "image/*,application/pdf,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",
                addRemoveLinks: true,
                timeout: 50000,
                init:function() {
                    // Get images
                    var myDropzone = this;
                    $.ajax({
                        url: "{{ url('profile/documents')}}",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data){
                        //console.log(data);
                        $.each(data, function (key, value) {
                            var file = {name: value.name+"("+value.document_type+")", size: value.size};
                            myDropzone.options.addedfile.call(myDropzone, file);
                            myDropzone.options.thumbnail.call(myDropzone, file, value.path);
                            myDropzone.emit("complete", file);
                        });
                        }
                    });
                },
                removedfile: function(file)
                {
                    if (this.options.dictRemoveFile) {
                        return Dropzone.confirm("Are You Sure to "+this.options.dictRemoveFile, function() {
                            if(file.previewElement.id != ""){
                                var name = file.previewElement.id;
                            }else{
                                var name = file.name;
                            }
                            //console.log(name);
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                type: 'POST',
                                url: "{{ url('profile/documents/remove') }}",
                                data: {filename: name},
                                success: function (data){
                                    alert(data.success +" File has been successfully removed!");
                                },
                                error: function(e) {
                                    alert(data.error);
                                    console.log(e);
                                }
                            });
                            var fileRef;
                            return (fileRef = file.previewElement) != null ?
                            fileRef.parentNode.removeChild(file.previewElement) : void 0;
                        });
                    }
                },
                success: function(file, response)
                {
                    file.previewElement.id = response.success;
                    //console.log(file);
                    // set new images names in dropzone’s preview box.
                    var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                    file.previewElement.querySelector("img").alt = response.success;
                    olddatadzname.innerHTML = response.success;
                },
                error: function(file, response)
                {
                    if($.type(response) === "string")
                        var message = response; //dropzone sends it's own error messages in string
                    else
                        var message = response.message;
                    file.previewElement.classList.add("dz-error");
                    _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                    _results = [];
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i];
                        _results.push(node.textContent = message);
                    }
                    return _results;
                }
            }
        $(document).ready(function(){
            $('#profileModal .btnSave').click(function(){
                var btn = $(this);
                btn.attr('disabled', 'disabled');
                $('#profileModal .feedback').removeClass('d-none');
                $('#profileModal .feedback').removeClass('alert-danger');
                $('#profileModal .feedback').removeClass('alert-success');
                $('#profileModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
                var formData = $('#profileModal form').serialize();
                $.ajax({
                    url: '{{ url("profile/update/name") }}',
                    type: 'POST',
                    data: formData
                }).done(function(data){
                    $('#profileModal .feedback').addClass('alert-success');
                    $('#profileModal .feedback').html("<i class='fas fa-exclamation-circle'></i> "+data.success);
                    setTimeout(() => {
                        $('#profileModal .feedback').addClass('d-none');
                    }, 3000);
                    btn.removeAttr('disabled');
                }).fail(function(response){
                    let data = response.responseJSON;
                    $('#profileModal .feedback').addClass('alert-danger');
                    if(data.errors){
                        $('#profileModal .feedback').html("<i class='fas fa-exclamation-circle'></i> "+data.errors.name);
                    }else if(data.error){
                        $('#profileModal .feedback').html("<i class='fas fa-exclamation-circle'></i> "+data.error);
                    }else{
                        $('#profileModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                    }
                    setTimeout(() => {
                        $('#profileModal .feedback').addClass('d-none');
                    }, 3000);
                    btn.removeAttr('disabled');
                });
            });

            $('#changePasswordModal .btnSave').click(function(){
                var btn = $(this);
                btn.attr('disabled', 'disabled');
                /*$('#changePasswordModal form').submit();
                return;*/
                $('#changePasswordModal .feedback').removeClass('d-none');
                $('#changePasswordModal .feedback').removeClass('alert-danger');
                $('#changePasswordModal .feedback').removeClass('alert-success');
                $('#changePasswordModal .feedback').html("<i class='fas fa-spinner fa-pulse'></i> Saving... Please wait");
                var formData = $('#changePasswordModal form').serialize();
                $.ajax({
                    url: '{{ url("profile/change/password") }}',
                    type: 'POST',
                    data: formData
                }).done(function(data){
                    $('#changePasswordModal .feedback').addClass('alert-success');
                    $('#changePasswordModal .feedback').html("<i class='fas fa-exclamation-circle'></i> "+data.success);
                    setTimeout(() => {
                        $('#changePasswordModal .feedback').addClass('d-none');
                    }, 3000);
                    btn.removeAttr('disabled');
                }).fail(function(response){
                    let data = response.responseJSON;
                    $('#changePasswordModal .feedback').addClass('alert-danger');
                    $('#changePasswordModal .feedback').html('');
                    if(data.errors){
                        if(data.errors.current_password){
                            $('#changePasswordModal .feedback').append("<i class='fas fa-exclamation-circle'></i> "+data.errors.current_password+"<br>");
                        }
                        if(data.errors.new_password){
                            $('#changePasswordModal .feedback').append("<i class='fas fa-exclamation-circle'></i> "+data.errors.new_password+"<br>");
                        }
                        if(data.errors.confirm_password){
                            $('#changePasswordModal .feedback').append("<i class='fas fa-exclamation-circle'></i> "+data.errors.confirm_password);
                        }
                    }else if(data.error){
                        $('#changePasswordModal .feedback').html("<i class='fas fa-exclamation-circle'></i> "+data.error);
                    }else{
                        $('#changePasswordModal .feedback').html("<i class='fas fa-exclamation-circle'></i> <b>Whoops</b> Something went wrong with the server!");
                    }
                    setTimeout(() => {
                        $('#profileModal .feedback').addClass('d-none');
                    }, 3000);
                    btn.removeAttr('disabled');
                });
            });
        });
    </script>
@endpush
