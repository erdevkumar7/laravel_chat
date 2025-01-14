@extends('front.customer.layout')
@section('title', 'viewCart')

@section('content')
    <!-- Cart view section -->
    <section id="cart-view">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-view-area">
                        <div class="cart-view-table">
                            <form action="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cartItems as $item)
                                                <tr>
                                                    <td><a class="remove" href="#">
                                                            <fa class="fa fa-close"></fa>
                                                        </a></td>
                                                    <td><a href="#"><img
                                                                src="{{ asset('public/front_asset/img/product_img/' . ($item->product->product_image ?? 'default.png')) }}"
                                                                alt="img"></a></td>
                                                    <td><a class="aa-cart-title"
                                                            href="#">{{ $item->product->name }}</a></td>
                                                    <td>Rs.{{ $item->product->price }}</td>
                                                    <td><input class="aa-cart-quantity" type="number"
                                                            value="{{ $item->quantity }}"></td>
                                                    <td>Rs.{{ $item->quantity * $item->product->price }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            <!-- Cart Total view -->
                            <div class="cart-view-total">
                                <h4>Cart Totals</h4>
                                <table class="aa-totals-table">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>Rs.{{ $cartItems->sum(fn($item) => $item->quantity * $item->product->price) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{route('customer.checkOut')}}" class="aa-cart-view-btn">Proced to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Cart view section -->
@endsection
