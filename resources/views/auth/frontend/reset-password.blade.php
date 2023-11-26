
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chatify | Reset Password</title>
    @include('layouts.header')
    @livewireStyles()
</head>

<body>
    <!-- page-wrapper Start-->
    <section>
        <div class="container-fluid p-0">
            <div class="row m-0">
                <div class="col-12 p-0">
                    <div class="login-card">
                        <form class="theme-form login-form" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="logo-wrapper pb-2 border-bottom text-center"><a href="#"><img class="img-fluid" src="{{ asset('talkster/chatify-high-resolution-logo-color-on-transparent-background.png') }}" alt="" width="70%"></a></div>
                            <h4 class="mt-3 mb-3 text-center">Create Your New Password </h4>
                            <div class="form-group">
                                <label>Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text text-secondary"><i
                                            class="fa-solid fa-envelope @error('email') text-danger @enderror"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="Enter your email" autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <div class="input-group"><span class="input-group-text text-secondary"><i
                                            class="fa-solid fa-lock @error('password') text-danger @enderror"></i></span>
                                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                                        name="password" placeholder="*********" autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <div class="input-group"><span class="input-group-text text-secondary"><i
                                            class="fa-solid fa-lock @error('password_confirmation') text-danger @enderror"></i></span>
                                    <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                        type="password" name="password_confirmation" placeholder="*********"
                                        autocomplete="new-password">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="justify-content-center">
                                    {{-- <a href="/" class="text-success">Back to home</a> --}}
                                    <a href="/" class="btn float-start text-secondary">Back to Home</a>
                                    <button class="btn btn-dark btn-block"
                                        type="submit">{{ __('Reset Password') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page-wrapper end-->

    @livewireScripts()
</body>

</html>
