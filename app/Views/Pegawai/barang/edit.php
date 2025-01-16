<?= $this->extend('Pegawai/layouts/main') ?>

<?= $this->section('title') ?>
PANEL PEGAWAI - Edit Barang
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Edit Barang</h1>

    <!-- Form Edit Barang -->
    <form action="<?= site_url('Pegawai/barang/edit/' . $barang['kode_barang']); ?>" method="POST">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label for="kode_barang">Kode Barang</label>
            <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?= old('kode_barang', $barang['kode_barang']); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= old('nama_barang', $barang['nama_barang']); ?>" required>
        </div>

        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" class="form-control" id="brand" name="brand" value="<?= old('brand', $barang['brand']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Barang</button>
        <a href="<?= site_url('Pegawai/barang'); ?>" class="btn btn-secondary">Kembali</a>

    </form>
</div>

<?= $this->endSection() ?>