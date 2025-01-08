<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Stok</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Laporan Stok</h1>
    <p>Bulan: <?= $bulan ? date('F', mktime(0, 0, 0, $bulan, 1)) : 'Semua Bulan'; ?></p>
    <p>Tahun: <?= $tahun ?? 'Semua Tahun'; ?></p>

    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Brand</th>
                <th>Stok Barang</th>
                <th>Qty Penjualan</th>
                <th>Qty Pembelian</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $item): ?>
                <tr>
                    <td><?= $item['kode_barang']; ?></td>
                    <td><?= $item['nama_barang']; ?></td>
                    <td><?= $item['brand']; ?></td>
                    <td><?= $item['stok']; ?></td>
                    <td><?= $item['qty_penjualan']; ?></td>
                    <td><?= $item['qty_pembelian']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>