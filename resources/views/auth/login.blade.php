@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row justify-content-center">
        {{-- <div class="col-md-5 mb-2">
            <div class="card text-light bg-dark">
                <div class="card-header">Customer Login</div>
                <div class="card-body">
                    <div class="alert alert-secondary" role="alert">
                        ඔබට අත්‍යවශ්‍ය ද්‍රව්‍ය පාර්සලයක් අවශ්‍යනම් ඔබේ ෆේස්බුක් ගිණුම හරහා මෙයට ඇතුල්වී ඔබ ප්‍රදේශයේ
                        ආහාර මලු බෙදා දීමේ කණ්ඩායමට ඔබට අවශ්‍ය ආහාර පාර්සලය ඇණවුම් කල හැක.
                    </div>
                    <a href="{{ url('auth/redirect/facebook') }}" class="btn btn-primary"><i
                            class="fa fa-facebook"></i> Login with Facebook</a>
                </div>
            </div>
        </div> --}}
        <div class="col-md-5">
            <div class="card text-light bg-dark">
                <div class="card-header">Agent Login</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login as Agent
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
