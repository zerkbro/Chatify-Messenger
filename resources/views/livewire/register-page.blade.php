{{-- <div class="row d-flex justify-content-center align-items-center mt-5" style="min-height: 80vh;">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
            <div class="card-body p-4 p-sm-5">
                <h5 class="card-title text-center mb-5 fw-light fs-5">User Registration!</h5>
                <form method="POST" action="{{ route('user_signup') }}" class="user">
                    @csrf
                    <div class="form-group form-floating mb-3">
                        <input type="email" name="email" wire:model.lazy="email"
                            class="form-control form-control-user @error('email') is-invalid @enderror"
                            id="exampleInputEmail" value="{{ old('email') }}" placeholder="Email Address">
                        <label for="exampleInputEmail">Email Address</label>
                        @error('email')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-floating mb-3">
                        <input wire:model="password" name="password" type="password"
                            class="form-control form-control-user @error('password') is-invalid @enderror"
                            id="floatingPassword" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-group form-floating mb-3">
                        <input wire:model="password_confirmation" name="password_confirmation" type="password"
                            class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                            id="floatingConfirmPassword" placeholder="Confirm Password">
                        @error('password_confirmation')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                        <label for="floatingConfirmPassword">Confirm Password</label>
                    </div>


                    <div class="d-grid">
                        <button class="btn pill btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                            up</button>
                    </div>
                    <hr class="my-4">
                    <div class="d-grid mb-2 text-center">
                        <span class="text text-uppercase">
                            Already have an account?
                        </span>
                    </div>
                    <div class="d-grid">
                        <a class="btn btn-register btn-login text-uppercase fw-bold" href="{{ route('user_login') }}">
                            Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

<section>
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-xl-6 p-0">
                <div class="login-card">
                    {{-- <div class="col-sm-9 col-md-7 col-lg-5 mx-auto"> --}}
                    <div class="container-fluid">
                        <div class="card border-0 shadow rounded-3 my-5">
                            <div class="card-body p-4 p-sm-5">
                            <div class="logo-wrapper pb-2 border-bottom text-center"><a href="#"><img class="img-fluid" src="{{ asset('talkster/chatify-high-resolution-logo-color-on-transparent-background.png') }}" alt="" width="45%"></a></div>
                                <h5 class="card-title text-center mt-3 mb-5 fw-light fs-5">User Registration!</h5>
                                <form method="POST" action="{{ route('user_signup') }}" class="user">
                                    @csrf
                                    <div class="form-group form-floating mb-3">
                                        <input wire:model="first_name" name="first_name" type="text"
                                            class="form-control rounded-pill form-control-user @error('first_name') is-invalid @else border-success @enderror"
                                            id="floatingfirst_name" placeholder="First Name" autocomplete="given-name">
                                        @error('first_name')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                        <label for="floatingfirst_name">First Name</label>
                                    </div>
                                    <div class="form-group form-floating mb-3">
                                        <input wire:model="last_name" name="last_name" type="text"
                                            class="form-control rounded-pill form-control-user @error('last_name') is-invalid @else border-success @enderror"
                                            id="floatinglast_name" placeholder="Last Name" autocomplete="family-name">
                                        @error('last_name')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                        <label for="floatinglast_name">Last Name</label>
                                    </div>

                                    <div class="form-group form-floating mb-3">
                                        <input type="email" name="email" wire:model.lazy="email"
                                            class="form-control rounded-pill form-control-user @error('email') is-invalid @else border-success @enderror"
                                            id="exampleInputEmail" value="{{ old('email') }}"
                                            placeholder="Email Address" autocomplete="new-email">
                                        <label for="exampleInputEmail">Email Address</label>
                                        @error('email')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-floating mb-3">
                                        <input wire:model="password" name="password" type="password"
                                            class="form-control rounded-pill form-control-user @error('password') is-invalid @else border-success @enderror"
                                            id="floatingPassword" placeholder="Password" autocomplete="new-password">
                                        @error('password')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <div class="form-group form-floating mb-3">
                                        <input wire:model="password_confirmation" name="password_confirmation"
                                            type="password"
                                            class="form-control rounded-pill form-control-user @error('password_confirmation') is-invalid @else border-success @enderror"
                                            id="floatingConfirmPassword" placeholder="Confirm Password" autocomplete="new-password">
                                        @error('password_confirmation')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                        <label for="floatingConfirmPassword">Confirm Password</label>
                                    </div>


                                    <div class="d-grid">
                                        <div class="text-center">

                                            <button class="btn pill btn-dark rounded-pill btn-login text-uppercase fw-bold"
                                            type="submit">Sign
                                            up</button>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="d-grid mb-2 text-center">
                                        <span class="text text-uppercase">
                                            Already have an account?
                                        </span>
                                    </div>
                                    <div class="d-grid">
                                        <a class="btn btn-register btn-login text-uppercase fw-bold"
                                            href="{{ route('user_login') }}">
                                            Login
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-6 d-flex align-self-center justify-content-center"><img class="bg-img-cover bg-center" src="{{ asset('user_assets/images/login/3.jpg') }}"
                alt="registerpage"></div>
        </div>
    </div>
</section>
