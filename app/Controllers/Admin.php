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

class Admin extends BaseController
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

        return view('Admin/dashboard', $data);
    }


    // Barang
    public function barang()
    {
        $barangModel = new Barang();
        $data['barang'] = $barangModel->findAll();
        return view('Admin/barang/index', $data);
    }

    public function tambahBarang()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'kode_barang' => $this->request->getPost('kode_barang'),
                'nama_barang' => $this->request->getPost('nama_barang'),
                'brand'       => $this->request->getPost('brand'),
                'active'      => 0,
            ];

            $barangModel = new Barang();

            $existingBarang = $barangModel->where('kode_barang', $data['kode_barang'])->first();

            if ($existingBarang) {
                return redirect()->to('Admin/barang/create')->with('error', 'Kode barang sudah terdaftar. Silakan gunakan kode lain.');
            }

            try {
                $insertResult = $barangModel->insert($data);

                if ($insertResult === false) {
                    return redirect()->back()->with('error', 'Gagal menambahkan barang.');
                }

                return redirect()->to('/Admin/barang')->with('success', 'Barang berhasil ditambahkan.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan barang.');
            }
        }

        return view('Admin/barang/create');
    }

    public function editBarang($id)
    {

        $barangModel = new Barang();
        $barang = $barangModel->find($id);

        if (!$barang) {
            return redirect()->to('/Admin/barang')->with('error', 'Barang tidak ditemukan.');
        }

        if ($this->request->getMethod() === 'POST') {
            // Ambil data dari form
            $data = [
                'nama_barang' => $this->request->getPost('nama_barang'),
                'brand'       => $this->request->getPost('brand'),
            ];

            // Update data barang
            $barangModel->update($id, $data);

            // Redirect ke halaman barang dengan pesan sukses
            return redirect()->to('/Admin/barang')->with('success', 'Barang berhasil diperbarui.');
        }

        // Tampilkan form edit barang
        return view('Admin/barang/edit', ['barang' => $barang]);
    }

    public function hapusBarang($id)
    {
        $barangModel = new Barang();
        $barang = $barangModel->find($id);

        if (!$barang) {
            return redirect()->to('/Admin/barang')->with('error', 'Barang tidak ditemukan.');
        }

        $barangModel->delete($id);

        return redirect()->to('/Admin/barang')->with('success', 'Barang berhasil dihapus.');
    }

    public function searchBarang()
    {
        $keyword = $this->request->getPost('keyword');
        $barangModel = new Barang();
        $data['barang'] = $barangModel->like('nama_barang', $keyword)->findAll();
        return view('admin/barang', $data);
    }

    // Pegawai
    public function pegawai()
    {
        $UsersModel = new Users();
        $data['Users'] = $UsersModel
            ->where('level', 'pegawai')
            ->findAll();
        return view('Admin/pegawai/index', $data);
    }

    public function tambahPegawai()
    {
        if ($this->request->getMethod() === 'POST') {
            $UsersModel = new Users();

            $username = $this->request->getPost('username');

            if ($UsersModel->where('username', $username)->first()) {
                return redirect()->back()->with('error', 'Username sudah terdaftar. Silakan pilih username lain.');
            }

            $foto = $this->request->getFile('foto');
            $fotoName = null;

            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                $fotoName = $foto->getRandomName();

                $foto->move(FCPATH . 'uploads', $fotoName);
            }

            $data = [
                'username'  => $username,
                'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), 
                'fullname'  => $this->request->getPost('fullname'),
                'alamat'    => $this->request->getPost('alamat'),
                'hp'        => $this->request->getPost('hp'),
                'foto'      => $fotoName, 
                'level'     => 'pegawai',
                'active'    => 1,
            ];

            $UsersModel->insert($data);

            return redirect()->to('/Admin/pegawai')->with('success', 'Pegawai berhasil ditambahkan.');
        }

        return view('Admin/pegawai/create');
    }

    public function editPegawai($id_user)
    {
        $UsersModel = new Users();
        $user = $UsersModel->find($id_user);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User dengan ID $id_user tidak ditemukan.");
        }

        if ($this->request->getMethod() === 'POST') {
            $username = $this->request->getPost('username');

            if ($UsersModel->where('username', $username)->where('id_user !=', $id_user)->first()) {
                return redirect()->back()->with('error', 'Username sudah terdaftar. Silakan pilih username lain.');
            }

            $foto = $this->request->getFile('foto');
            $fotoName = $user['foto'];

            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                if ($fotoName && file_exists(FCPATH . 'uploads/' . $fotoName)) {
                    unlink(FCPATH . 'uploads/' . $fotoName); 
                }

                $fotoName = $foto->getRandomName();

                $foto->move(FCPATH . 'uploads', $fotoName);
            }

            $data = [
                'username'  => $username,
                'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'fullname'  => $this->request->getPost('fullname'),
                'alamat'    => $this->request->getPost('alamat'),
                'hp'        => $this->request->getPost('hp'),
                'foto'      => $fotoName, 
                'level'     => 'pegawai',
                'active'    => 1,
            ];

            $UsersModel->update($id_user, $data);

            return redirect()->to('/Admin/pegawai')->with('success', 'Pegawai berhasil diperbarui.');
        }

        return view('Admin/pegawai/edit', ['user' => $user]);
    }

    public function hapusPegawai($id)
    {
        $pegawaiModel = new Users();
        $barang = $pegawaiModel->find($id);

        if (!$barang) {
            return redirect()->to('/Admin/pegawai')->with('error', 'Data tidak ditemukan.');
        }

        $pegawaiModel->delete($id);

        return redirect()->to('/Admin/pegawai')->with('success', 'Data berhasil dihapus.');
    }

    // suplier
    public function supplier()
    {
        $supplierModel = new Supplier();
        $data['suppliers'] = $supplierModel->findAll();
        return view('Admin/supplier/index', $data);
    }

    public function tambahSupplier()
    {
        if ($this->request->getMethod() === 'POST') {
            $supplierModel = new Supplier();

            $nama_supplier = $this->request->getPost('nama_supplier');

            if ($supplierModel->where('nama_supplier', $nama_supplier)->first()) {
                return redirect()->back()->with('error', 'Nama supplier sudah terdaftar. Silakan pilih nama lain.');
            }

            $data = [
                'id_supplier'   => $this->request->getPost('id_supplier'),
                'nama_supplier' => $nama_supplier,
                'alamat'        => $this->request->getPost('alamat'),
                'telp'          => $this->request->getPost('hp'),
            ];

            $supplierModel->insert($data);

            return redirect()->to('/Admin/supplier')->with('success', 'Supplier berhasil ditambahkan.');
        }

        return view('Admin/supplier/create');
    }

    public function editSupplier($id_supplier)
    {
        $supplierModel = new Supplier();

        $data['supplier'] = $supplierModel->find($id_supplier);

        if (!$data['supplier']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Supplier dengan ID $id_supplier tidak ditemukan.");
        }

        if ($this->request->getMethod() === 'POST') {
            $dataUpdate = [
                'nama_supplier' => $this->request->getPost('nama_supplier'),
                'alamat'        => $this->request->getPost('alamat'),
                'telp'          => $this->request->getPost('telp'),
            ];

            $supplierModel->update($id_supplier, $dataUpdate);

            return redirect()->to('/Admin/supplier')->with('success', 'Supplier berhasil diperbarui.');
        }

        return view('Admin/supplier/edit', $data);
    }

    public function hapusSupplier($id)
    {
        $supplierModel = new Supplier();
        $barang = $supplierModel->find($id);

        if (!$barang) {
            return redirect()->to('/Admin/supplier')->with('error', 'Data tidak ditemukan.');
        }

        $supplierModel->delete($id);

        return redirect()->to('/Admin/supplier')->with('success', 'Data berhasil dihapus.');
    }

    public function searchSupplier()
    {
        $keyword = $this->request->getPost('keyword');
        $supplierModel = new Supplier();
        $data['supplier'] = $supplierModel->like('nama_supplier', $keyword)->findAll();
        return view('admin/supplier', $data);
    }

    //Users
    public function detailUsers($id)
    {
        $UsersModel = new Users();
        $data['Users'] = $UsersModel->find($id);
        return view('admin/detail_Users', $data);
    }

    public function editUsers($id)
    {
        $UsersModel = new Users();
        $data['Users'] = $UsersModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $UsersModel->update($id, $this->request->getPost());
            return redirect()->to('/admin/Users');
        }

        return view('admin/edit_Users', $data);
    }

    public function hapusUsers($id)
    {
        $UsersModel = new Users();
        $UsersModel->delete($id);
        return redirect()->to('/admin/Users');
    }

    public function searchUsers()
    {
        $keyword = $this->request->getPost('keyword');
        $UsersModel = new Users();
        $data['Users'] = $UsersModel->like('fullname', $keyword)->findAll();
        return view('admin/Users', $data);
    }

    public function ubahPasswordUsers($id)
    {
        if ($this->request->getMethod() === 'post') {
            $UsersModel = new Users();
            $Users = $UsersModel->find($id);

            $currentPassword = $this->request->getPost('current_password');
            $newPassword = $this->request->getPost('new_password');

            if (password_verify($currentPassword, $Users['password'])) {
                $UsersModel->update($id, ['password' => password_hash($newPassword, PASSWORD_BCRYPT)]);
                return redirect()->to('/admin/Users')->with('message', 'Password berhasil diubah.');
            }

            return redirect()->back()->with('error', 'Password saat ini salah.');


            $data['Users'] =  $Users->find($id);
            return view('admin/ubah_password', $data);
        }
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

        return view('admin/pembelian/index', $data);
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

            return redirect()->to('/Admin/pembelian')->with('success', 'Pembelian berhasil ditambahkan.');
        }

        $data['suppliers'] = $supplierModel->findAll();
        $data['barang'] = $barangModel->findAll();

        return view('admin/pembelian/create', $data);
    }

    public function detailPembelian($id)
    {
        $pembelianModel = new Pembelian();
        $detailPembelianModel = new DetailPembelian();
        $barangModel = new Barang();

        $data['pembelian'] = $pembelianModel->find($id);
        $data['detailPembelian'] = $detailPembelianModel->where('id_pembelian', $id)->findAll();
        $data['barangModel'] = $barangModel; 

        return view('admin/pembelian/detail', $data);
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

        return view('admin/pembelian/edit', $data);
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

        return redirect()->to('/Admin/pembelian')->with('success', 'Pembelian berhasil diperbarui.');
    }

    public function hapusPembelian($id)
    {
        $pembelianModel = new Pembelian();
        $pembelianModel->delete($id);
        return redirect()->to('/Admin/pembelian')->with('success', 'Pembelian berhasil dihapus.');
    }

    public function searchPembelian()
    {
        $keyword = $this->request->getPost('keyword');
        $pembelianModel = new Pembelian();
        $data['pembelian'] = $pembelianModel->like('id_pembelian', $keyword)->findAll();
        return view('admin/pembelian', $data);
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
        return view('admin/penjualan/index', $data);
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

            return redirect()->to('/Admin/penjualan')->with('success', 'Penjualan berhasil ditambahkan.');
        }

        $data['barang'] = $barangModel->where('active', 1)->findAll();
        $data['users'] = $userModel->findAll();

        return view('admin/penjualan/create', $data);
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
            return redirect()->to('/Admin/penjualan')->with('error', 'Penjualan tidak ditemukan.');
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

        return view('admin/penjualan/detail', $data);
    }

    public function editPenjualan($id)
    {
        $penjualanModel = new Penjualan();
        $detailPenjualanModel = new DetailPenjualan();
        $barangModel = new Barang();

        $penjualan = $penjualanModel->where('id_penjualan', $id)->first();

        if (!$penjualan) {
            return redirect()->to('/Admin/penjualan')->with('error', 'Penjualan tidak ditemukan.');
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

        return view('admin/penjualan/edit', $data);
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

        // Flag untuk mendeteksi perubahan
        $isUpdated = false;

        // Proses setiap barang dari input
        foreach ($barangList as $barang) {
            $kodeBarang = $barang['kode_barang'];
            $qtyBaru = $barang['qty'];
            $harga = $barang['harga'];

            if (isset($oldDetailsMap[$kodeBarang])) {
                // Barang sudah ada dalam detail lama
                $detailLama = $oldDetailsMap[$kodeBarang];
                $qtyLama = $detailLama['qty'];

                if ($qtyLama != $qtyBaru || $detailLama['harga'] != $harga) {
                    $isUpdated = true;

                    // Update detail hanya jika ada perubahan qty atau harga
                    $detailPenjualanModel
                        ->where('id_penjualan', $id)
                        ->where('kode_barang', $kodeBarang)
                        ->set(['qty' => $qtyBaru, 'harga' => $harga])
                        ->update();

                    // Update stok
                    $barangDb = $barangModel->find($kodeBarang);
                    if ($barangDb) {
                        $stokBaru = $barangDb['stok'] + $qtyLama - $qtyBaru; // Kembalikan stok lama dan kurangi dengan qty baru
                        if ($stokBaru < 0) {
                            log_message('error', "Stok tidak mencukupi untuk barang {$barangDb['nama_barang']}");
                            return redirect()->back()->withInput()->with('error', "Stok tidak mencukupi untuk barang: {$barangDb['nama_barang']}");
                        }
                        $barangModel->update($kodeBarang, ['stok' => $stokBaru]);
                    }
                }
            } else {
                // Barang baru ditambahkan
                $isUpdated = true;

                $detailPenjualanModel->insert([
                    'id_penjualan' => $id,
                    'kode_barang' => $kodeBarang,
                    'qty' => $qtyBaru,
                    'harga' => $harga,
                ]);

                // Kurangi stok barang baru
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
            // Hapus dari map karena sudah diproses
            unset($oldDetailsMap[$kodeBarang]);
        }

        // Hapus barang yang tidak ada dalam daftar baru
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
            return redirect()->to('/Admin/penjualan')->with('success', 'Tidak ada perubahan pada penjualan.');
        }

        return redirect()->to('/Admin/penjualan')->with('success', 'Penjualan berhasil diperbarui.');
    }

    public function hapusPenjualan($id)
    {
        $penjualanModel = new Penjualan();
        $penjualanModel->delete($id);
        return redirect()->to('/Admin/penjualan')->with('success', 'Penjualan berhasil dihapus.');
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

        return view('Admin/laporan/stokBulanan', ['data' => $data]);
    }


    public function cariStok()
    {
        $barangModel = new Barang();
        $detailPenjualanModel = new DetailPenjualan();
        $detailPembelianModel = new DetailPembelian();

        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $barangData = $barangModel->findAll();

        $penjualan = $detailPenjualanModel
            ->select('kode_barang, SUM(qty) as total_qty')
            ->join('penjualan', 'detail_penjualan.id_penjualan = penjualan.id_penjualan')
            ->where("MONTH(tgl_penjualan)", $bulan)
            ->where("YEAR(tgl_penjualan)", $tahun)
            ->groupBy('kode_barang')
            ->findAll();

        $pembelian = $detailPembelianModel
            ->select('kode_barang, SUM(qty) as total_qty')
            ->join('pembelian', 'detail_pembelian.id_pembelian = pembelian.id_pembelian')
            ->where("MONTH(tgl_pembelian)", $bulan)
            ->where("YEAR(tgl_pembelian)", $tahun)
            ->groupBy('kode_barang')
            ->findAll();

        $penjualanMap = [];
        foreach ($penjualan as $p) {
            $penjualanMap[$p['kode_barang']] = $p['total_qty'];
        }

        $pembelianMap = [];
        foreach ($pembelian as $p) {
            $pembelianMap[$p['kode_barang']] = $p['total_qty'];
        }

        $data = [];
        foreach ($barangData as $barang) {
            $kodeBarang = $barang['kode_barang'];
            $data[] = [
                'kode_barang' => $kodeBarang,
                'nama_barang' => $barang['nama_barang'],
                'brand' => $barang['brand'],
                'stok' => $barang['stok'],
                'qty_penjualan' => $penjualanMap[$kodeBarang] ?? 0,
                'qty_pembelian' => $pembelianMap[$kodeBarang] ?? 0,
            ];
        }

        return view('admin/laporan/stokBulanan', ['data' => $data, 'bulan' => $bulan, 'tahun' => $tahun]);
    }


    public function cetakStok()
    {
        $barangModel = new Barang();
        $detailPenjualanModel = new DetailPenjualan();
        $detailPembelianModel = new DetailPembelian();

        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $barangData = $barangModel->findAll();

        $penjualanQuery = $detailPenjualanModel
            ->select('kode_barang, SUM(qty) as total_qty')
            ->join('penjualan', 'detail_penjualan.id_penjualan = penjualan.id_penjualan')
            ->groupBy('kode_barang');

        if ($bulan && $tahun) {
            $penjualanQuery->where("MONTH(tgl_penjualan)", $bulan)
                ->where("YEAR(tgl_penjualan)", $tahun);
        }
        $penjualan = $penjualanQuery->findAll();

        $pembelianQuery = $detailPembelianModel
            ->select('kode_barang, SUM(qty) as total_qty')
            ->join('pembelian', 'detail_pembelian.id_pembelian = pembelian.id_pembelian')
            ->groupBy('kode_barang');

        if ($bulan && $tahun) {
            $pembelianQuery->where("MONTH(tgl_pembelian)", $bulan)
                ->where("YEAR(tgl_pembelian)", $tahun);
        }
        $pembelian = $pembelianQuery->findAll();

        $penjualanMap = [];
        foreach ($penjualan as $p) {
            $penjualanMap[$p['kode_barang']] = $p['total_qty'];
        }

        $pembelianMap = [];
        foreach ($pembelian as $p) {
            $pembelianMap[$p['kode_barang']] = $p['total_qty'];
        }

        $data = [];
        foreach ($barangData as $barang) {
            $kodeBarang = $barang['kode_barang'];
            $data[] = [
                'kode_barang' => $kodeBarang,
                'nama_barang' => $barang['nama_barang'],
                'brand' => $barang['brand'],
                'stok' => $barang['stok'],
                'qty_penjualan' => $penjualanMap[$kodeBarang] ?? 0,
                'qty_pembelian' => $pembelianMap[$kodeBarang] ?? 0,
            ];
        }

        $html = view('admin/laporan/cetakStok', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Laporan_Stok_' . $bulan . '_' . $tahun . '.pdf', ['Attachment' => 1]);
        exit;
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

        return view('admin/laporan/pembelianBulanan', $data);
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

        $html = view('Admin/laporan/cetakLaporanPembelian', $data);
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

        return view('admin/laporan/penjualanBulanan', $data);
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

        $html = view('Admin/laporan/cetakLaporanPenjualan', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("laporan_penjualan_bulanan.pdf", ["Attachment" => 0]);
    }
}
