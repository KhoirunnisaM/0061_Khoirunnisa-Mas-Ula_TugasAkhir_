<?= $this->extend('Admin/layouts/main') ?>

<?= $this->section('title') ?>
PANEL ADMIN - Data Penjualan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><i class="nav-icon fas fa-store"></i> Data Penjualan</h1>
        <a href="<?= site_url('Admin/penjualan/create'); ?>" class="btn btn-primary">Tambah Penjualan</a>
    </div>

    <!-- Show entries and Search -->
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
    
    <!-- Table displaying Penjualan -->
    <table class="table table-bordered" id="penjualanTable">
        <thead class="bg-dark text-white">
            <tr>
                <th>No</th>
                <th>ID Penjualan</th>
                <th>Tanggal Penjualan</th>
                <th>Nama Pembeli</th>
                <th>Jumlah Barang</th>
                <th>Total Harga</th>
                <th>Petugas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($penjualan as $item): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $item['id_penjualan']; ?></td>
                    <td><?= $item['tgl_penjualan']; ?></td>
                    <td><?= $item['nama_pembeli']; ?></td>
                    <td><?= $item['jumlah_barang']; ?></td>
                    <td><?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                    <td><?= $item['nama_user']; ?></td>
                    <td>
                        <a href="<?= site_url('Admin/penjualan/detail/' . $item['id_penjualan']); ?>" class="btn btn-info btn-sm">Detail</a>
                        <a href="<?= site_url('Admin/penjualan/edit/' . $item['id_penjualan']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm delete-btn" data-url="<?= site_url('Admin/penjualan/hapus/' . $item['id_penjualan']); ?>">Hapus</a>
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
        let table = document.getElementById("penjualanTable");
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

    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const deleteUrl = this.getAttribute('data-url');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect ke URL untuk menghapus data
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    });
</script>

<?= $this->endSection() ?>
