@extends('front.customer.layout')
@section('title', 'paymentSuccess')

@section('content')
 <!-- catg header banner section -->
 <section id="aa-catg-head-banner">
    <img src="{{ asset('public/front_asset/img/fashion/fashion-header-bg-8.jpg') }}" alt="fashion img">
    <div class="aa-catg-head-banner-area">
        <div class="container">
            <div class="aa-catg-head-banner-content">
                <h2>Checkout Page</h2>
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">Checkout</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- / catg header banner section -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: "Payment Successful!",
            text: "Your Order has been completed!",
            icon: "success",
            confirmButtonColor: "#FF6666",
            confirmButtonText: "Back Home",
            allowOutsideClick: false,  // Prevents closing when clicking outside
            allowEscapeKey: false,     // Prevents closing with the 'Esc' key
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('home') }}";  // Update 'home' with your actual route name
            }
        });
    });
</script>  
@endsection