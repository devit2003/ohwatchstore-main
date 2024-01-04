@extends('layouts.app')

@section('content')
<head>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>

<div class="swiper-container banner">
  <div class="swiper-wrapper">
    <div class="swiper-slide"><img src="{{ asset('images/banner.png') }}" alt="Oh Watch Store"></div>
    <div class="swiper-slide"><img src="{{ asset('images/banner4.png') }}" alt="Free shipping"></div>
    <div class="swiper-slide"><img src="{{ asset('images/banner2.png') }}" alt="watch catalog"></div>
    <div class="swiper-slide"><img src="{{ asset('images/banner3.png') }}" alt="oh watch store customer service"></div>
  </div>
  <div class="swiper-button-next"></div>
  <div class="swiper-button-prev"></div>
</div>

<script>
var swiper = new Swiper('.banner', {
  slidesPerView: 1,
  spaceBetween: 10,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  loop: true, // Memberikan efek loop pada gambar
  autoplay: {
    delay: 3000, // Menyertakan delay 3000 ms (3 detik) antara perpindahan gambar
    disableOnInteraction: false, // Tetapkan false agar autoplay tidak dihentikan setelah interaksi pengguna
  },
});
</script>

<br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('AVAILABLE PRODUCTS') }}</div>

                    <div class="card-group m-auto">
                        @foreach ($products as $product)
                            <div class="card m-3" style="width: 18rem;">
                                <img class="card-img-top" src="{{ url('storage/' . $product->image) }}"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">{{ $product->name }}</p>
                                    <p>IDR {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <form action="{{ route('show_product', $product) }}" method="get">
                                        <button type="submit" class="btn btn-primary">Show detail</button>
                                    </form>
                                    @if (Auth::check() && Auth::user()->is_admin)
                                        <form action="{{ route('delete_product', $product) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger mt-2">Delete product</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
