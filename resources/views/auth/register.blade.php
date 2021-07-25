@extends('layouts.templates.guest')

@section('title', '| Register')

@section('content')
<div class="auth-content">
    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4">
                <h1>GIS Project</h1>
            </div>
            <h6 class="mb-4 text-muted">Create new account</h6>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group text-left">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group text-left">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group text-left">
                    <label for="password">password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group text-left">
                    <label for="password_confirmation">Password Confirmation</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Password Confirmation">
                </div>
                <button class="btn btn-primary shadow-2 mb-4" type="submit">Register</button>
            </form>
            <p class="mb-0 text-muted">
                Allready have an account? 
                <a href="{{ route('login') }}">Log in</a>
            </p>
        </div>
    </div>
</div>
@endsection
