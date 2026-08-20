<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Synergic Service Login</title>
    <link rel="stylesheet" href="{{ asset('public/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet" href="{{ asset('public/css/vertical-layout-light/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('public/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                            <h4><center>Synergic Service Login</center></h4>
                            </div>
                            <!-- <h4><center>Maity Wine Shop</center></h4> -->
                            <!-- <h6 class="font-weight-light">Sign in to continue.</h6> -->
                            @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <form class="pt-3" method="post" action="{{route('login')}}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control form-control-lg" id="exampleInputEmail1"
                                        value="{{ old('email') }}" placeholder="Email or Username" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        id="exampleInputPassword1" placeholder="Password" required>
                                </div>
                                <div class="mt-3">
                                    <input type="submit" id="submit" value="SIGN IN" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                    <!-- <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        href="../../index.html">SIGN IN</a> -->
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <!-- <input type="checkbox" class="form-check-input">
                                            Keep me signed in -->
                                        </label>
                                    </div>
                                </div>
                                <!-- <div class="mb-2">
                                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                                        <i class="mdi mdi-facebook mr-2"></i>Connect using facebook
                                    </button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Don't have an account? <a href="register.html" class="text-primary">Create</a>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('public/js/off-canvas.js') }}"></script>
    <script src="{{ asset('public/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('public/js/template.js') }}"></script>
    <script src="{{ asset('public/js/settings.js') }}"></script>
    <script src="{{ asset('public/js/todolist.js') }}"></script>
</body>

</html>