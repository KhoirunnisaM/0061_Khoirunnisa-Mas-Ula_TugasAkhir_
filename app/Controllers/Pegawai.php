<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Supplier;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BarangModel;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use App\Models\UsersModel;
use App\Models\SupplierModel;
use App\Models\PembelianModel;
use App\Models\Penjualan;
use App\Models\PenjualanModel;
use App\Models\Users;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\DetailPenjualanModel;

class Pegawai extends BaseController
{
    protected $supplierModel;
    protected $barangModel;
    protected $detailPenjualanModel;

    public function __construct()
    {
        $this->supplierModel = new Supplier();
        $this->barangModel = new Barang();
        $this->detailPenjualanModel = new DetailPenjualan();
    }

    public function dashboard()
    {
        $data['totalSupplier'] = $this->supplierModel->countAllResults();
        $data['totalBarang'] = $this->barangModel->countAllResults();
        $data['totalStokBarang'] = $this->barangModel->selectSum('stok')->get()->getRow()->stok;
        $data['totalBarangTerjual'] = $this->detailPenjualanModel->selectSum('qty')->get()->getRow()->qty;

        return view('Pegawai/dashboard', $data);
    }


    // Barang
    public function barang()
    {
        $barangModel = new Barang();
        $data['barang'] = $barangModel->findAll();
        return view('Pegawai/barang/index', $data);
    }

    public function searchBarang()
    {
        $keyword = $this->request->getPost('keyword');
        $barangModel = new Barang();
        $data['barang'] = $barangModel->like('nama_barang', $keyword)->findAll();
        return view('Pegawai/barang', $data);
    }


    // Pembelian
    public function pembelian()
    {
        $db = \Config\Database::connect();

        $query = $db->table('pembelian')
            ->select('pembelian.id_pembelian, pembelian.tgl_pembelian, supplier.nama_supplier, user.fullname as nama_user, 
                      COUNT(detail_pembelian.kode_barang) as total_qty, SUM(detail_pembelian.qty * detail_pembelian.harga) as total_harga')
            ->join('supplier', 'pembelian.id_supplier = supplier.id_supplier', 'left')
            ->join('user', 'pembelian.id_user = user.id_user', 'left')
            ->join('detail_pembelian', 'pembelian.id_pembelian = detail_pembelian.id_pembelian', 'left')
            ->groupBy('pembelian.id_pembelian')
            ->get();

        $data['pembelian'] = $query->getResultArray();

        return view('pegawai/pembelian/index', $data);
    }

    public function tambahPembelian()
    {
        $supplierModel = new Supplier();
        $barangModel = new Barang();

        if ($this->request->getMethod() === 'POST') {
            $pembelianModel = new Pembelian();
            $detailPembelianModel = new DetailPembelian();

            date_default_timezone_set('Asia/Jakarta');
            $currentDate = date('d-m-Y-His');
            $idPembelian = "ID" . date('dmYHis');

            $pembelianData = [
                'id_pembelian' => $idPembelian,
                'tgl_pembelian' => date('Y-m-d H:i:s'),
                'id_supplier' => $this->request->getPost('id_supplier'),
                'id_user' => session('id_user')
            ];

            $pembelianModel->insert($pembelianData);

            $barangList = $this->request->getPost('barang');
            foreach ($barangList as $barang) {
                $detailPembelianModel->insert([
                    'id_pembelian' => $idPembelian,
                    'kode_barang' => $barang['kode_barang'],
                    'qty' => $barang['qty'],
                    'harga' => $barang['harga']
                ]);

                $currentBarang = $barangModel->find($barang['kode_barang']);
                $updatedStock = $currentBarang['stok'] + $barang['qty'];

                $barangModel->update($barang['kode_barang'], [
                    'stok' => $updatedStock,
                    'harga' => $barang['harga']  + 20000,
                    'active' => 1
                ]);
            }

            return redirect()->to('/Pegawai/pembelian')->with('success', 'Pembelian berhasil ditambahkan.');
        }

        $data['suppliers'] = $supplierModel->findAll();
        $data['barang'] = $barangModel->findAll();

        return view('pegawai/pembelian/create', $data);
    }

    public function detailPembelian($id)
    {
        $pembelianModel = new Pembelian();
        $detailPembelianModel = new DetailPembelian();
        $barangModel = new Barang();

        $data['pembelian'] = $pembelianModel->find($id);
        $data['detailPembelian'] = $detailPembelianModel->where('id_pembelian', $id)->findAll();
        $data['barangModel'] = $barangModel;

        return view('pegawai/pembelian/detail', $data);
    }

    public function editPembelian($id)
    {
        $pembelianModel = new Pembelian();
        $detailPembelianModel = new DetailPembelian();
        $supplierModel = new Supplier();
        $barangModel = new Barang();

        $data['pembelian'] = $pembelianModel->find($id);
        $data['detailPembelian'] = $detailPembelianModel->where('id_pembelian', $id)->findAll();
        $data['suppliers'] = $supplierModel->findAll();
        $data['barang'] = $barangModel->findAll();

        return view('pegawai/pembelian/edit', $data);
    }

    public function updatePembelian($id)
    {
        $pembelianModel = new Pembelian();
        $detailPembelianModel = new DetailPembelian();
        $barangModel = new Barang();

        $pembelianData = [
            'id_supplier' => $this->request->getPost('id_supplier'),
            'id_user' => session('id_user'),
        ];

        $pembelianModel->update($id, $pembelianData);

        $detailPembelianModel->where('id_pembelian', $id)->delete();

        $barangList = $this->request->getPost('barang');
        foreach ($barangList as $barang) {
            $detailPembelianModel->insert([
                'id_pembelian' => $id,
                'kode_barang' => $barang['kode_barang'],
                'qty' => $barang['qty'],
                'harga' => $barang['harga'],
            ]);

            $currentBarang = $barangModel->find($barang['kode_barang']);
            $updatedStock = $currentBarang['stok'] + $barang['qty'];
            $barangModel->update($barang['kode_barang'], ['stok' => $updatedStock]);
        }

        return redirect()->to('/Pegawai/pembelian')->with('success', 'Pembelian berhasil diperbarui.');
    }

    public function hapusPembelian($id)
    {
        $pembelianModel = new Pembelian();
        $pembelianModel->delete($id);
        return redirect()->to('/Pegawai/pembelian')->with('success', 'Pembelian berhasil dihapus.');
    }

    public function searchPembelian()
    {
        $keyword = $this->request->getPost('keyword');
        $pembelianModel = new Pembelian();
        $data['pembelian'] = $pembelianModel->like('id_pembelian', $keyword)->findAll();
        return view('pegawai/pembelian', $data);
    }

    // Penjualan
    public function penjualan()
    {
        $db = \Config\Database::connect();

        $query = $db->table('penjualan')
            ->select('penjualan.id_penjualan, penjualan.tgl_penjualan, penjualan.nama_pembeli, user.fullname as nama_user, 
                      COUNT(detail_penjualan.kode_barang) as jumlah_barang, 
                      SUM(detail_penjualan.qty * detail_penjualan.harga) as total_harga')
            ->join('user', 'penjualan.id_user = user.id_user', 'left')
            ->join('detail_penjualan', 'penjualan.id_penjualan = detail_penjualan.id_penjualan', 'left')
            ->groupBy('penjualan.id_penjualan')
            ->get();

        $data['penjualan'] = $query->getResultArray();
        return view('pegawai/penjualan/index', $data);
    }

    public function tambahPenjualan()
    {
        $barangModel = new Barang();
        $userModel = new Users();

        if ($this->request->getMethod() === 'POST') {
            $penjualanModel = new Penjualan();
            $detailPenjualanModel = new DetailPenjualan();

            date_default_timezone_set('Asia/Jakarta');

            $idPenjualan = 'FP' . date('dmYHis');

            $penjualanData = [
                'id_penjualan' => $idPenjualan,
                'tgl_penjualan' => date('Y-m-d H:i:s'), 
                'nama_pembeli' => $this->request->getPost('nama_pembeli'),
                'id_user' => session('id_user'),
            ];

            if ($penjualanModel->insert($penjualanData)) {
                log_message('info', "Penjualan berhasil disimpan: " . json_encode($penjualanData));
            } else {
                log_message('error', "Gagal menyimpan penjualan: " . json_encode($penjualanData));
            }

            $barangList = $this->request->getPost('barang');
            if (is_array($barangList) && !empty($barangList)) {
                foreach ($barangList as $barang) {
                    $detailData = [
                        'id_penjualan' => $idPenjualan,
                        'kode_barang' => $barang['kode_barang'],
                        'qty' => $barang['qty'],
                        'harga' => $barang['harga'],
                    ];

                    if ($detailPenjualanModel->insert($detailData)) {
                        log_message('info', "Detail penjualan berhasil disimpan: " . json_encode($detailData));
                    } else {
                        log_message('error', "Gagal menyimpan detail penjualan: " . json_encode($detailData));
                    }

                    $currentBarang = $barangModel->find($barang['kode_barang']);
                    if ($currentBarang) {
                        $updatedStock = $currentBarang['stok'] - $barang['qty'];
                        if ($barangModel->update($barang['kode_barang'], ['stok' => $updatedStock])) {
                            log_message('info', "Stok barang berhasil diperbarui: Kode Barang - {$barang['kode_barang']}, Stok Baru - {$updatedStock}");
                        } else {
                            log_message('error', "Gagal memperbarui stok barang: Kode Barang - {$barang['kode_barang']}");
                        }
                    } else {
                        log_message('error', "Barang tidak ditemukan: Kode Barang - {$barang['kode_barang']}");
                    }
                }
            } else {
                log_message('error', "Barang list kosong atau tidak valid: " . json_encode($barangList));
            }

            return redirect()->to('/Pegawai/penjualan')->with('success', 'Penjualan berhasil ditambahkan.');
        }

        $data['barang'] = $barangModel->where('active', 1)->findAll();
        $data['users'] = $userModel->findAll();

        return view('pegawai/penjualan/create', $data);
    }

    public function detailPenjualan($id)
    {
        $penjualanModel = new Penjualan();
        $detailPenjualanModel = new DetailPenjualan();

        $penjualan = $penjualanModel
            ->select('penjualan.*, user.fullname as nama_user')
            ->join('user', 'penjualan.id_user = user.id_user', 'left')
            ->where('penjualan.id_penjualan', $id) 
            ->first();

        if (!$penjualan) {
            return redirect()->to('/pegawai/penjualan')->with('error', 'Penjualan tidak ditemukan.');
        }

        $detailPenjualan = $detailPenjualanModel
            ->select('detail_penjualan.*, barang.nama_barang')
            ->join('barang', 'detail_penjualan.kode_barang = barang.kode_barang', 'left')
            ->where('detail_penjualan.id_penjualan', $id)
            ->findAll();

        $data = [
            'penjualan' => $penjualan,
            'detailPenjualan' => $detailPenjualan,
        ];

        return view('pegawai/penjualan/detail', $data);
    }

    public function editPenjualan($id)
    {
        $penjualanModel = new Penjualan();
        $detailPenjualanModel = new DetailPenjualan();
        $barangModel = new Barang();

        $penjualan = $penjualanModel->where('id_penjualan', $id)->first();

        if (!$penjualan) {
            return redirect()->to('/Pegawai/penjualan')->with('error', 'Penjualan tidak ditemukan.');
        }

        $detailPenjualan = $detailPenjualanModel
            ->select('detail_penjualan.*, barang.nama_barang, barang.stok')
            ->join('barang', 'barang.kode_barang = detail_penjualan.kode_barang', 'left')
            ->where('id_penjualan', $id)
            ->findAll();

        $data = [
            'penjualan' => $penjualan,
            'detailPenjualan' => $detailPenjualan,
            'barang' => $barangModel->where('active', 1)->findAll(),
        ];

        return view('pegawai/penjualan/edit', $data);
    }

    public function updatePenjualan($id)
    {
        $penjualanModel = new Penjualan();
        $detailPenjualanModel = new DetailPenjualan();
        $barangModel = new Barang();

        $penjualanData = [
            'nama_pembeli' => $this->request->getPost('nama_pembeli'),
            'id_user' => session('id_user'),
        ];

        if (!$penjualanModel->update($id, $penjualanData)) {
            log_message('error', "Gagal memperbarui penjualan: " . json_encode($penjualanData));
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data penjualan.');
        }

        $oldDetails = $detailPenjualanModel->where('id_penjualan', $id)->findAll();
        $oldDetailsMap = [];
        foreach ($oldDetails as $detail) {
            $oldDetailsMap[$detail['kode_barang']] = $detail;
        }

        $barangList = $this->request->getPost('barang');
        if (!is_array($barangList) || empty($barangList)) {
            log_message('error', "Barang list kosong atau tidak valid: " . json_encode($barangList));
            return redirect()->back()->withInput()->with('error', 'Barang list tidak valid.');
        }

        $isUpdated = false;

        foreach ($barangList as $barang) {
            $kodeBarang = $barang['kode_barang'];
            $qtyBaru = $barang['qty'];
            $harga = $barang['harga'];

            if (isset($oldDetailsMap[$kodeBarang])) {
                $detailLama = $oldDetailsMap[$kodeBarang];
                $qtyLama = $detailLama['qty'];

                if ($qtyLama != $qtyBaru || $detailLama['harga'] != $harga) {
                    $isUpdated = true;

                    $detailPenjualanModel
                        ->where('id_penjualan', $id)
                        ->where('kode_barang', $kodeBarang)
                        ->set(['qty' => $qtyBaru, 'harga' => $harga])
                        ->update();

                    $barangDb = $barangModel->find($kodeBarang);
                    if ($barangDb) {
                        $stokBaru = $barangDb['stok'] + $qtyLama - $qtyBaru; 
                        if ($stokBaru < 0) {
                            log_message('error', "Stok tidak mencukupi untuk barang {$barangDb['nama_barang']}");
                            return redirect()->back()->withInput()->with('error', "Stok tidak mencukupi untuk barang: {$barangDb['nama_barang']}");
                        }
                        $barangModel->update($kodeBarang, ['stok' => $stokBaru]);
                    }
                }
            } else {
                $isUpdated = true;

                $detailPenjualanModel->insert([
                    'id_penjualan' => $id,
                    'kode_barang' => $kodeBarang,
                    'qty' => $qtyBaru,
                    'harga' => $harga,
                ]);

                $barangDb = $barangModel->find($kodeBarang);
                if ($barangDb) {
                    $stokBaru = $barangDb['stok'] - $qtyBaru;
                    if ($stokBaru < 0) {
                        log_message('error', "Stok tidak mencukupi untuk barang {$barangDb['nama_barang']}");
                        return redirect()->back()->withInput()->with('error', "Stok tidak mencukupi untuk barang: {$barangDb['nama_barang']}");
                    }
                    $barangModel->update($kodeBarang, ['stok' => $stokBaru]);
                }
            }
            unset($oldDetailsMap[$kodeBarang]);
        }

        foreach ($oldDetailsMap as $kodeBarang => $detail) {
            $isUpdated = true;

            $barangDb = $barangModel->find($kodeBarang);
            if ($barangDb) {
                $stokBaru = $barangDb['stok'] + $detail['qty'];
                $barangModel->update($kodeBarang, ['stok' => $stokBaru]);
            }
            $detailPenjualanModel->where('id_penjualan', $id)->where('kode_barang', $kodeBarang)->delete();
        }

        if (!$isUpdated) {
            return redirect()->to('/pegawai/penjualan')->with('success', 'Tidak ada perubahan pada penjualan.');
        }

        return redirect()->to('/Pegawai/penjualan')->with('success', 'Penjualan berhasil diperbarui.');
    }

    public function hapusPenjualan($id)
    {
        $penjualanModel = new Penjualan();
        $penjualanModel->delete($id);
        return redirect()->to('/Pegawai/penjualan')->with('success', 'Penjualan berhasil dihapus.');
    }

    // Laporan Stok Bulanan
    public function laporanStokBulan()
    {
        $detailPenjualanModel = new DetailPenjualan();
        $detailPembelianModel = new DetailPembelian();

        $penjualan = $detailPenjualanModel
            ->select('barang.kode_barang, barang.nama_barang, barang.brand, barang.stok, SUM(detail_penjualan.qty) as total_qty_penjualan')
            ->join('barang', 'barang.kode_barang = detail_penjualan.kode_barang')
            ->join('penjualan', 'detail_penjualan.id_penjualan = penjualan.id_penjualan')
            ->groupBy('barang.kode_barang')
            ->findAll();

        $pembelian = $detailPembelianModel
            ->select('barang.kode_barang, barang.nama_barang, barang.brand, barang.stok, SUM(detail_pembelian.qty) as total_qty_pembelian')
            ->join('barang', 'barang.kode_barang = detail_pembelian.kode_barang')
            ->join('pembelian', 'detail_pembelian.id_pembelian = pembelian.id_pembelian')
            ->groupBy('barang.kode_barang')
            ->findAll();

        $data = [];

        foreach ($penjualan as $p) {
            $kodeBarang = $p['kode_barang'];
            $data[$kodeBarang] = [
                'kode_barang' => $kodeBarang,
                'nama_barang' => $p['nama_barang'],
                'brand' => $p['brand'],
                'stok' => $p['stok'],
                'qty_penjualan' => $p['total_qty_penjualan'],
                'qty_pembelian' => 0, 
            ];
        }

        foreach ($pembelian as $p) {
            $kodeBarang = $p['kode_barang'];
            if (isset($data[$kodeBarang])) {
                $data[$kodeBarang]['qty_pembelian'] = $p['total_qty_pembelian'];
            } else {
                $data[$kodeBarang] = [
                    'kode_barang' => $kodeBarang,
                    'nama_barang' => $p['nama_barang'],
                    'brand' => $p['brand'],
                    'stok' => $p['stok'],
                    'qty_penjualan' => 0, 
                    'qty_pembelian' => $p['total_qty_pembelian'],
                ];
            }
        }

        return view('Pegawai/laporan/stokBulanan', ['data' => $data]);
    }

    public function cariStok()
    {
        $detailPenjualanModel = new DetailPenjualan();
        $detailPembelianModel = new DetailPembelian();

        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        if ($bulan) {
            $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        }

        $penjualanQuery = $detailPenjualanModel
            ->select('barang.kode_barang, barang.nama_barang, barang.brand, barang.stok, SUM(detail_penjualan.qty) as total_qty_penjualan')
            ->join('barang', 'barang.kode_barang = detail_penjualan.kode_barang')
            ->join('penjualan', 'detail_penjualan.id_penjualan = penjualan.id_penjualan')
            ->groupBy('barang.kode_barang');

        if ($bulan && $tahun) {
            $penjualanQuery->where("DATE_FORMAT(tgl_penjualan, '%Y-%m') = '$tahun-$bulan'");
        }

        $penjualan = $penjualanQuery->findAll();

        // Debugging
        log_message('debug', 'Query penjualan: ' . $detailPenjualanModel->getLastQuery());
        log_message('debug', 'Hasil penjualan: ' . json_encode($penjualan));

        $pembelianQuery = $detailPembelianModel
            ->select('barang.kode_barang, barang.nama_barang, barang.brand, barang.stok, SUM(detail_pembelian.qty) as total_qty_pembelian')
            ->join('barang', 'barang.kode_barang = detail_pembelian.kode_barang')
            ->join('pembelian', 'detail_pembelian.id_pembelian = pembelian.id_pembelian')
            ->groupBy('barang.kode_barang');

        if ($bulan && $tahun) {
            $pembelianQuery->where("DATE_FORMAT(tgl_pembelian, '%Y-%m') = '$tahun-$bulan'");
        }

        $pembelian = $pembelianQuery->findAll();

        // Debugging
        log_message('debug', 'Query pembelian: ' . $detailPembelianModel->getLastQuery());
        log_message('debug', 'Hasil pembelian: ' . json_encode($pembelian));

        $data = [];

        foreach ($penjualan as $p) {
            $kodeBarang = $p['kode_barang'];
            $data[$kodeBarang] = [
                'kode_barang' => $kodeBarang,
                'nama_barang' => $p['nama_barang'],
                'brand' => $p['brand'],
                'stok' => $p['stok'],
                'qty_penjualan' => $p['total_qty_penjualan'],
                'qty_pembelian' => 0, 
            ];
        }

        foreach ($pembelian as $p) {
            $kodeBarang = $p['kode_barang'];
            if (isset($data[$kodeBarang])) {
                $data[$kodeBarang]['qty_pembelian'] = $p['total_qty_pembelian'];
            } else {
                $data[$kodeBarang] = [
                    'kode_barang' => $kodeBarang,
                    'nama_barang' => $p['nama_barang'],
                    'brand' => $p['brand'],
                    'stok' => $p['stok'],
                    'qty_penjualan' => 0, 
                    'qty_pembelian' => $p['total_qty_pembelian'],
                ];
            }
        }

        // Debugging
        log_message('debug', 'Data gabungan: ' . json_encode($data));

        return view('Pegawai/laporan/stokBulanan', ['data' => $data, 'bulan' => $bulan, 'tahun' => $tahun]);
    }

    public function cetakStok()
    {
        $detailPenjualanModel = new DetailPenjualan();
        $detailPembelianModel = new DetailPembelian();

        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        if ($bulan) {
            $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        }

        $penjualanQuery = $detailPenjualanModel
            ->select('barang.kode_barang, barang.nama_barang, barang.brand, barang.stok, SUM(detail_penjualan.qty) as total_qty_penjualan')
            ->join('barang', 'barang.kode_barang = detail_penjualan.kode_barang')
            ->join('penjualan', 'detail_penjualan.id_penjualan = penjualan.id_penjualan')
            ->groupBy('barang.kode_barang');

        if ($bulan && $tahun) {
            $penjualanQuery->where("DATE_FORMAT(tgl_penjualan, '%Y-%m') = '$tahun-$bulan'");
        }

        $penjualan = $penjualanQuery->findAll();

        $pembelianQuery = $detailPembelianModel
            ->select('barang.kode_barang, barang.nama_barang, barang.brand, barang.stok, SUM(detail_pembelian.qty) as total_qty_pembelian')
            ->join('barang', 'barang.kode_barang = detail_pembelian.kode_barang')
            ->join('pembelian', 'detail_pembelian.id_pembelian = pembelian.id_pembelian')
            ->groupBy('barang.kode_barang');

        if ($bulan && $tahun) {
            $pembelianQuery->where("DATE_FORMAT(tgl_pembelian, '%Y-%m') = '$tahun-$bulan'");
        }

        $pembelian = $pembelianQuery->findAll();

        $data = [];
        foreach ($penjualan as $p) {
            $kodeBarang = $p['kode_barang'];
            $data[$kodeBarang] = [
                'kode_barang' => $kodeBarang,
                'nama_barang' => $p['nama_barang'],
                'brand' => $p['brand'],
                'stok' => $p['stok'],
                'qty_penjualan' => $p['total_qty_penjualan'],
                'qty_pembelian' => 0,
            ];
        }

        foreach ($pembelian as $p) {
            $kodeBarang = $p['kode_barang'];
            if (isset($data[$kodeBarang])) {
                $data[$kodeBarang]['qty_pembelian'] = $p['total_qty_pembelian'];
            } else {
                $data[$kodeBarang] = [
                    'kode_barang' => $kodeBarang,
                    'nama_barang' => $p['nama_barang'],
                    'brand' => $p['brand'],
                    'stok' => $p['stok'],
                    'qty_penjualan' => 0,
                    'qty_pembelian' => $p['total_qty_pembelian'],
                ];
            }
        }

        $html = view('Pegawai/laporan/cetakStok', ['data' => $data, 'bulan' => $bulan, 'tahun' => $tahun]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Laporan_Stok_' . ($bulan ?? 'Semua') . '_' . ($tahun ?? 'Data') . '.pdf', ['Attachment' => 1]);
    }
    // laporan pemebelian bulanan
    public function laporanPembelianBulanan()
    {
        $bulan = $this->request->getVar('bulan') ?? date('m'); 
        $tahun = $this->request->getVar('tahun') ?? date('Y'); 

        $pembelianModel = new \App\Models\Pembelian();

        $dataPembelian = $pembelianModel->select('pembelian.*, supplier.nama_supplier, detail_pembelian.qty, detail_pembelian.harga AS harga_satuan, barang.nama_barang, barang.brand')
            ->join('detail_pembelian', 'pembelian.id_pembelian = detail_pembelian.id_pembelian')
            ->join('barang', 'detail_pembelian.kode_barang = barang.kode_barang')
            ->join('supplier', 'pembelian.id_supplier = supplier.id_supplier')
            ->where('MONTH(pembelian.tgl_pembelian)', $bulan)
            ->where('YEAR(pembelian.tgl_pembelian)', $tahun)
            ->findAll();

        $data = [
            'pembelian' => $dataPembelian,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return view('Pegawai/laporan/pembelianBulanan', $data);
    }

    public function cetakLaporanPembelian()
    {
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');

        $pembelianModel = new Pembelian();

        $query = $pembelianModel->select('pembelian.*, supplier.nama_supplier, detail_pembelian.qty, detail_pembelian.harga AS harga_satuan, barang.nama_barang, barang.brand')
            ->join('detail_pembelian', 'pembelian.id_pembelian = detail_pembelian.id_pembelian')
            ->join('barang', 'detail_pembelian.kode_barang = barang.kode_barang')
            ->join('supplier', 'pembelian.id_supplier = supplier.id_supplier')
            ->where('MONTH(pembelian.tgl_pembelian)', $bulan)
            ->where('YEAR(pembelian.tgl_pembelian)', $tahun)
            ->findAll();

        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pembelian' => $query,
        ];

        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);

        $html = view('Pegawai/laporan/cetakLaporanPembelian', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("laporan_pembelian_bulanan.pdf", ["Attachment" => 0]);
    }

    // laporan penjualan bulanan
    public function laporanPenjualanBulanan()
    {
        $bulan = $this->request->getVar('bulan') ?? date('m'); 
        $tahun = $this->request->getVar('tahun') ?? date('Y'); 

        $penjualanModel = new \App\Models\Penjualan();

        $dataPenjualan = $penjualanModel->select('penjualan.*,  detail_penjualan.qty, detail_penjualan.harga AS harga_satuan, barang.nama_barang, barang.brand')
            ->join('detail_penjualan', 'penjualan.id_penjualan = detail_penjualan.id_penjualan')
            ->join('barang', 'detail_penjualan.kode_barang = barang.kode_barang')
            ->where('MONTH(penjualan.tgl_penjualan)', $bulan)
            ->where('YEAR(penjualan.tgl_penjualan)', $tahun)
            ->findAll();

        $data = [
            'penjualan' => $dataPenjualan,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return view('Pegawai/laporan/penjualanBulanan', $data);
    }

    public function cetakLaporanPenjualan()
    {
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');

        $penjualanModel = new Penjualan();

        $query = $penjualanModel->select('penjualan.*, detail_penjualan.qty, detail_penjualan.harga AS harga_satuan, barang.nama_barang, barang.brand')
            ->join('detail_penjualan', 'penjualan.id_penjualan = detail_penjualan.id_penjualan')
            ->join('barang', 'detail_penjualan.kode_barang = barang.kode_barang')
            ->where('MONTH(penjualan.tgl_penjualan)', $bulan)
            ->where('YEAR(penjualan.tgl_penjualan)', $tahun)
            ->findAll();

        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'penjualan' => $query,
        ];

        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);

        $html = view('Pegawai/laporan/cetakLaporanPenjualan', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("laporan_penjualan_bulanan.pdf", ["Attachment" => 0]);
    }
}
