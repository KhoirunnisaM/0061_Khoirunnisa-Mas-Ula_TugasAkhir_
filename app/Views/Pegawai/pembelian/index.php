<?= $this->extend('Pegawai/layouts/main') ?>

<?= $this->section('title') ?>
PANEL PEGAWAI - Data Pembelian
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><i class="nav-icon fas fa-shopping-cart"></i> Data Pembelian</h1>
        <a href="<?= site_url('Pegawai/pembelian/create'); ?>" class="btn btn-primary">Tambah Pembelian</a>
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
    
    <!-- Table displaying Pembelian -->
    <table class="table table-bordered" id="pembelianTable">
        <thead class="bg-dark text-white">
            <tr>
                <th>No</th>
                <th>ID Pembelian</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Jumlah Jenis</th>
                <th>Total Harga</th>
                <th>Petugas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($pembelian as $item): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $item['id_pembelian']; ?></td>
                    <td><?= $item['tgl_pembelian']; ?></td>
                    <td><?= $item['nama_supplier']; ?></td>
                    <td><?= $item['total_qty']; ?></td>
                    <td><?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                    <td><?= $item['nama_user']; ?></td>
                    <td>
                        <a href="<?= site_url('Pegawai/pembelian/detail/' . $item['id_pembelian']); ?>" class="btn btn-info btn-sm">Detail</a>
                        <a href="<?= site_url('Pegawai/pembelian/edit/' . $item['id_pembelian']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $item['id_pembelian']; ?>">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function searchTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("pembelianTable");
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

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= site_url('Pegawai/pembelian/hapus/'); ?>" + id;
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>
