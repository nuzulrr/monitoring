<!doctype html>
<html lang="en">

<head>
    <title>Register | Network Monitoring MTT</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Codedthemes" />

    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="position-relative my-5">
                    <div class="auth-bg">
                        <span class="r"></span>
                        <span class="r s"></span>
                        <span class="r s"></span>
                        <span class="r"></span>
                    </div>
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="text-center">
                                <a href="#"><img src="{{ asset('assets/images/logo-dark.svg') }}" alt="img" /></a>
                            </div>
                            <h4 class="text-center f-w-500 mt-4 mb-3">Create Account</h4>

                            @if ($errors->any())
                            <div class="alert alert-danger p-2 small">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" name="name" class="form-control" placeholder="Full Name"
                                        value="{{ old('name') }}" required autofocus />
                                </div>

                                <div class="form-group mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address"
                                        value="{{ old('email') }}" required />
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <input type="password" name="secret_code" class="form-control"
                                            placeholder="Secret Invitation Code" required />
                                    </div>
                                    <small class="text-muted">Hubungi administrator PT Media Touch Technology untuk
                                        mendapatkan kode.</small>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        required />
                                    <small class="text-muted">Minimum 8 characters</small>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm Password" required />
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary shadow px-sm-4 w-100">Sign Up</button>
                                </div>
                            </form>

                            <div class="d-flex justify-content-between align-items-end mt-4">
                                <h6 class="f-w-500 mb-0">Already have an account?</h6>
                                <a href="{{ route('login') }}" class="link-primary">Login here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>

    <script>
        layout_change('light');
        preset_change('preset-1');

    </script>
</body>

</html>
