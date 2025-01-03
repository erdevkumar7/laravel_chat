@extends('front.customer.layout')
@section('title', 'Chat')

@section('content')
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="{{ asset('public/front_asset/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Customer Chat</h2>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="active">Message</li>
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
                                        <h3>Messages </h3>
                                        <div class="comments">
                                            <ul class="commentlist">
                                                <li>
                                                    @foreach ($messages as $item)
                                                        <div>
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <img class="media-object news-img"
                                                                        src="{{ asset('public/front_asset/img/testimonial-img-3.jpg') }}"
                                                                        alt="img">
                                                                </div>
                                                                <div class="media-body">
                                                                    <h4 class="author-name">Charlie Balley</h4>
                                                                    <span class="comments-date"> March 26th 2016</span>
                                                                    <p>{{ $item->message }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                    <!-- blog comments form -->
                                    <div id="respond">
                                        <h3 class="reply-title">Send Message</h3>
                                        <form id="commentform" action="{{ route('customer.chat.send') }}" method="POST">
                                            @csrf
                                            <p class="comment-form-author">
                                                <input type="text" value="" size="30" name="message"
                                                    required="required">
                                            </p>

                                            <p class="form-submit">
                                                <input type="submit" name="submit" class="aa-browse-btn" value="Send">
                                            </p>
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
    <script>
        import Echo from 'laravel-echo';
        import Pusher from 'pusher-js';

        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'e213caea4a6a3e34a436',
            cluster: 'ap2',
            forceTLS: false,
        });

        window.Echo.private(`chat.${vendorId}`)
            .listen('ChatMessageSent', (event) => {
                console.log(event.chat);
                // Update your chat UI here
            });
    </script>
    <!-- / Blog Archive -->
@endsection
