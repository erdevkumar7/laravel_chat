<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <!-- Title Page-->
    <title>Register</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('public/admin_asset/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('public/admin_asset/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('public/admin_asset/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('public/admin_asset/vendor/mdi-font/css/material-design-iconic-font.min.css') }}"
        rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('public/admin_asset/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet"
        media="all">
    <!-- Main CSS-->
    <link href="{{ asset('public/admin_asset/css/theme.css') }}" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="{{ asset('public/admin_asset/images/icon/logo.png') }}" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="{{ route('admin.registerSubmit') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Fullname</label>
                                    <input class="au-input au-input--full" type="text" name="name"
                                        value="{{ old('name') }}" placeholder="Fullname"
                                        oninput="removeError('nameError')" required>
                                    @error('name')
                                        <span class="text-danger" id="nameError">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email"
                                        value="{{ old('email') }}" placeholder="Email"
                                        oninput="removeError('emailError')" required>
                                    @error('email')
                                        <span class="text-danger" id='emailError'>{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <div style="position: relative;">
                                        <input class="au-input au-input--full" type="password" name="password"
                                            id="passwordID" placeholder="Password"
                                            oninput="removeError('passwordError')" required>
                                        <i class="fa fa-eye eye-icon-positio" id="eyeIcon"
                                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                                    </div>
                                    @error('password')
                                        <span class="text-danger" id='passwordError'>{{ $message }}</span>
                                    @enderror
                                </div>

                                <button class="au-btn au-btn--block au-btn--green m-b-20"
                                    type="submit">register</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Already have account?
                                    <a href="{{ route('admin.login') }}">Sign In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('public/admin_asset/vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('public/admin_asset/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('public/admin_asset/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
    <script src="{{ asset('public/admin_asset/vendor/animsition/animsition.min.js') }}"></script>
    <!-- Main JS-->
    <script src="{{ asset('public/admin_asset/js/main.js') }}"></script>
    <!-- For additional page-specific JS -->
    <script>
        function removeError(id) {
            var errElement = document.getElementById(id);
            if (errElement) {
                errElement.style.display = 'none'
            }
        }

        // Password field toggle
        document.getElementById('eyeIcon').addEventListener('click', function() {
            var passwordField = document.getElementById('passwordID');
            var icon = document.getElementById('eyeIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>
<!-- end document-->
