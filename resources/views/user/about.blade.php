@extends('user.app')
@section('content')

<div class="bg-light py-3">
    <div class="container">
    <div class="row">
        <div class="col-md-12 mb-0"><a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">About</strong></div>
    </div>
    </div>
</div>  

<div class="site-section">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
        <h2 class="h3 mb-3 text-black">About</h2>
        </div>
        
        <div class="col-md-7">

            
            <div class="p-3 p-lg-5 border">
                <label>BaJaPri</label>
                <p>Aplikasi yang dibangun untuk membantu proses jual beli dalam PT. Bangunan Jaya Prima</p>
                <p>PT. Bangunan Jaya Prima merupakan perusahaan yang bergerak di bidang penjualan barang-barang material dan perabotan rumah, seperti keramik lantai, rak buku, plafon, dan lainnya. Saat ini perusahaan telah memiliki banyak cabang di berbagai daerah diseluruh Indonesia. </p>
            </div>

        </div>
    </div>
    </div>
</div>
@endsection