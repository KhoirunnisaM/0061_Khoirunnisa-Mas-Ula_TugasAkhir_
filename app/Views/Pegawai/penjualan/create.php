<?= $this->extend('Pegawai/layouts/main') ?>
<?= $this->section('title') ?>
PANEL Pegawai - Tambah Penjualan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Tambah Penjualan</h1>
    <form action="<?= site_url('Pegawai/penjualan/store'); ?>" method="POST">
        <?= csrf_field(); ?>

        <input type="hidden" class="form-control" id="id_penjualan" name="id_penjualan" value="<?= 'FP' . date('dmYHis'); ?>" readonly>

        <div class="form-group">
            <label for="nama_pembeli">Nama Pembeli</label>
            <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" placeholder="Masukkan Nama Pembeli" required>
        </div>

        <!-- Pencarian Barang -->
        <div class="form-group">
            <label for="search-barang">Cari Barang</label>
            <input type="text" class="form-control" id="search-barang" placeholder="Cari barang berdasarkan nama atau brand">
        </div>

        <div class="form-group">
            <div class="row" id="barang-cards"></div>
            <button type="button" id="show-more" class="btn btn-secondary mt-3">Tampilkan Lebih Banyak</button>
        </div>

        <div class="form-group">
            <h4>Keranjang</h4>
            <table class="table" id="cart-table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="form-group">
            <label for="total_harga">Total Harga</label>
            <input type="text" class="form-control" id="total_harga" name="total_harga" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('Pegawai/penjualan'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    const barangData = <?= json_encode($barang); ?>; // Data barang aktif dari server
    let displayedCount = 4; // Jumlah barang yang ditampilkan awalnya
    const cart = [];

    const barangCardsContainer = document.getElementById('barang-cards');
    const searchInput = document.getElementById('search-barang');
    const showMoreButton = document.getElementById('show-more');

    // Render barang berdasarkan filter
    function renderBarang(filteredBarang) {
        barangCardsContainer.innerHTML = '';
        const toShow = filteredBarang.slice(0, displayedCount);

        toShow.forEach(item => {
            const card = document.createElement('div');
            card.classList.add('col-md-3', 'mb-4');
            card.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${item.nama_barang}</h5>
                    <p class="card-text">Harga: Rp. ${new Intl.NumberFormat().format(item.harga)}</p>
                    <p class="card-text">Stok: ${item.stok}</p>
                    <button type="button" class="btn btn-primary btn-add-barang" 
                            data-kode="${item.kode_barang}" 
                            data-nama="${item.nama_barang}" 
                            data-harga="${item.harga}">Tambah</button>
                </div>
            </div>
        `;
            barangCardsContainer.appendChild(card);
        });

        // Show or hide the "Show More" button
        showMoreButton.style.display = filteredBarang.length > displayedCount ? 'block' : 'none';
    }

    // Tambah barang ke keranjang
    function addToCart(kode, nama, harga) {
        const existingItem = cart.find(item => item.kode === kode);
        if (existingItem) {
            existingItem.qty++;
        } else {
            cart.push({
                kode,
                nama,
                harga: parseFloat(harga),
                qty: 1
            });
        }
        renderCart();
    }

    // Render keranjang
    function renderCart() {
        const tbody = document.querySelector('#cart-table tbody');
        tbody.innerHTML = '';
        let total = 0;

        cart.forEach((item, index) => {
            const subtotal = item.harga * item.qty; // Hitung subtotal berdasarkan qty
            total += subtotal; // Tambahkan subtotal ke total

            tbody.innerHTML += `
        <tr>
            <td>${item.nama}</td>
            <td>
                <input type="number" class="form-control qty-input" data-index="${index}" value="${item.qty}" min="1" />
                <input type="hidden" name="barang[${index}][kode_barang]" value="${item.kode}" />
                <input type="hidden" name="barang[${index}][harga]" value="${item.harga}" />
                <input type="hidden" name="barang[${index}][qty]" value="${item.qty}" class="qty-hidden" />
            </td>
            <td>${item.harga}</td>
            <td>${subtotal}</td>
            <td><button type="button" class="btn btn-danger btn-remove" data-index="${index}">Hapus</button></td>
        </tr>
        `;
        });

        // Update total harga
        document.getElementById('total_harga').value = total;

        // Event listeners untuk input qty
        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('input', (e) => {
                const index = e.target.getAttribute('data-index');
                const qtyValue = parseInt(e.target.value);

                // Pastikan qty valid (minimal 1)
                if (qtyValue && qtyValue >= 1) {
                    cart[index].qty = qtyValue;
                    // Update hidden input untuk qty
                    const hiddenQtyInput = document.querySelector(`input.qty-hidden[name="barang[${index}][qty]"]`);
                    if (hiddenQtyInput) {
                        hiddenQtyInput.value = qtyValue;
                    }
                    renderCart(); // Render ulang keranjang untuk update subtotal
                }
            });
        });

        // Event listeners untuk tombol hapus
        document.querySelectorAll('.btn-remove').forEach(button => {
            button.addEventListener('click', (e) => {
                const index = e.target.getAttribute('data-index');
                cart.splice(index, 1); // Hapus item dari cart
                renderCart(); // Render ulang keranjang
            });
        });
    }

    // Filter barang berdasarkan pencarian
    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value.toLowerCase();
        const filteredBarang = barangData.filter(item =>
            item.nama_barang.toLowerCase().includes(keyword) ||
            (item.brand && item.brand.toLowerCase().includes(keyword))
        );
        displayedCount = 4; // Reset displayed count when searching
        renderBarang(filteredBarang);
    });

    // Tampilkan lebih banyak barang
    showMoreButton.addEventListener('click', () => {
        displayedCount += 4;
        renderBarang(barangData.filter(item =>
            item.nama_barang.toLowerCase().includes(searchInput.value.toLowerCase())
        ));
    });

    // Event delegation untuk tombol tambah barang
    barangCardsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-add-barang')) {
            const button = e.target;
            const kode = button.getAttribute('data-kode');
            const nama = button.getAttribute('data-nama');
            const harga = button.getAttribute('data-harga');
            addToCart(kode, nama, harga);
        }
    });

    // Inisialisasi tampilan barang
    renderBarang(barangData);
</script>

<?= $this->endSection() ?>