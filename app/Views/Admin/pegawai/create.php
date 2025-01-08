<?= $this->extend('Admin/layouts/main') ?>
<?= $this->section('title') ?>
PANEL ADMIN - Tambah Pegawai
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Tambah Pegawai</h1>
    <form action="<?= site_url('Admin/pegawai/store'); ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
        </div>

        <div class="form-group">
            <label for="fullname">Nama Lengkap</label>
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="hp">No. HP</label>
            <input type="text" class="form-control" id="hp" name="hp" placeholder="Masukkan nomor HP" required>
        </div>

        <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
            <div class="mt-2">
                <img id="preview" src="#" alt="Preview Foto" style="display:none; max-width: 200px;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('Admin/pegawai'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const preview = document.getElementById('preview');

        reader.onload = function() {
            preview.src = reader.result;
            preview.style.display = 'block'; // Menampilkan gambar
        }

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]); // Membaca gambar yang dipilih
        }
    }
</script>
<?= $this->endSection() ?>