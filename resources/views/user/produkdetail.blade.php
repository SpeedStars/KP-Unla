@extends('user.app')
@section('content')
<div class="bg-light py-3">
    <div class="container">
    <div class="row">
        <div class="col-md-12 mb-0"><a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">{{$products->name}}</strong></div>
    </div>
    </div>
</div>  

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/'.$products->image) }}" alt="Image" class="img-fluid">
            </div>

            <div class="col-md-6">
                <h2 class="text-black">{{ $products->name }}</h2>
                <p>
                    {{ $products->description }}
                </p>
                <p><strong class="text-primary h4">Rp {{ $products->price }} </strong></p>
                <div class="mb-5">
                    <form action="{{ route('user.keranjang.simpan') }}" method="post">
                        @csrf
                        @if(Route::has('login'))
                            @auth
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            @endauth
                        @endif
                        <input type="hidden" name="products_id" value="{{ $products->id }}">
                        <small>Stock: {{ $products->stock }}</small><br>
                        <small>Quantity:</small>
                        <div class="input-group mb-3" style="max-width: 120px;">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                            </div>
                            <input type="text" name="qty" class="form-control text-center" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                            </div>
                        </div>
                        <p><button type="submit" class="buy-now btn btn-sm btn-primary">Add To Cart</button></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection