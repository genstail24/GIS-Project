@extends('layouts.templates.guest')

@section('title', '| Login')

@section('content')
<div class="card-body text-center">
  <div class="mb-4">
      <h1>GIS Project</h1>
  </div>
  <h6 class="mb-4 text-muted">Login to your account</h6>
  <form  method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group text-left ">
        <label for="email">Email adress</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group text-left">
        <label for="password">Password</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <div class="form-group text-left">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>
    </div>
    <button class="btn btn-primary shadow-2 mb-4" type="submit">Login</button>
  </form>
  <!-- <p class="mb-2 text-muted">Forgot password? <a href="forgot-password.html">Reset</a></p> -->
  <p class="mb-0 text-muted">Don't have account yet? <a href="{{ route('register') }}">Signup</a></p>
</div>
@endsection