<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chatify | Reset Password</title>
    @include('layouts.header')
    @livewireStyles()
</head>

<body style="user-select: none;">
    <!-- page-wrapper Start-->
    <section>
        <div class="container-fluid p-0">
            <div class="row m-0">
                <div class="col-12 p-0">
                    <div class="login-card">

                        <form class="theme-form login-form" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="logo-wrapper pb-2 border-bottom text-center"><a href="#"><img
                                        class="img-fluid"
                                        src="{{ asset('talkster/chatify-high-resolution-logo-color-on-transparent-background.png') }}"
                                        alt="" width="70%"></a></div>
                            <h4 class="mt-4 mb-4 text-center">Send Password Reset Link</h4>
                            <span class="text-muted mb-4 text-center">We'll email you a link that can reset your
                                password if you're having trouble signing in.</span>

                            @if (session()->has('status'))
                                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                                    role="alert">
                                    {{ session('status') }}
                                    <i class="fas fa-trash fa-lg text-danger float-end" data-bs-dismiss="alert"
                                        aria-label="Close" style="cursor: pointer;"></i>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $.notify({
                                            title: 'Email: Erica Fisher',
                                            message: 'Investment, stakeholders micro-finance equity health Bloomberg; global citizens climate change. Solve positive social change sanitation, opportunity insurmountable challenges...'
                                        }, {
                                            type: 'primary',
                                            allow_dismiss: true,
                                            newest_on_top: true,
                                            timer: 2000,
                                            placement: {
                                                from: 'top',
                                                align: 'left'
                                            },
                                            offset: {
                                                x: 30,
                                                y: 30
                                            },
                                            delay: 1000,
                                            z_index: 10000,
                                            animate: {
                                                enter: 'animated bounce',
                                                exit: 'animated bounce'
                                            }
                                        });
                                    });
                                </script>
                            @endif

                            <div class="form-group mt-3 border-top pt-3">
                                <label class="text-muted">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text text-secondary"><i
                                            class="fa-solid fa-envelope @error('email') text-danger @enderror"></i></span>
                                    <input type="email"
                                        class="form-control border-secondary @error('email') is-invalid @enderror"
                                        name="email" placeholder="Enter your email" autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="justify-content-center">
                                    <a href="/" class="btn float-start text-secondary">Back to Home</a>
                                    <button class="btn btn-dark btn-block" type="submit">Send Reset Link</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page-wrapper end-->
    <script src="{{ asset('user_assets/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    @livewireScripts()
</body>

</html>
