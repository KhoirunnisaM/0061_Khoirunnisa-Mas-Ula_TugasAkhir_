<?= $this->extend('Admin/layouts/main') ?>

<?= $this->section('title') ?>
Edit Pegawai
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Edit Pegawai</h1>

    <!-- Form Edit Pegawai -->
    <form action="<?= site_url('Admin/pegawai/edit/' . $user['id_user']); ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['username']); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru (kosongkan jika tidak ingin mengubah)" />
        </div>

        <div class="form-group">
            <label for="fullname">Nama Lengkap</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="<?= old('fullname', $user['fullname']); ?>" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat', $user['alamat']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="hp">No. HP</label>
            <input type="text" class="form-control" id="hp" name="hp" value="<?= old('hp', $user['hp']); ?>" required>
        </div>

        <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
            <!-- Preview Foto -->
            <?php if ($user['foto']): ?>
                <div class="mt-2">
                    <img src="<?= base_url('uploads/' . $user['foto']); ?>" alt="Foto" width="100" height="100" id="current-image">
                    <p>Foto saat ini</p>
                </div>
            <?php endif; ?>
            <!-- Preview foto baru -->
            <div id="preview-container" class="mt-2" style="display: none;">
                <img id="preview" src="#" alt="Preview Foto" width="100" height="100">
                <p>Preview Foto Baru</p>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Pegawai</button>
        <a href="<?= site_url('Admin/pegawai'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    // Fungsi untuk menampilkan preview foto yang dipilih
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview');
            var previewContainer = document.getElementById('preview-container');
            preview.src = reader.result;
            previewContainer.style.display = 'block'; // Menampilkan preview
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?= $this->endSection() ?>