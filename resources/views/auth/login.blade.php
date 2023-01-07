@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row d-flex align-items-center">
        <div class="d-none d-md-block col-md-6 main m-0 p-0">
            <div class='w-100 d-flex align-items-center dark'>
                <div class='p-5 w-100'>
                    <h3>Swift</h3>
                    <h4>It's got easier with swift</h4>
                    <ul>
                        <li>Lorem ipsum dolor sit</li>
                        <li> consectetur adipisicing elit.</li>
                        <li>Accusantium voluptatibus</li>
                        <li>repellendus ducimus laudantium</li>
                        <li>facere necessitatibus nesciunt fuga</li>
                        <li> sequi vitae esse doloremque quo est</li>
                        <li>numquam recusandae, nam natus atque?</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-4 w-100">
                <h3>Login</h3>
                <hr>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required 
                        autocomplete="email" autofocus placeholder="Email Address">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required 
                        autocomplete="current-password" placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 mt-3">
                        <div class="w-100">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                        <div class="row mb-0">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-50">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
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
        });
   </script> 
@endpush