<?= $this->extend('Admin/layouts/main') ?>

<?= $this->section('title') ?>
Edit Supplier
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Edit Supplier</h1>
    <form action="<?= site_url('Admin/supplier/update/' . $supplier['id_supplier']); ?>" method="POST">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label for="nama_supplier">Nama Supplier</label>
            <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" value="<?= old('nama_supplier', $supplier['nama_supplier']); ?>" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat', $supplier['alamat']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="telp">No. Telp</label>
            <input type="text" class="form-control" id="telp" name="telp" value="<?= old('telp', $supplier['telp']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= site_url('Admin/supplier'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>