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
                                            @foreach ($cartItems as $index => $item)
                                                <tr>
                                                    <td><a class="remove" href="#">
                                                            <fa class="fa fa-close"></fa>
                                                        </a></td>
                                                    <td><a href="#"><img src="img/man/polo-shirt-1.png"
                                                                alt="img"></a></td>
                                                    <td><a class="aa-cart-title" href="#">{{ $item['name'] }}</a></td>
                                                    <td>Rs.{{ $item['price'] }}</td>
                                                    <td><input class="aa-cart-quantity" type="number" value="{{$item['quantity']}}"></td>
                                                    <td>Rs.{{ $item['total'] }}</td>
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
                                            <td>$450</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="aa-cart-view-btn">Proced to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Cart view section -->
@endsection
