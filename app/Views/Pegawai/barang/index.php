<?= $this->extend('Pegawai/layouts/main') ?>
<?= $this->section('title') ?>
PANEL Pegawai
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Data Barang</h1>
    <p class="text-danger"><strong>Barang Not Ready</strong> Silakan nota barang di menu pembelian untuk mempersiapkan penjualan</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Brand</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barang as $b): ?>
                <tr>
                    <td><?= $b['kode_barang']; ?></td>
                    <td><?= $b['nama_barang']; ?></td>
                    <td><?= $b['brand']; ?></td>
                    <td>
                        <?php if ($b['stok'] == null) : ?>
                            <span class="text-danger">Not Ready</span>
                        <?php elseif ($b['stok'] > 0) : ?>
                            <?= $b['stok'] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($b['harga'] == null) : ?>
                            <span class="text-danger">Not Ready</span>
                        <?php elseif ($b['stok'] > 0) : ?>
                             <?= $b['harga'] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($b['active'] == 1) : ?>
                            <span class="text-success">Ready</span>
                        <?php elseif ($b['active'] == 0) : ?>
                            <span class="text-danger">Not Ready</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
