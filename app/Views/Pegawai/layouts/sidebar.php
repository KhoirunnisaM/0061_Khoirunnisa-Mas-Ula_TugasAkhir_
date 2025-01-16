<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="mt-5 pb-3 mb-3 d-flex justify-content-center align-items-center">
            <div class="image">
                <img src="<?= base_url('uploads/logo.png') ?>" alt="logo" width="120" height="120" >
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <div class="user-panel nav-item mt-2 pb-2">
                    <a href="<?= base_url('Pegawai/dashboard'); ?>" class="nav-link <?= (uri_string() === 'Pegawai/dashboard') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </div>
                <div class="user-panel nav-item mt-2 pb-2">
                    <a href="<?= base_url('Pegawai/barang'); ?>" class="nav-link <?= (uri_string() === 'Pegawai/barang' || uri_string() === 'Pegawai/barang/create' || strpos(uri_string(), 'Pegawai/barang/edit') === 0) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Data Barang
                        </p>
                    </a>
                </div>
                <div class="user-panel nav-item mt-2 pb-2">
                    <a href="<?= base_url('Pegawai/pembelian'); ?>" class="nav-link <?= (uri_string() === 'Pegawai/pembelian' || uri_string() === 'Pegawai/pembelian/create' || strpos(uri_string(), 'Pegawai/pembelian/edit') === 0) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Data Pembelian
                        </p>
                    </a>
                </div>
                <div class="user-panel nav-item mt-2 pb-2">
                    <a href="<?= base_url('Pegawai/penjualan'); ?>" class="nav-link <?= (uri_string() === 'Pegawai/penjualan' || uri_string() === 'Pegawai/penjualan/create' || strpos(uri_string(), 'Pegawai/penjualan/edit') === 0) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Data Penjualan
                        </p>
                    </a>
                </div>
                <div class="user-panel nav-item mt-2 pb-2 <?= (strpos(uri_string(), 'laporan') !== false) ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= (uri_string() === 'Pegawai/stokBarang') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Laporan Stok Barang
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/Pegawai/laporan/stok-bulanan" class="nav-link <?= (uri_string() === 'Pegawai/laporan/stok-bulanan') ? 'active' : ''; ?>">
                                <p>Laporan Stok Bulanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/Pegawai/laporan/pembelian-bulanan" class="nav-link <?= (uri_string() === 'Pegawai/laporan/pembelian-bulanan') ? 'active' : ''; ?>">
                                <p>Laporan Bulanan Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/Pegawai/laporan/penjualan-bulanan" class="nav-link <?= (uri_string() === 'Pegawai/laporan/penjualan-bulanan') ? 'active' : ''; ?>">
                                <p>Laporan Penjualan Barang</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
