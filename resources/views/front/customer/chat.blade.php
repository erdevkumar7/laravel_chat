@extends('front.customer.layout')
@section('title', 'Chat')

@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('e213caea4a6a3e34a436', {
            authEndpoint: '/projecthub/pusher/auth', // Specify the custom
            cluster: 'ap2',
            forceTLS: true,
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token for security
                },
            },
        });

        const channel = pusher.subscribe('private-chat.{{ $common_chat_id }}');
        // Handle subscription success
        channel.bind('pusher:subscription_succeeded', () => {
            console.log('Successfully subscribed to private-chat.{{ $common_chat_id }}');
        });

        channel.bind('App\\Events\\ChatMessageSent', function(data) {
            console.log('Message received:', data);

            const userId = {{ Auth::guard('web')->user()->id }}; // Pass the authenticated user's ID from Blade
            const vendorProfilePic =
                "{{ asset('public/front_asset/img/vendor_profile/' . ($vendor->profile_pic ?? 'default.png')) }}";
            const customerProfilePic =
                "{{ asset('public/front_asset/img/customer_profile/' . (Auth::guard('web')->user()->profile_pic ?? 'default.png')) }}";
            const messageSender = data.sender_id == userId ? 'You' : 'Vendor';
            const profilePic = data.sender_id == userId ? customerProfilePic : vendorProfilePic;
            // const message = `
        //  <p> 
        //    <strong>${data.sender_id == {{ Auth::guard('web')->user()->id }} ? 'You' : 'Vendor'}:</strong> ${data.message}
        //    <span class="text-muted small">${data.created_at}</span>
        //  </p>`;

            const message = `
        <li> 
           <div class="media">
            <div class="media-left">
                <img class="media-object news-img" src="${profilePic}" alt="img">
            </div>
            <div class="media-body">
                <h4 class="author-name">${messageSender}</h4>
                <span class="comments-date">${data.created_at}</span>
                <p>${data.message}</p>
            </div>
        </div>
        </li>`;
            document.querySelector('#messages').innerHTML += message;
        });
    </script>
@endpush

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
                                            <ul class="commentlist" id="messages">
                                                @foreach ($messages as $message)
                                                    <li>
                                                        <div class="media">
                                                            <div class="media-left">
                                                                @if ($message->sender_id == Auth::guard('web')->user()->id)
                                                                    <img class="media-object news-img"
                                                                        src="{{ asset('public/front_asset/img/customer_profile/' . (Auth::guard('web')->user()->profile_pic ?? 'default.png')) }}"
                                                                        alt="img">
                                                                @else
                                                                    <img class="media-object news-img"
                                                                        src="{{ asset('public/front_asset/img/vendor_profile/' . ($vendor->profile_pic ?? 'default.png')) }}"
                                                                        alt="img">
                                                                @endif

                                                            </div>
                                                            <div class="media-body">
                                                                <h4 class="author-name">
                                                                    {{ $message->sender_id == Auth::guard('web')->user()->id ? 'You' : 'Vendor' }}
                                                                </h4>
                                                                <span class="comments-date">
                                                                    {{ $message->created_at }}</span>
                                                                <p>{{ $message->message }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            {{-- <ul class="commentlist">
                                                <li id="messages">
                                                    @foreach ($messages as $message)
                                                        <p>
                                                            <strong>{{ $message->sender_id == Auth::guard('web')->user()->id ? 'You' : 'Vendor' }}:</strong>
                                                            {{ $message->message }}
                                                            <span
                                                                class="text-muted small">{{ $message->created_at }}</span>
                                                        </p>
                                                    @endforeach
                                                </li>
                                            </ul> --}}
                                        </div>
                                    </div>

                                    <!-- blog comments form -->
                                    <div id="respond">
                                        <h3 class="reply-title">Send Message</h3>
                                        <form id="commentform" action="{{ route('customer.sendMessage') }}" method="POST">
                                            @csrf
                                            <p class="comment-form-author">
                                                <input type="text" value="" size="30" name="message"
                                                    id="messageInput" required="required">
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

@endsection

@push('js')
    <script>
        document.querySelector('#commentform').addEventListener('submit', function(e) {
            e.preventDefault();

            const message = document.querySelector('#messageInput').value;
            const vendorId = {{ $vendor->id }};

            fetch('{{ route('customer.sendMessage') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        message,
                        vendor_id: vendorId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('#messageInput').value = '';
                        console.log('Message sent successfully:', data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endpush
