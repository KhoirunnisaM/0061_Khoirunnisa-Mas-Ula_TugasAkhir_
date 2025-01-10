<?= $this->extend('Pegawai/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <h3>Laporan Bulanan Penjualan Barang</h3>
    <form method="get" action="<?= base_url('Pegawai/cetakLaporanPenjualan') ?>" target="_blank">
        <div class="row mb-4">
            <div class="col-md-3">
                <select name="bulan" class="form-control">
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="tahun" class="form-control" placeholder="Masukkan Tahun" value="<?= date('Y') ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success">Cetak Laporan</button>
            </div>
        </div>
    </form>


    <table class="table table-bordered" id="dataTable">
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
                <td colspan="8" class="text-right"><strong>Total Biaya:</strong></td>
                <td><strong>Rp <?= number_format($totalBiaya, 0, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>