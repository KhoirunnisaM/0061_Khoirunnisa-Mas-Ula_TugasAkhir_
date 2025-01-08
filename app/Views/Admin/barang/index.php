<?= $this->extend('Admin/layouts/main') ?>
<?= $this->section('title') ?>
PANEL ADMIN
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container mt-5">
    <!-- Data Barang and Add Button inside the container -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><i class="nav-icon fas fa-cubes"></i> Data Barang</h1>
        <a href="<?= site_url('Admin/barang/create'); ?>" class="btn btn-primary">Tambah Barang</a>
    </div>
    <p class="text-danger"><strong>Barang Not Ready</strong> Silakan nota barang di menu pembelian untuk mempersiapkan penjualan</p>
    
    <!-- Show entries and Search inside the container -->
    <div class="d-flex justify-content-between mb-3">
        <!-- Show entries -->
        <div>
            <label>Show 
                <select class="form-select form-select-sm" style="width: auto;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select> entries
            </label>
        </div>
        <!-- Search -->
        <div>
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search..." onkeyup="searchTable()">
        </div>
    </div>
    
    <!-- Table inside the container -->
    <table class="table table-bordered" id="barangTable">
        <thead class="bg-dark text-white">
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Brand</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barang as $b): ?>
                <tr>
                    <td><?= $b['kode_barang']; ?></td>
                    <td><?= $b['nama_barang']; ?></td>
                    <td><?= $b['brand']; ?></td>
                    <td>
                        <?php if ($b['stok'] == null) : ?>
                            <span class="text-danger">Not Ready</span>
                        <?php elseif ($b['stok'] > 0) : ?>
                            <?= $b['stok'] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($b['harga'] == null) : ?>
                            <span class="text-danger">Not Ready</span>
                        <?php elseif ($b['stok'] > 0) : ?>
                             <?= $b['harga'] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($b['active'] == 1) : ?>
                            <span class="text-success">Ready</span>
                        <?php elseif ($b['active'] == 0) : ?>
                            <span class="text-danger">Not Ready</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('Admin/barang/edit/' . $b['kode_barang']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= site_url('Admin/barang/hapus/' . $b['kode_barang']); ?>" class="btn btn-danger btn-sm delete-btn">Hapus</a>
                        <script>
                            document.querySelectorAll('.delete-btn').forEach(function(button) {
                                button.addEventListener('click', function(event) {
                                    event.preventDefault(); // Mencegah link untuk langsung mengarah ke URL

                                    const url = this.getAttribute('href'); // Ambil URL penghapusan

                                    // Tampilkan SweetAlert konfirmasi
                                    Swal.fire({
                                        title: 'Apakah Anda yakin?',
                                        text: 'Data barang ini akan dihapus!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#3085d6',
                                        confirmButtonText: 'Hapus',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Jika pengguna mengonfirmasi, arahkan ke URL penghapusan
                                            window.location.href = url;
                                        }
                                    });
                                });
                            });
                        </script>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function searchTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("barangTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td");
            let found = false;

            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    let txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                    }
                }
            }

            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>

<?= $this->endSection() ?>
