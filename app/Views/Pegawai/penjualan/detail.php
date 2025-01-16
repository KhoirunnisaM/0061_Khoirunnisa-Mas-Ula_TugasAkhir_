<?= $this->extend('Pegawai/layouts/main') ?>
<?= $this->section('title') ?>
PANEL PEGAWAI - Detail Penjualan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Detail Penjualan</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Penjualan</h5><br>
            <p><strong>ID Penjualan:</strong> <?= $penjualan['id_penjualan']; ?></p>
            <p><strong>Tanggal Penjualan:</strong> <?= $penjualan['tgl_penjualan']; ?></p>
            <p><strong>Nama Pembeli:</strong> <?= $penjualan['nama_pembeli']; ?></p>
            <p><strong>Petugas:</strong> <?= $penjualan['nama_user']; ?></p>
        </div>
    </div>

    <h5 class="mb-3">Detail Barang</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kode Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php foreach ($detailPenjualan as $index => $item): ?>
                <?php $subtotal = $item['qty'] * $item['harga']; ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= $item['nama_barang']; ?></td>
                    <td><?= $item['kode_barang']; ?></td>
                    <td><?= $item['qty']; ?></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td>Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                </tr>
                <?php $total += $subtotal; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total</th>
                <th>Rp <?= number_format($total, 0, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>

    <a href="<?= site_url('Pegawai/penjualan'); ?>" class="btn btn-secondary">Kembali</a>
</div>
<?= $this->endSection() ?>