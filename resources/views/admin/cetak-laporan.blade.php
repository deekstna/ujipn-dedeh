<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Laporan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header {
            line-height: 24px;
            padding: 10px 20px;
        }

        .header h1 {
            float: left;
        }

        .header p {
            float: right;
        }

        .both {
            clear: both;
        }

        table {
            border-collapse: collapse;
            margin-top: 20px;
            padding: 10px;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
        }

        .text-center {
            text-align: center;
        }

        th {
            background-color: #343434;
            color: #fff;
        }

        tr:nth-child(even) td {
            background-color: rgb(211, 211, 211)
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Aspirasi</h1>
        <p>Dicetak pada tanggal : {{ \Carbon\Carbon::now()->format('d-M-Y') }}</p>
        <div class="both"></div>
    </div>
    <hr>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th width="100">Nama Siswa</th>
                <th>Kelas</th>
                <th width="120">Judul</th>
                <th>Aspirasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aspirasi as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->siswa->user->nama }}</td>
                    <td class="text-center">{{ $item->siswa->kelas }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->isi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
