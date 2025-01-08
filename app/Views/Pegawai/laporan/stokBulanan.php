<?= $this->extend('Pegawai/layouts/main') ?>
<?= $this->section('title') ?>
Laporan Stok Bulanan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Laporan Stok Bulanan</h1>
    <form action="<?= site_url('Pegawai/laporan/cariStok'); ?>" method="POST">
        <?= csrf_field(); ?>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="bulan">Bulan</label>
                <select name="bulan" id="bulan" class="form-control" required>
                    <option value="">Pilih Bulan</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i; ?>" <?= (isset($bulan) && $bulan == $i) ? 'selected' : ''; ?>>
                            <?= date('F', mktime(0, 0, 0, $i, 1)); ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="tahun">Tahun</label>
                <select name="tahun" id="tahun" class="form-control" required>
                    <option value="">Pilih Tahun</option>
                    <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                        <option value="<?= $i; ?>" <?= (isset($tahun) && $tahun == $i) ? 'selected' : ''; ?>>
                            <?= $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">Cari Data</button>
            </div>
        </div>
    </form>

    <?php if (isset($data)): ?>
        <table class="table table-bordered">
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
        <a href="<?= site_url('Pegawai/laporan/cetakStok?bulan=' . $bulan . '&tahun=' . $tahun); ?>" class="btn btn-success">Cetak Laporan</a>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>