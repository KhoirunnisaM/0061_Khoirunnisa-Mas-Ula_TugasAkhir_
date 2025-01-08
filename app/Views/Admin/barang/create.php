<?= $this->extend('Admin/layouts/main') ?>
<?= $this->section('title') ?>
PANEL ADMIN - Tambah Barang
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Tambah Barang</h1>
    <form action="<?= site_url('Admin/barang/store'); ?>" method="POST">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label for="kode_barang">Kode Barang</label>
            <input type="text" class="form-control" placeholder="Masukan Kode" id="kode_barang" name="kode_barang" required>
        </div>

        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
        </div>

        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" class="form-control" id="brand" name="brand" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('Admin/barang'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>