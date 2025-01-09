@extends('front.customer.layout')
@section('title', 'productDetail')

@section('content')
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="{{ asset('public/front_asset/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Product Detail</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="active">Product Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->

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
                                                            src="{{ asset('public/front_asset/img/product_img/'.($product->product_image ?? 'default.png')) }}"
                                                            class="simpleLens-big-image"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal view content -->
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="aa-product-view-content">
                                        <h3>{{ $product->name ?? 'N/A' }}</h3>
                                        <div class="aa-price-block">
                                            <span class="aa-product-view-price">Rs.{{ $product->price }}</span>
                                            <p class="aa-product-avilability">
                                                @if ($product->is_available)
                                                    Availability: <span>In stock</span>
                                                @else
                                                    Availability: <span>Out stock</span>
                                                @endif
                                            </p>
                                        </div>
                                        <p>{{ $product->description }}</p>
                                        <h4>Size</h4>
                                        <div class="aa-prod-view-size">
                                            <a href="#">S</a>
                                            <a href="#">M</a>
                                            <a href="#">L</a>
                                            <a href="#">XL</a>
                                        </div>
                                        <h4>Color</h4>
                                        <div class="aa-color-tag">
                                            <a href="#" class="aa-color-green"></a>
                                            <a href="#" class="aa-color-yellow"></a>
                                            <a href="#" class="aa-color-pink"></a>
                                            <a href="#" class="aa-color-black"></a>
                                            <a href="#" class="aa-color-white"></a>
                                        </div>
                                        <div class="aa-prod-quantity">
                                            <form action="">
                                                <select id="" name="">
                                                    <option selected="1" value="0">1</option>
                                                    <option value="1">2</option>
                                                    <option value="2">3</option>
                                                    <option value="3">4</option>
                                                    <option value="4">5</option>
                                                    <option value="5">6</option>
                                                </select>
                                            </form>
                                            <p class="aa-prod-category">
                                                Category: <a href="#">{{ $product->category->name }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="aa-product-details-bottom">
                            <ul class="nav nav-tabs" id="myTab2">
                                <li><a href="#description" data-toggle="tab">Description</a></li>
                                <li><a href="#review" data-toggle="tab">Reviews</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="description">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                                        the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                                        with desktop publishing software like Aldus PageMaker including versions of Lorem
                                        Ipsum.</p>
                                    <ul>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod, culpa!</li>
                                        <li>Lorem ipsum dolor sit amet.</li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor qui eius esse!
                                        </li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam, modi!</li>
                                    </ul>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, iusto earum
                                        voluptates autem esse molestiae ipsam, atque quam amet similique ducimus aliquid
                                        voluptate perferendis, distinctio!</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis ea, voluptas!
                                        Aliquam facere quas cumque rerum dolore impedit, dicta ducimus repellat dignissimos,
                                        fugiat, minima quaerat necessitatibus? Optio adipisci ab, obcaecati, porro unde
                                        accusantium facilis repudiandae.</p>
                                </div>
                                <div class="tab-pane fade " id="review">
                                    <div class="aa-product-review-area">
                                        <h4>2 Reviews for T-Shirt</h4>
                                        <ul class="aa-review-nav">
                                            <li>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object" src="img/testimonial-img-3.jpg"
                                                                alt="girl image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><strong>Marla Jobs</strong> - <span>March
                                                                26, 2016</span></h4>
                                                        <div class="aa-product-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star-o"></span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object" src="img/testimonial-img-3.jpg"
                                                                alt="girl image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><strong>Marla Jobs</strong> - <span>March
                                                                26, 2016</span></h4>
                                                        <div class="aa-product-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star-o"></span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <h4>Add a review</h4>
                                        <div class="aa-your-rating">
                                            <p>Your Rating</p>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                        </div>
                                        <!-- review form -->
                                        <form action="" class="aa-review-form">
                                            <div class="form-group">
                                                <label for="message">Your Review</label>
                                                <textarea class="form-control" rows="3" id="message"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="example@gmail.com">
                                            </div>

                                            <button type="submit"
                                                class="btn btn-default aa-review-submit">Submit</button>
                                        </form>
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
