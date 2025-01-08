<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="mt-5 pb-3 mb-3 d-flex justify-content-center align-items-center">
            <div class="image">
                <img src="https://cdn-icons-png.flaticon.com/128/10469/10469224.png" alt="logo">
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <div class="user-panel nav-item mt-2 pb-2">
                    <a href="<?= base_url('Admin/dashboard'); ?>" class="nav-link <?= (uri_string() === 'Admin/dashboard') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </div>
                <div class="user-panel nav-item mt-2 pb-2">
                    <a href="<?= base_url('Admin/barang'); ?>" class="nav-link <?= (uri_string() === 'Admin/barang' || uri_string() === 'Admin/barang/create' || strpos(uri_string(), 'Admin/barang/edit') === 0) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Data Barang
                        </p>
                    </a>
                </div>
                <div class="user-panel nav-item mt-2 pb-2">
                    <a href="<?= base_url('Admin/pegawai'); ?>" class="nav-link <?= (uri_string() === 'Admin/pegawai' || uri_string() === 'Admin/pegawai/create' || strpos(uri_string(), 'Admin/pegawai/edit') === 0) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Data Pegawai
                        </p>
                    </a>
                </div>
                <div class="user-panel nav-item mt-2 pb-2">
                    <a href="<?= base_url('Admin/supplier'); ?>" class="nav-link <?= (uri_string() === 'Admin/supplier' || uri_string() === 'Admin/supplier/create' || strpos(uri_string(), 'Admin/supplier/edit') === 0) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Data Supplier
                        </p>
                    </a>
                </div>
                <div class="user-panel nav-item mt-2 pb-2">
                    <a href="<?= base_url('Admin/pembelian'); ?>" class="nav-link <?= (uri_string() === 'Admin/pembelian' || uri_string() === 'Admin/pembelian/create' || strpos(uri_string(), 'Admin/pembelian/edit') === 0) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Data Pembelian
                        </p>
                    </a>
                </div>
                <div class="user-panel nav-item mt-2 pb-2">
                    <a href="<?= base_url('Admin/penjualan'); ?>" class="nav-link <?= (uri_string() === 'Admin/penjualan' || uri_string() === 'Admin/penjualan/create' || strpos(uri_string(), 'Admin/penjualan/edit') === 0) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Data Penjualan
                        </p>
                    </a>
                </div>
                <div class="user-panel nav-item mt-2 pb-2 <?= (strpos(uri_string(), 'laporan') !== false) ? 'menu-open' : ''; ?>">
                    <a href="<?= base_url('Admin/stokBarang'); ?>" class="nav-link <?= (uri_string() === 'Admin/stokBarang') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Laporan Stok Barang
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/Admin/laporan/stok-bulanan" class="nav-link <?= (uri_string() === 'Admin/laporan/stok-bulanan') ? 'active' : ''; ?>">
                                <p>Laporan Stok Bulanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/Admin/laporan/pembelian-bulanan" class="nav-link <?= (uri_string() === 'Admin/laporan/pembelian-bulanan') ? 'active' : ''; ?>">
                                <p>Laporan Bulanan Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/Admin/laporan/penjualan-bulanan" class="nav-link <?= (uri_string() === 'Admin/laporan/penjualan-bulanan') ? 'active' : ''; ?>">
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
