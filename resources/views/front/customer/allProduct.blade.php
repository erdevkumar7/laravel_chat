@extends('front.customer.layout')
@section('title', 'productList')

@section('content')
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="{{ asset('public/front_asset/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Product List</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="active">all product</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->

      <!-- product category -->
  <section id="aa-product-category">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
          <div class="aa-product-catg-content">
            <div class="aa-product-catg-head">
              <div class="aa-product-catg-head-left">
                <form action="" class="aa-sort-form">
                  <label for="">Sort by</label>
                  <select name="">
                    <option value="1" selected="Default">Default</option>
                    <option value="2">Name</option>
                    <option value="3">Price</option>
                    <option value="4">Date</option>
                  </select>
                </form>
                <form action="" class="aa-show-form">
                  <label for="">Show</label>
                  <select name="">
                    <option value="1" selected="12">12</option>
                    <option value="2">24</option>
                    <option value="3">36</option>
                  </select>
                </form>
              </div>
              <div class="aa-product-catg-head-right">
                <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
              </div>
            </div>
            <div class="aa-product-catg-body">
              <ul class="aa-product-catg">
                <!-- start single product item -->
                @foreach($allProduct as $product)
                <li>
                  <figure>
                    <a class="aa-product-img" href="#"><img src="{{asset('public/front_asset/img/product_img/'.($product->product_image ?? 'default.png'))}}" alt="img"></a>
                    <a class="aa-add-card-btn"href="#"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                    <figcaption>
                      <h4 class="aa-product-title"><a href="#">{{$product->name}}</a></h4>
                      <span class="aa-product-price">Rs.{{$product->price ?? 'N/A'}}</span>
                      <p class="aa-product-descrip">{{$product->description}}.</p>
                    </figcaption>
                  </figure>                  
                </li>
                @endforeach
                <!-- start single product item -->                                                     
              </ul>              
            </div>
            {{-- <div class="aa-product-catg-pagination">
              <nav>
                <ul class="pagination">
                  <li>
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div> --}}
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
          <aside class="aa-sidebar">
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Category</h3>
              <ul class="aa-catg-nav">
                @foreach($allCategories as $category )
                <li><a href="#">{{$category->name ?? 'N/A'}}</a></li>
                @endforeach
              </ul>
            </div>
            <!-- single sidebar -->      
          </aside>
        </div>
       
      </div>
    </div>
  </section>
  <!-- / product category -->

@endsection