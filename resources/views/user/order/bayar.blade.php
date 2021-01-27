@extends('user.app')
@section('content')
<div class="bg-light py-3">
    <div class="container">
    <div class="row">
        <div class="col-md-12 mb-0"><a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Order</strong></div>
    </div>
    </div>
</div>  

<div class="site-section">
    <div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
        <h2 class="display-3 text-black">Proses Transaksi</h2>

        <br/>
        <br/>
        <div>
        <table class="table site-block-order-table mb-5">
            <thead>
            <h2>Detail Transaksi</h2>
            </thead>
            <tbody>
            <tr>
                <td>Nama: </td>
                <td>{{ $name }}</td>
                <td>Email: </td>
                <td>{{ $email }}</td>
            </tr>
            <tr>
                <td>Invoice: </td>
                @foreach($harga as $trans)
                    <td>{{ $trans->invoice }}</td>
                @endforeach
                <td>Total Harga: </td>
                @foreach($harga as $trans)
                    <td>{{ $trans->subtotal }}</td>
                @endforeach
            </tr>
            </tbody>
        </table>
        </div>
            <p><a href="{{ $url->payment_url }}" class="btn btn-sm btn-primary">Bayar Sekarang</a></p>
        </div>
    </div>
    </div>
</div>
@endsection