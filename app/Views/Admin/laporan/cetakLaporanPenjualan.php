<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

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
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Laporan Penjualan Bulanan</h2>
    <p>Bulan: <?= $bulan ?>, Tahun: <?= $tahun ?></p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>ID Penjualan</th>
                <th>Nama Supplier</th>
                <th>Nama Barang</th>
                <th>Brand</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            $totalBiaya = 0; ?>
            <?php foreach ($penjualan as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d M Y', strtotime($row['tgl_penjualan'])) ?></td>
                    <td><?= $row['id_penjualan'] ?></td>
                    <td><?= $row['nama_pembeli'] ?></td>
                    <td><?= $row['nama_barang'] ?></td>
                    <td><?= $row['brand'] ?></td>
                    <td><?= $row['qty'] ?></td>
                    <td>Rp <?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($row['qty'] * $row['harga_satuan'], 0, ',', '.') ?></td>
                </tr>
                <?php $totalBiaya += $row['qty'] * $row['harga_satuan']; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="8" style="text-align: right;"><strong>Total Biaya:</strong></td>
                <td><strong>Rp <?= number_format($totalBiaya, 0, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>
</body>

</html>