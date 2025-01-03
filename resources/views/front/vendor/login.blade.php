@extends('front.vendor.layout')
@section('title', 'VendorLogin')

@section('content')
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="{{ asset('public/front_asset/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Account Page</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="active">Account</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->

    <!-- Cart view section -->
    <section id="aa-myaccount">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-myaccount-area">
                        <div class="row">
                            <div class="col-md-12 new_register_form">
                                <div class="aa-myaccount-register">

                                    <h4>Vendor Login</h4>
                                    <form action="{{ route('vendor.loginSubmit') }}" method="POST" class="aa-login-form">
                                        @csrf

                                        <div>
                                            <label for="emailAddress">Email address<span>*</span></label>
                                            <input type="text" placeholder="Email" name="email"
                                                value="{{ old('email') }}" id="emailAddress"
                                                oninput="removeError('invalidDataError')" required>
                                        </div>

                                        <div style="position: relative">
                                            <label for="passwordID">Password<span>*</span></label>
                                            <input type="password" name="password" placeholder="Password" id="passwordID"
                                                oninput="removeError('invalidDataError')" required>
                                            <i class="fa fa-eye eye-icon-positio" id="eyeIcon"
                                                style="position: absolute; right: 10px; top: 60%; transform: translateY(-40%); cursor: pointer;"></i>
                                        </div>
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <button type="submit" class="aa-browse-btn">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Cart view section -->
@endsection

@push('js')
    <script>
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
@endpush
