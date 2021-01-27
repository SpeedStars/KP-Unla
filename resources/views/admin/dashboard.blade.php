@extends('admin.layout.app')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Dashboard
              </h3>
            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{ asset('adminassets') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Pendapatan Hari Ini<i class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Rp. {{ $hariini }},00</h2>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{ asset('adminassets') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Pendapatan Bulan Ini<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Rp. {{ $bulanini }},00</h2>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{ asset('adminassets') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Pendapatan Tahun Ini<i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">Rp. {{ $tahunini }},00</h2>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">10 Transaksi Terbaru</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Invoice </th>
                            <th> Pemesan </th>
                            <th> Subtotal </th>
                            <th> Status Pesanan </th>
                            <th> Aksi </th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($order_baru as $order)
                            <tr>
                              {{-- @if($order_baru->name = 'Belum Di Bayar') --}}
                                  <td  >{{ $order->invoice }}</td>
                                  <td  >{{ $order->nama_pemesan }}</td>
                                  <td  >{{ $order->subtotal }}</td>
                                  <td  style="background-color: {{ App\Order::STATUS_COLOR[$order->name]}};">{{ $order->name }}</td>
                                  <td  > <a href="{{ route('admin.transaksi.detail',['id'=>$order->id]) }}" class="btn btn-warning btn-sm">Detail</a></td>
                              {{-- @elseif($order_baru->name = 'Pesanan Di Batalkan')
                                  <td  class="red">{{ $order->invoice }}</td>
                                  <td  class="red">{{ $order->nama_pemesan }}</td>
                                  <td  class="red">{{ $order->subtotal }}</td>
                                  <td  class="red">{{ $order->name }}</td>
                                  <td  class="red"> <a href="{{ route('admin.transaksi.detail',['id'=>$order->id]) }}" class="btn btn-warning btn-sm">Detail</a></td>
                              @elseif($order_baru->name = 'Barang Telah Sampai')
                                  <td  class="green">{{ $order->invoice }}</td>
                                  <td  class="green">{{ $order->nama_pemesan }}</td>
                                  <td  class="green">{{ $order->subtotal }}</td>
                                  <td  class="green">{{ $order->name }}</td>
                                  <td  class="green"> <a href="{{ route('admin.transaksi.detail',['id'=>$order->id]) }}" class="btn btn-warning btn-sm">Detail</a></td>
                              @endif --}}
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection