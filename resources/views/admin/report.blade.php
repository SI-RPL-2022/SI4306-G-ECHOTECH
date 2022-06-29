@extends('partials.layout-admin')
@section('container')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Report</h1>
        <a href="/admin/report/generate-laporan" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i>Generate Report</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">User</th>
                <th scope="col">Jumlah Botol</th>
                <th scope="col">Tanggal Transaksi</th>
                <th scope="col">Pemasukan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataReport as $item)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$item['nama']}}</td>
                <td>{{$item['jumlahbtl']}}</td>
                <td>{{$item['tanggal_transaksi']}}</td>
                <td>Rp.{{$item['penghasilan']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection