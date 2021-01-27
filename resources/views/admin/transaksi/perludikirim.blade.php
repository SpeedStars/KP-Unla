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
                      <h4 class="card-title">Data Pesanan Perlu Di Kirim</h4>
                      </div>
                    </div>
                    @if(Session::has('status'))
                      <div class="alert alert-info">
                          {!!Session::get('status')!!}
                      </div>
                    @endif
                    <div class="table-responsive">
                      <table class="table table-bordered table-hovered" id="table">
                        <thead>
                          <tr>
                            <th width="5%">No</th>
                            <th>No Invoice</th>
                            <th>Pemesan</th>
                            <th>Subtotal</th>
                            <th>Metode Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th width="15%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($perlukirim as $kirim)
                            <tr>
                                <td align="center"></td>
                                <td>{{ $kirim->invoice }}</td>
                                <td>{{ $kirim->nama_pemesan }}</td>
                                <td>{{ $kirim->subtotal }}</td>
                                <td>{{ $kirim->payment_type }}</td>
                                <td>{{ $kirim->name }}</td>
                                <td align="center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                  <a href="{{ route('admin.transaksi.detail',['id'=>$kirim->order_id]) }}"  class="btn btn-warning btn-sm">
                                    Status Kirim
                                  </a>
                                </div>
                                </td>
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
