@extends('front.customer.layout')
@section('title', 'viewOrderItem')

@section('content')
    <!-- product category -->
    <section id="aa-product-details">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-product-details-area">
                        <div class="aa-product-details-content">
                            <div class="row">
                                <!-- Modal view slider -->
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="aa-product-view-slider">
                                        <div id="demo-1" class="simpleLens-gallery-container">
                                            <div class="simpleLens-container">
                                                <div class="simpleLens-big-image-container"><a
                                                        class="simpleLens-lens-image"><img
                                                            src="{{ asset('public/front_asset/img/product_img/' . ($orderItem->product->product_image ?? 'default.png')) }}"
                                                            class="simpleLens-big-image"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal view content -->
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="aa-product-view-content">
                                        <h3>{{ $orderItem->product->name ?? 'N/A' }}</h3>
                                        <div class="aa-price-block">
                                            Price: <span class="aa-product-view-price"> Rs.{{ $orderItem->price }}</span>
                                        </div>
                                        <p>Description: {{ $orderItem->product->description }}</p>
                                        <div class="aa-prod-quantity">
                                            <form action="">
                                                <label>Quantity :</label>
                                                <select id="productQuantityId" name="" disabled>
                                                    <option selected="{{ $orderItem->quantity }}"
                                                        value="{{ $orderItem->quantity }}">{{ $orderItem->quantity }}
                                                    </option>
                                                </select>
                                            </form>
                                            <p class="aa-prod-category">
                                                <label>Category :</label>{{ $orderItem->product->category->name }}
                                            </p>
                                        </div>
                                        <div class="aa-price-block">
                                            <p class="aa-product-avilability"><label>Delivery Status :</label>
                                                <span>{{ $orderItem->order->order_status }}</span></p>
                                        </div>
                                        <div class="aa-prod-view-bottom">
                                            <a class="aa-add-to-cart-btn" href="javascript:void(0)">Chat with us</a>
                                            <a class="aa-add-to-cart-btn" href="#">Rate & Review Product</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / product category -->
@endsection
