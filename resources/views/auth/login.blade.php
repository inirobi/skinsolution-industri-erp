@extends('layouts.masterLogin')

@section('content')
<div class="limiter">
    <div class="container-login100" style="background-image: url('{{ asset('assets/Login/images/bg-01.jpg')}}');">
      <div class="wrap-login100">
        <form class="login100-form validate-form" method="POST" action="{{ route('login')}}">
            @csrf
          <span class="login100-form-logo">
            <i class="zmdi zmdi-landscape"></i>
          </span>

          <span class="login100-form-title p-b-34 p-t-27">
            {{ __('Log in') }}
          </span>

          <div class="wrap-input100 validate-input" data-validate = "Enter username">
            <input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="E-Mail Address">
            <span class="focus-input100" data-placeholder="&#xf207;"></span>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="wrap-input100 validate-input" data-validate="Enter password">
            <input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
            <span class="focus-input100" data-placeholder="&#xf191;"></span>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="contact100-form-checkbox">
            <input class="input-checkbox100" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="label-checkbox100" for="remember">
              {{ __('Remember Me') }}
            </label>
          </div>

          <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn">
                {{ __('Login') }}
            </button>
          </div>

          <div class="text-center p-t-90">
            @if (Route::has('password.request'))
                <a class="txt1" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
