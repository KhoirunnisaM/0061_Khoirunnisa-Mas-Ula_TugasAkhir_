<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::index'); // Halaman login
$routes->post('/login', 'Auth::login'); // Proses login
$routes->get('/logout', 'Auth::logout'); // Proses logout

// Routing dengan level akses
$routes->group('Admin', ['filter' => 'level:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');

    // data barang
    $routes->get('barang', 'Admin::barang');
    $routes->get('barang/create', 'Admin::tambahBarang');
    $routes->post('barang/store', 'Admin::tambahBarang');
    $routes->get('barang/edit/(:any)', 'Admin::editBarang/$1');
    $routes->post('barang/edit/(:any)', 'Admin::editBarang/$1');
    $routes->get('barang/hapus/(:any)', 'Admin::hapusBarang/$1');

    // data pegawai
    $routes->get('pegawai', 'Admin::pegawai');
    $routes->get('pegawai/create', 'Admin::tambahPegawai');
    $routes->post('pegawai/store', 'Admin::tambahPegawai');
    $routes->get('pegawai/edit/(:num)', 'Admin::editPegawai/$1');
    $routes->post('pegawai/edit/(:num)', 'Admin::editPegawai/$1');
    $routes->get('pegawai/hapus/(:any)', 'Admin::hapusPegawai/$1');

    // data supplier
    $routes->get('supplier', 'Admin::supplier');
    $routes->get('supplier/create', 'Admin::tambahSupplier');
    $routes->post('supplier/store', 'Admin::tambahSupplier');
    $routes->get('supplier/edit/(:any)', 'Admin::editSupplier/$1');
    $routes->post('supplier/update/(:any)', 'Admin::editSupplier/$1');
    $routes->get('supplier/delete/(:any)', 'Admin::hapusSupplier/$1');

    // pembelian
    $routes->get('pembelian', 'Admin::pembelian');
    $routes->get('pembelian/create', 'Admin::tambahPembelian');
    $routes->post('pembelian/store', 'Admin::tambahPembelian');
    $routes->get('pembelian/edit/(:any)', 'Admin::editPembelian/$1');
    $routes->post('pembelian/update/(:any)', 'Admin::updatePembelian/$1');
    $routes->get('pembelian/hapus/(:any)', 'Admin::hapusPembelian/$1');
    $routes->get('pembelian/detail/(:any)', 'Admin::detailPembelian/$1');

    // penjualan 
    $routes->get('penjualan', 'Admin::penjualan');
    $routes->get('penjualan/create', 'Admin::tambahPenjualan');
    $routes->post('penjualan/store', 'Admin::tambahPenjualan');
    $routes->get('penjualan/edit/(:any)', 'Admin::editPenjualan/$1');
    $routes->post('penjualan/update/(:any)', 'Admin::updatePenjualan/$1');
    $routes->get('penjualan/hapus/(:any)', 'Admin::hapusPenjualan/$1');
    $routes->get('penjualan/detail/(:any)', 'Admin::detailPenjualan/$1');

    // laporan stok barang bulanan 
    $routes->get('laporan/stok-bulanan', 'Admin::laporanStokBulan');
    $routes->post('laporan/cariStok', 'Admin::cariStok');
    $routes->get('laporan/cetakStok', 'Admin::cetakStok');

    // laporan pembelian bulanan
    $routes->get('laporan/pembelian-bulanan', 'Admin::laporanPembelianBulanan');
    $routes->get('cetakLaporanPembelian', 'Admin::cetakLaporanPembelian');

    // laporan penjualan bulanan
    $routes->get('laporan/penjualan-bulanan', 'Admin::laporanPenjualanBulanan');
    $routes->get('cetakLaporanPenjualan', 'Admin::cetakLaporanPenjualan');
});

$routes->group('Pegawai', ['filter' => 'level:pegawai'], function ($routes) {
    $routes->get('dashboard', 'Pegawai::dashboard');


    // data barang
    $routes->get('barang', 'Pegawai::barang');
    $routes->get('barang/create', 'Pegawai::tambahBarang');
    $routes->post('barang/store', 'Pegawai::tambahBarang');
    $routes->get('barang/edit/(:any)', 'Pegawai::editBarang/$1');
    $routes->post('barang/edit/(:any)', 'Pegawai::editBarang/$1'); 
    $routes->get('barang/hapus/(:any)', 'Pegawai::hapusBarang/$1');

    // pembelian
    $routes->get('pembelian', 'Pegawai::pembelian');
    $routes->get('pembelian/create', 'Pegawai::tambahPembelian');
    $routes->post('pembelian/store', 'Pegawai::tambahPembelian');
    $routes->get('pembelian/edit/(:any)', 'Pegawai::editPembelian/$1');
    $routes->post('pembelian/update/(:any)', 'Pegawai::updatePembelian/$1');
    $routes->get('pembelian/hapus/(:any)', 'Pegawai::hapusPembelian/$1');
    $routes->get('pembelian/detail/(:any)', 'Pegawai::detailPembelian/$1');

    // penjualan 
    $routes->get('penjualan', 'Pegawai::penjualan');
    $routes->get('penjualan/create', 'Pegawai::tambahPenjualan');
    $routes->post('penjualan/store', 'Pegawai::tambahPenjualan');
    $routes->get('penjualan/edit/(:any)', 'Pegawai::editPenjualan/$1');
    $routes->post('penjualan/update/(:any)', 'Pegawai::updatePenjualan/$1');
    $routes->get('penjualan/hapus/(:any)', 'Pegawai::hapusPenjualan/$1');
    $routes->get('penjualan/detail/(:any)', 'Pegawai::detailPenjualan/$1');

    // laporan stok barang bulanan
    $routes->get('laporan/stok-bulanan', 'Pegawai::laporanStokBulan');
    $routes->get('laporan/cetakStok', 'Pegawai::cetakStok');

    // laporan stok barang bulanan
    $routes->get('laporan/stok-bulanan', 'Pegawai::laporanStokBulan');
    $routes->post('laporan/cariStok', 'Pegawai::cariStok');
    $routes->get('laporan/cetakStok', 'Pegawai::cetakStok');

    // laporan pembelian bulanan
    $routes->get('laporan/pembelian-bulanan', 'Pegawai::laporanPembelianBulanan');
    $routes->get('cetakLaporanPembelian', 'Pegawai::cetakLaporanPembelian');

    // laporan penjualan bulanan
    $routes->get('laporan/penjualan-bulanan', 'Pegawai::laporanPenjualanBulanan');
    $routes->get('cetakLaporanPenjualan', 'Pegawai::cetakLaporanPenjualan');
});
