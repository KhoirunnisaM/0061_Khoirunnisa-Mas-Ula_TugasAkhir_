<?= $this->extend('Pegawai/layouts/main') ?>
<?= $this->section('title') ?>
PANEL PEGAWAI
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <!-- Data Barang and Add Button inside the container -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><i class="nav-icon fas fa-cubes"></i> Data Barang</h1>
    </div>
    
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
                            <span class="text-danger">Non Aktif</span>
                        <?php elseif ($b['stok'] >= 0) : ?>
                            <?= $b['stok'] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($b['harga'] == null) : ?>
                            <span class="text-danger">Non Aktif</span>
                        <?php elseif ($b['stok'] >= 0) : ?>
                             <?= $b['harga'] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($b['active'] == 1) : ?>
                            <span class="text-success">Aktif</span>
                        <?php elseif ($b['active'] == 0) : ?>
                            <span class="text-danger">Non Aktif</span>
                        <?php endif; ?>
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
