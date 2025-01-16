<?= $this->extend('Admin/layouts/main') ?>
<?= $this->section('title') ?>
PANEL ADMIN - Data Pegawai
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><i class="nav-icon fas fa-users"></i> Data Pegawai</h1>
        <a href="<?= site_url('Admin/pegawai/create'); ?>" class="btn btn-primary">Tambah Pegawai</a>
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
    
    <!-- Table displaying Pegawai -->
    <table class="table table-bordered" id="pegawaiTable">
        <thead class="bg-dark text-white">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama Lengkap</th> 
                <th>Status</th>
                <th>Terakhir Login</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($Users as $user): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $user['username']; ?></td>
                    <td><?= $user['fullname']; ?></td>
                    <td><?= $user['active'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>
                    <td><?= $user['last_login']; ?></td>
                    <td>
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#detailModal<?= $user['id_user']; ?>">Detail</button>
                        <a href="<?= site_url('Admin/pegawai/edit/' . $user['id_user']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= site_url('Admin/pegawai/hapus/' . $user['id_user']); ?>" class="btn btn-danger btn-sm delete-btn">Hapus</a>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal<?= $user['id_user']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel">Detail Pegawai</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="card-text"><strong>Username:</strong> <?= $user['username']; ?></p>
                                                <p class="card-text"><strong>Nama Lengkap:</strong> <?= $user['fullname']; ?></p>
                                                <p class="card-text"><strong>Alamat:</strong> <?= $user['alamat']; ?></p>
                                                <p class="card-text"><strong>No. HP:</strong> <?= $user['hp']; ?></p>
                                                <p class="card-text"><strong>Foto:</strong></p>
                                                <img src="<?= base_url('uploads/' . $user['foto']); ?>" alt="Foto" class="img-fluid rounded mb-3" style="max-width: 150px;">
                                                <p class="card-text"><strong>Level:</strong> <?= ucfirst($user['level']); ?></p>
                                                <p class="card-text"><strong>Status:</strong> <?= $user['active'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></p>
                                                <p class="card-text"><strong>Terakhir Login:</strong> <?= $user['last_login']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

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
        let table = document.getElementById("pegawaiTable");
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