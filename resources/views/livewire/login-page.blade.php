{{-- New Login Panel --}}
<section>
    <div class="row">
        <div class="col-xl-7 order-1 d-flex align-self-center justify-item-center justify-content-center"><img
                class="bg-img-cover bg-center" src="{{ asset('user_assets/images/login/1.jpg') }}" alt="looginpage">
        </div>
        <div class="col-xl-5 p-0">
            <div class="login-card">
                <div class="col-9 mx-auto">
                    <div class="card border-0 shadow rounded-3 my-5">
                        <div class="card-body p-4 p-sm-5">
                            <div class="logo-wrapper pb-2 border-bottom text-center"><a href="#"><img
                                        class="img-fluid"
                                        src="{{ asset('talkster/chatify-high-resolution-logo-color-on-transparent-background.png') }}"
                                        width="70%" alt=""></a></div>
                            <h5 class="card-title text-center mt-3 mb-5 fw-bold fs-5">User Login</h5>

                            @if (Session::has('updateSuccess'))
                                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                                    role="alert">
                                    Registration success!
                                    <i class="fas fa-trash fa-lg text-danger float-end" data-bs-dismiss="alert"
                                        aria-label="Close" style="cursor: pointer;"></i>
                                </div>
                            @endif

                            @if (session('disabled_user'))
                                <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center"
                                    role="alert">
                                    @if(session('disabled_user')->account_inactive_reason == 'Admin Banned')
                                        Chatify has suspended this account. <br>
                                    @else
                                        This account has been deactivated! <br>
                                    @endif
                                   Since : {{ session('disabled_user')->account_inactive_since}} <br>
                                   Kindly! create a new account
                                    <i class="fas fa-trash fa-lg text-dark float-end" data-bs-dismiss="alert"
                                        aria-label="Close" style="cursor: pointer;"></i>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login_status') }}">
                                @csrf
                                <div class="form-group form-floating mb-3">
                                    <input name="email" type="email"
                                        class="form-control rounded-pill form-control-user @error('email') is-invalid @enderror"
                                        id="exampleInputEmail"
                                        @if (isset($_COOKIE['saved_email']) && $_COOKIE['saved_email'] != '') value="{{ $_COOKIE['saved_email'] }}"
                                        @else
                                            value="{{ old('email') }}" @endif
                                        placeholder="Email Address" autocomplete="current-email">
                                    <label for="exampleInputEmail">Email Address</label>
                                    {{-- email error feedback --}}
                                    @error('email')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-floating mb-3">
                                    <input name="password" type="password"
                                        class="form-control rounded-pill form-control-user @error('password') is-invalid @enderror"
                                        id="floatingPassword"
                                        @if (isset($_COOKIE['saved_password']) && $_COOKIE['saved_password'] != '') value="{{ $_COOKIE['saved_password'] }}" @endif
                                        placeholder="Password" autocomplete="current-password">
                                    {{-- password error feedback --}}
                                    @error('password')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <label for="floatingPassword">Password</label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="rememberPasswordCheck"
                                        name="rememberMe" @if (isset($_COOKIE['saved_email'])) checked @endif>
                                    <label class="form-check-label text-muted" for="rememberPasswordCheck">
                                        Remember me
                                    </label>
                                    <a href="{{ route('password.request') }}" class="float-end text-danger">Forget
                                        Password?</a>
                                </div>
                                <div class="d-grid">
                                    <div class="text-center">

                                        <button class="btn rounded-pill btn-info btn-login text-uppercase fw-bold"
                                            type="submit">Sign
                                            in</button>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <div class="d-grid mb-2 text-center">
                                    <span class="text text-uppercase">
                                        Don't have an account?
                                    </span>
                                </div>
                                <div class="d-grid">
                                    <a class="btn btn-register btn-login text-uppercase fw-bold"
                                        href="{{ route('user_register') }}">
                                        Register
                                    </a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
