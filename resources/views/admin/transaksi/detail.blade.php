@extends('admin.layout.app')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Pesanan </h3>
            </div> 
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col">
                      <h4 class="card-title">Detail Pesanan {{ $order->nama_pelanggan }}</h4>
                      </div>
                      <div class="col text-right">
                      <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
                      </div>
                    </div>
                    <hr>
                   <div class="row">
                   <div class="col-md-7">
                    <table>
                        <tr>
                            <td>No Invoice</td>
                            <td>:</td>
                            <td  class="p-2">{{ $order->invoice }}</td>
                        </tr>
                        <tr>
                          <td>Tanggal Pemesanan</td>
                          <td>:</td>
                          <td  class="p-2">{{ $order->created_at }}</td>
                        </tr>
                        @if($order->metode_pembayaran == 'trf')
                          <tr>
                              <td>Metode Pembayaran</td>
                              <td>:</td>
                              <td  class="p-2">Transfer</td>
                          </tr>
                          <tr>
                            <td>Status Pesanan</td>
                            <td>:</td>
                            <td  class="p-2">{{ $order->status }}</td>
                          </tr>
                          <tr>
                              <td>Total</td>
                              <td>:</td>
                              <td  class="p-2">Rp. {{ number_format($order->subtotal,2,',','.') }}</td>
                          </tr>
                          <tr>
                              <td>No Hp</td>
                              <td>:</td>
                              <td  class="p-2">{{ $order->no_hp }}</td>
                          </tr>
                          <tr>
                              <td>Alamat Pelanggan</td>
                              <td>:</td>
                              <td  class="p-2">{{ $order->alamatlengkap }}</td>
                          </tr>
                          @if($order->status_order_id == 1)
                            <td></td>
                            <td></td>
                            <td  class="p-2"><a href="{{ route('admin.transaksi.batalkan',['id' => $order->id]) }}" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')" class="btn btn-danger mt-1">Batalkan Pemesanan</a><br>
                            <small>Klik tombol jika pembayaran tidak dilakukan selama 2 hari</small>
                            </td>
                          @endif
                          @if($order->status_order_id == 2)
                            @if($payment->status == 'success')
                            <tr>
                              <td>Tipe Pembayaran</td>
                              <td>:</td>
                              <td  class="p-2">{{ $payment->payment_type }}</td>
                            </tr>
                            <tr>
                              <td>Token Pembayaran</td>
                              <td>:</td>
                              <td  class="p-2">{{ $payment->token }}</td>
                            </tr>
                            <tr>
                              <td>Tanggal Pembayaran</td>
                              <td>:</td>
                              <td  class="p-2">{{ $payment->created_at }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td  class="p-2"><a href="{{ route('admin.transaksi.konfirmasitrf',['id' => $order->id]) }}" onclick="return confirm('Yakin ingin mengonfirmasi pesanan ini?')" class="btn btn-primary mt-1">Konfirmasi Telah Bayar</a><br>
                                <small>Klik tombol jika pembeli sudah melakukan pembayaran</small>
                                </td>
                            </tr>
                            @endif
                          @endif
                          @if($order->status_order_id == 3)
                            <tr>
                              <td>Tipe Pembayaran</td>
                              <td>:</td>
                              <td  class="p-2">{{ $payment->payment_type }}</td>
                            </tr>
                            <tr>
                              <td>Token Pembayaran</td>
                              <td>:</td>
                              <td  class="p-2">{{ $payment->token }}</td>
                            </tr>
                            <tr>
                              <td>Tanggal Pembayaran</td>
                              <td>:</td>
                              <td  class="p-2">{{ $payment->created_at }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td  class="p-2"><a href="{{ route('admin.transaksi.kirim',['id' => $order->id]) }}" onclick="return confirm('Yakin ingin mengonfirmasi pesanan ini?')" class="btn btn-primary mt-1">Konfirmasi Pengiriman</a><br>
                                <small>Klik tombol jika status barang telah dikirim</small>
                                </td>
                            </tr>
                          @endif
                          @if($order->status_order_id == 4 || $order->status_order_id == 5)
                            <tr>
                              <td>Tipe Pembayaran</td>
                              <td>:</td>
                              <td  class="p-2">{{ $payment->payment_type }}</td>
                            </tr>
                            <tr>
                              <td>Token Pembayaran</td>
                              <td>:</td>
                              <td  class="p-2">{{ $payment->token }}</td>
                            </tr>
                            <tr>
                              <td>Tanggal Pembayaran</td>
                              <td>:</td>
                              <td  class="p-2">{{ $payment->created_at }}</td>
                            </tr>
                          @endif
                        @endif


                        @if($order->metode_pembayaran == 'byr')
                        <tr>
                            <td>Metode Pembayaran</td>
                            <td>:</td>
                            <td  class="p-2">Bayar Ditoko</td>
                        </tr>
                        <tr>
                          <td>Status Pesanan</td>
                          <td>:</td>
                          <td  class="p-2">{{ $order->status }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>:</td>
                            <td  class="p-2">Rp. {{ number_format($order->subtotal,2,',','.') }}</td>
                        </tr>
                        <tr>
                            <td>No Hp</td>
                            <td>:</td>
                            <td  class="p-2">{{ $order->no_hp }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Pelanggan</td>
                            <td>:</td>
                            <td  class="p-2">{{ $order->alamatlengkap }}</td>
                        </tr>
                        @if($order->status_order_id == 5)
                          <tr>
                            <td>Tanggal Pembayaran</td>
                            <td>:</td>
                            <td  class="p-2">{{ $payment->created_at }}</td>
                          </tr>
                        @endif
                        @if($order->status_order_id == 1)
                          <tr>
                            <td></td>
                            <td></td>
                            <td  class="p-2"><a href="{{ route('admin.transaksi.konfirmasibyr',['id' => $order->id]) }}" onclick="return confirm('Yakin ingin mengonfirmasi pesanan ini?')" class="btn btn-primary mt-1">Konfirmasi Pembayaran</a><br>
                            <small>Klik tombol jika pembeli sudah melakukan pembayaran di toko</small>
                            </td>
                            <td  class="p-2"><a href="{{ route('admin.transaksi.batalkan',['id' => $order->id]) }}" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')" class="btn btn-danger mt-1">Batalkan Pemesanan</a><br>
                            <small>Klik tombol jika pembayaran tidak dilakukan selama 2 hari</small>
                            </td>
                          </tr>
                        @endif
                        @endif
                        
                    </table>
                    </div>
                    <div class="col-md-5">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hovered" >
                        <thead class="bg-primary text-white">
                          <tr>
                            <th width="5%">No</th>
                            <th>Nama Produk</th>
                            <th>QTY</th>
                            <th>Total Harga</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            @foreach($detail as $dt)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->qty }}</td>
                                <td>{{ $dt->qty * $dt->price }}</td>
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
            </div>
          </div>
          
@endsection
