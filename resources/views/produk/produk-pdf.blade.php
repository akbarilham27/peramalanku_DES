<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Data Produk</h1>
    <table>
        <thead>
            <tr>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Jenis Produk</th>
                <th>Harga Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_produk as $produk)
            <tr>
                <td>{{ $produk->id_produk }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td>{{ $produk->jenis_produk }}</td>
                <td>{{ $produk->harga_produk }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
