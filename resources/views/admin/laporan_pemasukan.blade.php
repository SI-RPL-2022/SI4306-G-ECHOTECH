<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        h1 {
            font-family: sans-serif;
        }

        table {
            font-family: Arial, Helvetica, sans-serif;
            color: #666;
            text-shadow: 1px 1px 0px #fff;
            background: #eaebec;
            border: #ccc 1px solid;
        }

        table th {
            padding: 15px 35px;
            border-left: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            background: #ededed;
        }

        table th:first-child {
            border-left: none;
        }

        table tr {
            text-align: center;
            padding-left: 20px;
        }

        table td:first-child {
            text-align: left;
            padding-left: 20px;
            border-left: 0;
        }

        table td {
            padding: 15px 35px;
            border-top: 1px solid #ffffff;
            border-bottom: 1px solid #e0e0e0;
            border-left: 1px solid #e0e0e0;
            background: #fafafa;
            background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
            background: -moz-linear-gradient(top, #fbfbfb, #fafafa);
        }

        table tr:last-child td {
            border-bottom: 0;
        }

        table tr:last-child td:first-child {
            -moz-border-radius-bottomleft: 3px;
            -webkit-border-bottom-left-radius: 3px;
            border-bottom-left-radius: 3px;
        }

        table tr:last-child td:last-child {
            -moz-border-radius-bottomright: 3px;
            -webkit-border-bottom-right-radius: 3px;
            border-bottom-right-radius: 3px;
        }

        table tr:hover td {
            background: #f2f2f2;
            background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
            background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
        }
    </style>
    <title>Document</title>

</head>

<body>
    <div style="display:flex;text-align:center">
        <div style="justify-content:center;align-items:center;">
            <img src="{{ public_path('/image/icon.jpg')}}" width="45px" height="50px" style="margin-right: 5px;">
            <span style="font-size:25px;">Laporan Keuangan User</span>
        </div>
    </div>
    <table cellspacing='0' width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>User</th>
                <th>Jumlah Botol</th>
                <th>Tanggal Transaksi</th>
                <th>Pemasukan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataReport as $item)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td style="text-align:center" width="2%">{{$item['nama']}}</td>
                <td>{{$item['jumlahbtl']}}</td>
                <td>{{$item['tanggal_transaksi']}}</td>
                <td>Rp. {{$item['saldo']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>