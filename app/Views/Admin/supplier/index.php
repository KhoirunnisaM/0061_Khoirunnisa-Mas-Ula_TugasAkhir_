<?= $this->extend('Admin/layouts/main') ?>

<?= $this->section('title') ?>
PANEL ADMIN - Data Supplier
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><i class="nav-icon fas fa-truck"></i> Data Supplier</h1>
        <a href="<?= site_url('Admin/supplier/create'); ?>" class="btn btn-primary">Tambah Supplier</a>
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
    
    <!-- Table displaying Supplier -->
    <table class="table table-bordered" id="supplierTable">
        <thead class="bg-dark text-white">
            <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>No. Telp</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($suppliers as $supplier): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $supplier['nama_supplier']; ?></td>
                    <td><?= $supplier['alamat']; ?></td>
                    <td><?= $supplier['telp']; ?></td>
                    <td>
                        <a href="<?= site_url('Admin/supplier/edit/' . $supplier['id_supplier']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= site_url('Admin/supplier/delete/' . $supplier['id_supplier']); ?>" class="btn btn-danger btn-sm delete-btn">Hapus</a>

                        <script>
                            document.querySelectorAll('.delete-btn').forEach(function(button) {
                                button.addEventListener('click', function(event) {
                                    event.preventDefault(); // Mencegah link untuk langsung mengarah ke URL

                                    const url = this.getAttribute('href'); // Ambil URL penghapusan

                                    // Tampilkan SweetAlert konfirmasi
                                    Swal.fire({
                                        title: 'Apakah Anda yakin?',
                                        text: 'Data supplier ini akan dihapus!',
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
        let table = document.getElementById("supplierTable");
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
