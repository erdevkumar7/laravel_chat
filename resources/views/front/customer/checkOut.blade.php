@extends('front.customer.layout')
@section('title', 'checkOut')
@push('css')
    <style>
        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* Align items vertically */
        }

        .editHeading {
            cursor: pointer;

        }

        .editHeading:hover {
            color: #ff6666;
        }

        .updateCancelBtn {
            align-items: center;
            gap: 30px;
        }


        h5.updateCancel {
            margin-bottom: 0;
            cursor: pointer;
        }

        h5.updateCancel:hover {
            color: #ff6666;
        }
    </style>
@endpush
@section('content')
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="{{ asset('public/front_asset/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Checkout Page</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="active">Checkout</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->
    <!-- Cart view section -->
    <section id="checkout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="checkout-area">
                        <div class="row">
                            <div class="col-md-8">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <div class="checkout-left">
                                    <form action="{{ route('customer.addOrEditAddress') }}" method="POST">
                                        @csrf
                                        <div class="panel-group" id="accordion">
                                            <!-- Shipping Address -->
                                            <div class="panel panel-default aa-checkout-billaddress">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion">
                                                            Delivery Address
                                                        </a>
                                                    </h4>
                                                    <h5 class="panel-title editHeading">Add/Edit</h5>
                                                </div>
                                                <div id="collapseFour" class="panel-collapse collapse in">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" name="name"
                                                                        value="{{ old('name', $shipping->name ?? '') }}"
                                                                        placeholder="Full Name*" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="tel" name="mobile_number"
                                                                        value="{{ old('mobile_number', $shipping->mobile_number ?? '') }}"
                                                                        placeholder="Phone*" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="aa-checkout-single-bill">
                                                                    <textarea cols="8" name="address_line_1" rows="3" placeholder="Address*" disabled>{{ old('address_line_1', $shipping->address_line_1 ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="aa-checkout-single-bill">
                                                                    <select name="state" disabled>
                                                                        <option value="" selected>--- Select State ---
                                                                        </option>
                                                                        @foreach ($stateCity as $state => $districts)
                                                                            <option value="{{ $state }}"
                                                                                {{ old('state', $shipping->state) == $state ? 'selected' : '' }}>
                                                                                {{ $state }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" name="address_line_2"
                                                                        placeholder="Appartment, Suite etc."
                                                                        value="{{ old('address_line_2', $shipping->address_line_2 ?? '') }}"
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" name="city"
                                                                        value="{{ old('city', $shipping->city ?? '') }}"
                                                                        placeholder="City / Town*" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" name="land_mark"
                                                                        value="{{ old('land_mark', $shipping->land_mark ?? '') }}"
                                                                        placeholder="Landmark (Optional)" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" name="postal_code"
                                                                        value="{{ old('postal_code', $shipping->postal_code ?? '') }}"
                                                                        placeholder="Postcode / ZIP*" disabled>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="updateCancelBtn" style="display:none">
                                                            <button type="submit" style="border:1px solid #ff6666;"
                                                                class="aa-secondary-btn">Add/Update Address</button>
                                                            <h5 class="updateCancel">Cancel</h5>
                                                        </div>
                                                        {{-- <input type="submit" value="Edit" class="aa-browse-btn"> --}}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="checkout-right">
                                    <form action="{{route('payment.create')}}" method="POST">
                                        @csrf
                                        <h4>Order Summary</h4>
                                        <div class="aa-order-summary-area">
                                            <table class="table table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cartItems as $item)
                                                        <tr>
                                                            <td>{{ $item->product->name }} <strong> x
                                                                    {{ $item->quantity }}</strong></td>
                                                            <td>Rs.{{ $item->product->price * $item->quantity }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Subtotal</th>
                                                        <td>Rs.{{ $totalAmount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Shipping Charge</th>
                                                        <td>Rs.56</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total</th>
                                                        <td>Rs.{{ $totalAmount + 56 }}</td>
                                                        <input type="hidden" name="total_amount" value="{{ $totalAmount + 56 }}">
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <h4>Payment Method</h4>
                                        <div class="aa-payment-method">
                                            <label for="cashdelivery"><input type="radio" id="cashdelivery"
                                                    name="optionsRadios"> Cash on Delivery </label>
                                            <label for="paypal"><input type="radio" id="paypal"
                                                    name="optionsRadios" checked> Via Paypal </label>
                                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg"
                                                border="0" alt="PayPal Acceptance Mark">
                                            {{-- <a href="{{ route('paypal.checkout') }}" class="btn btn-primary">Pay with PayPal</a> --}}
                                            <input type="submit" value="Place Order" class="aa-browse-btn">
                                        </div>
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
        document.querySelector('.editHeading').addEventListener('click', function() {
            document.querySelectorAll(
                    '.aa-checkout-single-bill input, .aa-checkout-single-bill textarea, .aa-checkout-single-bill select'
                )
                .forEach(field => {
                    field.removeAttribute('disabled'); // Enable the field
                });

            const elent = document.querySelector('.updateCancelBtn')
            elent.style = 'display:flex';
            this.style = 'display:none';
        });

        document.querySelector('.updateCancel').addEventListener('click', function() {
            document.querySelectorAll(
                    '.aa-checkout-single-bill input, .aa-checkout-single-bill textarea, .aa-checkout-single-bill select'
                )
                .forEach(field => {
                    field.setAttribute('disabled', 'disabled'); //Disabled field
                });

            const editHeading = document.querySelector('.editHeading');
            editHeading.style.display = 'block'; // Show Edit button

            const element = document.querySelector('.updateCancelBtn');
            element.style.display = 'none'; // Hide Update/Cancel buttons

        })
    </script>
@endpush
