@extends('front.customer.layout')
@section('title', 'viewOrder')
@push('css')
    <style>
        #cart-view .cart-view-area {
            padding-bottom: 50px;
        }

        #cart-view .cart-view-area .cart-view-table {
            min-height: 0px !important;
        }

        .order-item-title {
            display: flex;
            justify-content: space-between;
            align-items: center
        }
    </style>
@endpush
@section('content')
    <!-- Cart view section -->
    <section id="cart-view">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-view-area">
                        @if (isset($orders) && $orders->isEmpty())
                            <div class="cart-view-table">
                                <div class="cart-view-total">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No Order Placed</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="{{ route('customer.getAllProduct') }}" class="aa-cart-view-btn">Go for
                                        Shopping</a>
                                </div>
                            </div>
                        @elseif (isset($orders))
                            @foreach ($orders as $order)
                                <div class="cart-view-table">
                                    <form action="">
                                        <div class="table-responsive">
                                            <div class="order-item-title">
                                                <h2>Order Items:</h2>
                                                <a href="{{ route('customer.viewOrder', $order->id) }}">
                                                    <p><strong>Order ID:</strong> {{ $order->id }}</p>
                                                </a>
                                                <p><strong>Delivery Status:</strong> {{ $order->order_status }}</p>
                                                {{-- <p><strong>Total Amount:</strong> {{ $order->total_amount }}</p> --}}
                                                <p><strong>Payment:</strong> {{ $order->payment_status }}</p>
                                            </div>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->order_items as $item)
                                                        <tr>
                                                            <td><a
                                                                    href="{{ route('customer.getProductDetail', $item->product->id) }}"><img
                                                                        src="{{ asset('public/front_asset/img/product_img/' . ($item->product->product_image ?? 'default.png')) }}"
                                                                        alt="img"></a></td>
                                                            <td><a class="aa-cart-title"
                                                                    href="{{ route('customer.getProductDetail', $item->product->id) }}">{{ $item->product->name }}</a>
                                                            </td>
                                                            <td>Rs.<span class="product-price"
                                                                    data-price="{{ $item->product->price }}">{{ $item->product->price }}</span>
                                                            </td>
                                                            <td>
                                                                <input class="aa-cart-quantity" type="number"
                                                                    value="{{ $item->quantity }}"
                                                                    data-cart-id="{{ $item->id }}" disabled>
                                                            </td>
                                                            <td>Rs.<span
                                                                    class="product-total-price">{{ $item->quantity * $item->product->price }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        @elseif (isset($order))
                            <div class="cart-view-table">
                                <form action="">
                                    <div class="table-responsive">
                                        <div class="order-item-title">
                                            <h2>Order Items:</h2>
                                            <p><strong>Order ID:</strong> {{ $order->id }}</p>
                                            <p><strong>Delivery Status:</strong> {{ $order->order_status }}</p>
                                            {{-- <p><strong>Total Amount:</strong> {{ $order->total_amount }}</p> --}}
                                            <p><strong>Payment:</strong> {{ $order->payment_status }}</p>
                                        </div>
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
                                                @foreach ($order->order_items as $item)
                                                    <tr>
                                                        <td><a
                                                                href="{{ route('customer.viewOrderItem', $item->id) }}">{{ $item->id }}</a>
                                                        </td>
                                                        <td><a
                                                                href="{{ route('customer.getProductDetail', $item->product->id) }}"><img
                                                                    src="{{ asset('public/front_asset/img/product_img/' . ($item->product->product_image ?? 'default.png')) }}"
                                                                    alt="img"></a></td>
                                                        <td><a class="aa-cart-title"
                                                                href="{{ route('customer.getProductDetail', $item->product->id) }}">{{ $item->product->name }}</a>
                                                        </td>
                                                        <td>Rs.<span class="product-price"
                                                                data-price="{{ $item->product->price }}">{{ $item->product->price }}</span>
                                                        </td>
                                                        <td>
                                                            <input class="aa-cart-quantity" type="number"
                                                                value="{{ $item->quantity }}"
                                                                data-cart-id="{{ $item->id }}" disabled>
                                                        </td>
                                                        <td>Rs.<span
                                                                class="product-total-price">{{ $item->quantity * $item->product->price }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Cart view section -->
@endsection
