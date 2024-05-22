@extends('layouts.app_login')

@section('content')
    <div class="text-center">
        <h4>MAIFIPP</h4>
        <h6 class="font-weight-light">Guarantee Letter Only</h6>
    </div>
    <form class="pt-3" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="{{ __('Username') }}" required autocomplete="username" autofocus>

            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div cl0ass="form-group">
            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" required autocomplete="current-password">
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-block btn-success btn-lg font-weight-medium auth-form-btn">SIGN IN</a>
        </div>
        <div style="text-align: center;">
            <a href="http://192.168.110.7/maif" class="text-success">Proceed to MAIFIPP</a>
        </div>
        <div class="my-2 d-flex justify-content-between align-items-center">
            <div class="form-check form-check-success">
            <label class="form-check-label text-muted">
                <input type="checkbox" class="form-check-input">
                Keep me signed in
            </label>
            </div>
            {{-- <a href="#" class="auth-link text-black">Forgot password?</a> --}}
        </div>
        {{-- <div class="text-center mt-4 font-weight-light">
            Don't have an account? <a href="register.html" class="text-info">Create</a>
        </div> --}}
    </form>
@endsection
