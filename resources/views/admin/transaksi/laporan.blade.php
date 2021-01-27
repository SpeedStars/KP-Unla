@extends('admin.layout.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-home"></i>
        </span> Laporan </h3>
    </div>

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    
                    <div class="row mb-3">
                        <div class="col">
                        <h4 class="card-title">Laporan Penjualan</h4>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.transaksi.laporan') }}" method="get">
                        <div class="input-group mb-6 col-md-4 float-right">
                            <input type="text" id="created_at" name="date" class="form-control">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="submit">Filter</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <br>
                        <br>
                        <table class="table table-bordered table-hovered" >
                            <thead>
                                <tr>
                                    <th>No Invoice</th>
                                    <th>Pelanggan</th>
                                    <th>Subtotal</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order as $row)
                                <tr>
                                    <td><strong>{{ $row->invoice }}</strong></td>
                                    <td>
                                        <strong>{{ $row->name }}</strong><br/><br/>
                                        <label><strong>Telp:</strong> {{ $row->no_hp }}</label><br><br/>
                                        <label><strong>Alamat:</strong> {{ $row->alamatlengkap }} | {{ $row->kecamatan }} - {{  $row->kota}}, {{ $row->provinsi }}</label>
                                    </td>
                                    <td>Rp {{ ($row->subtotal) }}</td>
                                    
                                    <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><strong>Total</strong></td>
                                    <td>Rp {{ $order->sum('subtotal') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
          
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        //KETIKA PERTAMA KALI DI-LOAD MAKA TANGGAL NYA DI-SET TANGGAL SAA PERTAMA DAN TERAKHIR DARI BULAN SAAT INI
        $(document).ready(function() {
            let start = moment().startOf('month')
            let end = moment().endOf('month')

            //KEMUDIAN TOMBOL EXPORT PDF DI-SET URLNYA BERDASARKAN TGL TERSEBUT
            $('#exportpdf').attr('href', '/administrator/reports/order/pdf/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

            //INISIASI DATERANGEPICKER
            $('#created_at').daterangepicker({
                startDate: start,
                endDate: end
            }, function(first, last) {
                //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
                $('#exportpdf').attr('href', '/administrator/reports/order/pdf/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
            })
        })
    </script>
@endsection()