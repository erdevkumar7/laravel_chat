@extends('front.customer.layout')
@section('title', 'Vendor Dashboard')

@section('content')
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="{{ asset('public/front_asset/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Vendor List</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="active">Chat</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->
    <!-- Blog Archive -->
    <section id="aa-blog-archive">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-blog-archive-area">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Blog details -->
                                <div class="aa-blog-content aa-blog-details">
                                    <div class="aa-blog-comment-threat">
                                        <h3>Vendor Detail</h3>
                                        <div class="comments">
                                            <ul class="commentlist">
                                                @foreach ($vendors as $item)
                                                    <li>
                                                        <div class="media">
                                                            <div class="media-left">
                                                                <img class="media-object news-img"
                                                                    src="{{asset('public/front_asset/img/vendor_profile/'.$item->profile_pic)}}" alt="img">
                                                            </div>
                                                            <div class="media-body">
                                                                <h4 class="author-name">{{$item->name}}</h4>
                                                                <p>Lorem Ipsum is that it has a more-or-less normal
                                                                    distribution
                                                                    of letters, as opposed to using 'Content here, content</p>
                                                                <a href="{{route('customer.chat.view', $item->id)}}" class="reply-btn">Chat</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="aa-blog-archive-pagination">
                                            <nav>
                                                <ul class="pagination">
                                                    <li>
                                                        <a href="#" aria-label="Previous">
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                    </li>
                                                    <li><a href="#">1</a></li>
                                                    <li><a href="#">2</a></li>
                                                    <li><a href="#">3</a></li>
                                                    <li><a href="#">4</a></li>
                                                    <li><a href="#">5</a></li>
                                                    <li>
                                                        <a href="#" aria-label="Next">
                                                            <span aria-hidden="true">»</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
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
    <!-- / Blog Archive -->
@endsection
