<?= $this->extend('Pegawai/layouts/main') ?>
<?= $this->section('title') ?>
PANEL Pegawai - Data Penjualan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Data Penjualan</h1>
    <a href="<?= site_url('Pegawai/penjualan/create'); ?>" class="btn btn-primary mb-3">Tambah Penjualan</a>
    <table class="table table-bordered">
        <thead>
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
            <?php $no = 1;
            foreach ($penjualan as $item): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $item['id_penjualan']; ?></td>
                    <td><?= $item['tgl_penjualan']; ?></td>
                    <td><?= $item['nama_pembeli']; ?></td>
                    <td><?= $item['jumlah_barang']; ?></td>
                    <td><?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                    <td><?= $item['nama_user']; ?></td>
                    <td>
                        <a href="<?= site_url('Pegawai/penjualan/detail/' . $item['id_penjualan']); ?>" class="btn btn-info btn-sm">Detail</a>
                        <a href="<?= site_url('Pegawai/penjualan/edit/' . $item['id_penjualan']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm delete-btn" data-url="<?= site_url('Pegawai/penjualan/hapus/' . $item['id_penjualan']); ?>">Hapus</a>
                        <script>
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

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>