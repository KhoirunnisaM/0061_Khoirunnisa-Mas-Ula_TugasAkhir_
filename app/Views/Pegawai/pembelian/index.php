<?= $this->extend('Pegawai/layouts/main') ?>
<?= $this->section('title') ?>
PANEL Pegawai - Data Pembelian
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Data Pembelian</h1>
    <a href="<?= site_url('Pegawai/pembelian/create'); ?>" class="btn btn-primary mb-3">Tambah Pembelian</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pembelian</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Jumlah Barang</th>
                <th>Total Harga</th>
                <th>Petugas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($pembelian as $item): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $item['id_pembelian']; ?></td>
                    <td><?= $item['tgl_pembelian']; ?></td>
                    <td><?= $item['nama_supplier']; ?></td>
                    <td><?= $item['total_qty']; ?></td>
                    <td><?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                    <td><?= $item['nama_user']; ?></td>
                    <td>
                        <a href="<?= site_url('Pegawai/pembelian/detail/' . $item['id_pembelian']); ?>" class="btn btn-info btn-sm">Detail</a>
                        <a href="<?= site_url('Pegawai/pembelian/edit/' . $item['id_pembelian']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= site_url('Pegawai/pembelian/hapus/' . $item['id_pembelian']); ?>" class="btn btn-danger btn-sm delete-btn">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
