<div class="cart-view-area">
    @if ($cartItems->isEmpty())
        <div class="cart-view-table">
            <div class="cart-view-total">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Your Cart Empty</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <a href="{{ route('customer.getAllProduct') }}" class="aa-cart-view-btn">Go for Shopping</a>
            </div>
        </div>
    @else
        <div class="cart-view-table">
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
                                <td><a class="remove product-remove-from-cart" href="javascript:void(0)"
                                       data-cart-id="{{ $item->id }}">
                                        <fa class="fa fa-close"></fa>
                                    </a></td>
                                <td><a href="#"><img
                                            src="{{ asset('public/front_asset/img/product_img/' . ($item->product->product_image ?? 'default.png')) }}"
                                            alt="img"></a></td>
                                <td><a class="aa-cart-title" href="#">{{ $item->product->name }}</a></td>
                                <td>Rs.{{ $item->product->price }}</td>
                                <td><input class="aa-cart-quantity" type="number" value="{{ $item->quantity }}">
                                </td>
                                <td>Rs.{{ $item->quantity * $item->product->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                <a href="{{ route('customer.checkOut') }}" class="aa-cart-view-btn">Proceed to Checkout</a>
            </div>
        </div>
    @endif
</div>
