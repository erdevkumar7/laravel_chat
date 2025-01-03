@extends('front.vendor.layout')
@section('title', 'VendorRegister')
@section('content')
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="{{ asset('public/front_asset/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Account Page</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{route('home')}}">Home</a></li>
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
                                    <h4>Vendor Register</h4>
                                    <form action="{{ route('vendor.registerSubmit') }}" method="POST"
                                        class="aa-login-form">
                                        @csrf
                                        <div>
                                            <input type="text" placeholder="Name" name="name" id="inputName"
                                                value="{{ old('name') }}" oninput="removeError('nameErr')">
                                            @error('name')
                                                <span class="text-danger" id="nameErr">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <input type="text" placeholder="Email" name="email" id="emailAddress"
                                                value="{{ old('email') }}" oninput="removeError('emailErr')">
                                            @error('email')
                                                <span class="text-danger" id="emailErr">{{ $message }} </span>
                                            @enderror
                                        </div>

                                        <div>
                                            <input type="text" placeholder="Mobile Number" name="mobile_number"
                                                id="mobileMobile" value="{{ old('mobile_number') }}"
                                                oninput="removeError('mobileErr')">
                                            @error('mobile_number')
                                                <span class="text-danger" id="mobileErr">{{ $message }} </span>
                                            @enderror
                                        </div>

                                        <div>
                                            <div style="position: relative">
                                                <input type="password" name="password" placeholder="Password"
                                                    id="passwordID" oninput="removeError('passwordErr')">
                                                <i class="fa fa-eye eye-icon-positio" id="eyeIcon"
                                                    style="position: absolute; right: 10px; top: 40%; transform: translateY(-60%); cursor: pointer;"></i>
                                            </div>
                                            @error('password')
                                                <span class="text-danger" id="passwordErr">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <button type="submit" class="aa-browse-btn">Register</button>
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