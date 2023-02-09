@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row d-flex align-items-center">
        <div class="d-none d-md-block col-md-6 main m-0 p-0">
            <div class='w-100 d-flex align-items-center dark'>
                <div class='p-5 w-100'>
                    <h3>{{ config('app.name', 'Laravel') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-4 w-100">
                <h3>Register</h3>
                <hr>
                <form method="POST" action="{{ route('register') }}" class='row'>
                    @csrf
                    <input type='hidden' name='role' value='{{$role->id}}'>
                    <div class="col-sm-6 form-group">
                        <label for="firstname">{{ __('First Name') }}</label>
                        <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" 
                        autofocus placeholder="First Name">

                        @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="larstname">{{ __('Last Name') }}</label>
                        <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" 
                        autofocus placeholder="Last Name">

                        @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-sm-12 form-group mt-3">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" 
                        value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-sm-6 form-group mt-3">
                        <label for="country">{{ __('Country') }}</label>
                        <select class="form-control @error('country') is-invalid @enderror" name="country" id='country' required>
                        </select>

                        @error('country')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-sm-6 form-group mt-3">
                        <label for="phone">{{ __('Phone Number') }}</label>
                        <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" 
                        value="{{ old('phone') }}" required autocomplete="email" placeholder="Phone Number">

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-sm-6 form-group mt-3">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" 
                        required autocomplete="new-password" placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-sm-6 form-group mt-3">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Confirm Password">
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 offset-md-6">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
   <script>
        $(document).ready(function(){
            $('.navbar').addClass('d-none');
            $('.footer').addClass('d-none');
            $('#country').select2({
                width: '100%',
                placeholder: 'Select',
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
            
        });
   </script> 
@endpush
