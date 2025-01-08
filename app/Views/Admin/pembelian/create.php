<?= $this->extend('Admin/layouts/main') ?>
<?= $this->section('title') ?>
PANEL ADMIN - Tambah Pembelian
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Tambah Pembelian</h1>
    <form action="<?= site_url('Admin/pembelian/store'); ?>" method="POST">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label for="tgl_pembelian">Tanggal Pembelian</label>
            <input type="datetime-local" class="form-control" id="tgl_pembelian" name="tgl_pembelian" value="<?= isset($pembelian['tgl_pembelian']) ? date('Y-m-d\TH:i:s', strtotime($pembelian['tgl_pembelian'])) : ''; ?>" required>
        </div>


        <div class="form-group">
            <label for="id_supplier">Supplier</label>
            <select class="form-control" id="id_supplier" name="id_supplier" required>
                <option value="" disabled selected>Pilih Supplier</option>
                <?php foreach ($suppliers as $supplier): ?>
                    <option value="<?= $supplier['id_supplier']; ?>"><?= $supplier['nama_supplier']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="barang">Barang</label>
            <div id="barang-wrapper">
                <div class="barang-item mb-3">
                    <select class="form-control mb-2 barang-select" name="barang[0][kode_barang]" required>
                        <option value="" disabled selected>Pilih Barang</option>
                        <?php foreach ($barang as $item): ?>
                            <option value="<?= $item['kode_barang']; ?>"><?= $item['nama_barang']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" class="form-control mb-2 barang-qty" name="barang[0][qty]" placeholder="Jumlah" required>
                    <input type="number" class="form-control barang-price" name="barang[0][harga]" placeholder="Harga" required>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="add-barang">Tambah Barang</button>
        </div>

        <div class="form-group">
            <label for="total_harga">Total Harga</label>
            <input type="text" class="form-control" id="total_harga" name="total_harga" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('Admin/pembelian'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    let barangIndex = 1;
    document.getElementById('add-barang').addEventListener('click', function() {
        const wrapper = document.getElementById('barang-wrapper');
        const newBarang = document.createElement('div');
        newBarang.classList.add('barang-item', 'mb-3');
        newBarang.innerHTML = `
            <select class="form-control mb-2 barang-select" name="barang[${barangIndex}][kode_barang]" required>
                <option value="" disabled selected>Pilih Barang</option>
                <?php foreach ($barang as $item): ?>
                    <option value="<?= $item['kode_barang']; ?>"><?= $item['nama_barang']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" class="form-control mb-2 barang-qty" name="barang[${barangIndex}][qty]" placeholder="Jumlah" required>
            <input type="number" class="form-control barang-price" name="barang[${barangIndex}][harga]" placeholder="Harga" required>
        `;
        wrapper.appendChild(newBarang);
        barangIndex++;
        calculateTotal();
    });

    document.getElementById('barang-wrapper').addEventListener('input', calculateTotal);

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.barang-item').forEach(function(item) {
            const qty = parseFloat(item.querySelector('.barang-qty').value) || 0;
            const price = parseFloat(item.querySelector('.barang-price').value) || 0;
            total += qty * price;
        });
        document.getElementById('total_harga').value = total;
    }
</script>
<?= $this->endSection() ?>