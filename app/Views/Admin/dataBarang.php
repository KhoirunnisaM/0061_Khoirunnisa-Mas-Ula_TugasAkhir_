<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/css/adminlte.min.css'); ?>">
</head>
<body>
    <div class="container mt-5">
        <h1>Data Barang</h1>
        <a href="<?= site_url('barang/create'); ?>" class="btn btn-primary mb-3">Tambah Barang</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Brand</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang as $b): ?>
                    <tr>
                        <td><?= $b['kode_barang']; ?></td>
                        <td><?= $b['nama_barang']; ?></td>
                        <td><?= $b['brand']; ?></td>
                        <td><?= $b['stok']; ?></td>
                        <td><?= $b['harga']; ?></td>
                        <td><?= $b['status']; ?></td>
                        <td>
                            <a href="<?= site_url('barang/edit/'.$b['kode_barang']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= site_url('barang/delete/'.$b['kode_barang']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
