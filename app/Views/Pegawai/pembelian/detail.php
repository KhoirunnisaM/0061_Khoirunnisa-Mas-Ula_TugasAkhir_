<?= $this->extend('Pegawai/layouts/main') ?>
<?= $this->section('title') ?>
PANEL PEGAWAI - Detail Pembelian
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Detail Pembelian</h1>

    <!-- Informasi Pembelian -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Informasi Pembelian</h2>
        </div>
        <div class="card-body">
            <p><strong>ID Pembelian:</strong> <?= $pembelian['id_pembelian'] ?></p>
            <p><strong>Tanggal Pembelian:</strong> <?= $pembelian['tgl_pembelian'] ?></p>
            <p><strong>ID Supplier:</strong> <?= $pembelian['id_supplier'] ?></p>
            <p><strong>ID User:</strong> <?= $pembelian['id_user'] ?></p>
        </div>
    </div>

    <!-- Detail Barang yang Dibeli -->
    <div class="card">
        <div class="card-header">
            <h2>Barang yang Dibeli</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Brand</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detailPembelian as $detail): ?>
                        <tr>
                            <td><?= $detail['kode_barang'] ?></td>
                            <td><?= $barangModel->find($detail['kode_barang'])['nama_barang'] ?></td>
                            <td><?= $barangModel->find($detail['kode_barang'])['brand'] ?></td>
                            <td><?= $detail['qty'] ?></td>
                            <td>Rp<?= number_format($detail['harga'], 0, ',', '.') ?></td>
                            <td>Rp<?= number_format($detail['qty'] * $detail['harga'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="<?= site_url('Pegawai/pembelian'); ?>" class="btn btn-secondary mt-2">Kembali</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>