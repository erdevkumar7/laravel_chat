@extends('front.vendor.layout')
@section('title', 'VendorAddProduct')

@section('content')
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="{{ asset('public/front_asset/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Add Product</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="active">Add Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->

    <section id="aa-contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-contact-area">

                        <div class="aa-contact-address">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="aa-contact-address-right">
                                        <address>
                                            <h2>Add Product</h2>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum modi dolor
                                                facilis! Nihil error, eius.</p>
                                            <p><span class="fa fa-home"></span>Huntsville, AL 35813, USA</p>
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="aa-contact-address-left">
                                        <form class="comments-form contact-form" action="{{ route('vendor.addProduct') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="productName">Product Name</label>
                                                        <input type="text" placeholder="Product Name" name="name"
                                                            value="{{ old('name') }}" id="productName"
                                                            class="form-control" oninput="removeError('nameErr')" required>
                                                        @error('name')
                                                            <small class="text-danger"
                                                                id='nameErr'>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="productCtegory">Category</label>
                                                        <select class="form-control" id="productCtegory" name="category_id"
                                                            oninput="removeError('categoryErr')" required>
                                                            <option value="">Choose Category</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ old('category->id') == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id')
                                                            <small class="text-danger"
                                                                id='categoryErr'>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="price">Price</label>
                                                        <input type="text" placeholder="Price" name="price"
                                                            value="{{ old('price') }}" class="form-control" oninput="removeError('priceErr')" required>
                                                        @error('price')
                                                            <small class="text-danger"
                                                                id='priceErr'>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="productImage">Product Image</label>
                                                    <div class="form-group">
                                                        <input type="file" name="product_image" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="productDescription">Product Description</label>
                                                <textarea class="form-control" name="description" placeholder="description ..." required
                                                    oninput="removeError('descriptionErr')">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <small class="text-danger" id='descriptionErr'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <button type="submit" class="aa-secondary-btn">Send</button>
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
@endsection
