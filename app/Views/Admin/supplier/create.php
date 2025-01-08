<?= $this->extend('Admin/layouts/main') ?>

<?= $this->section('title') ?>
PANEL ADMIN - Tambah Supplier
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Tambah Supplier</h1>
    <form action="<?= site_url('Admin/supplier/store'); ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label for="id_supplier">Kode Supplier</label>
            <input type="text" class="form-control" id="id_supplier" name="id_supplier" placeholder="Masukkan kode supplier" required>
        </div>

        <div class="form-group">
            <label for="nama_supplier">Nama Supplier</label>
            <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" placeholder="Masukkan nama supplier" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="hp">No. HP</label>
            <input type="text" class="form-control" id="hp" name="hp" placeholder="Masukkan nomor HP" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('Admin/supplier'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?= $this->endSection() ?>