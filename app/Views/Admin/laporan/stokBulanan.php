<?= $this->extend('Admin/layouts/main') ?>

<?= $this->section('title') ?>
Laporan Stok Bulanan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><i class="nav-icon fas fa-boxes"></i> Laporan Stok Bulanan</h1>
    </div>

    <form action="<?= site_url('Admin/laporan/cariStok'); ?>" method="POST">
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
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead class="bg-dark text-white">
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
            <a href="<?= site_url('Admin/laporan/cetakStok?bulan=' . $bulan . '&tahun=' . $tahun); ?>" class="btn btn-success">Cetak Laporan</a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
