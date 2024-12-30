<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Supplier;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BarangModel;
use App\Models\UsersModel;
use App\Models\SupplierModel;
use App\Models\PembelianModel;
use App\Models\Penjualan;
use App\Models\PenjualanModel;
use App\Models\Users;

class Pegawai extends BaseController

{
    public function dashboard()
    {
        return view('pegawai/dashboard');
    }

    // Barang
    public function barang()
    {
        $barangModel = new Barang();
        $data['barang'] = $barangModel->findAll();
        return view('pegawai/barang', $data);
    }

    public function tambahBarang()
    {
        if ($this->request->getMethod() === 'post') {
            $barangModel = new Barang();
            $barangModel->save($this->request->getPost());
            return redirect()->to('/pegawai/barang');
        }
        return view('pegawai/tambah_barang');
    }

    public function editBarang($id)
    {
        $barangModel = new Barang();
        $data['barang'] = $barangModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $barangModel->update($id, $this->request->getPost());
            return redirect()->to('/pegawai/barang');
        }

        return view('pegawai/edit_barang', $data);
    }

    public function hapusBarang($id)
    {
        $barangModel = new Barang();
        $barangModel->delete($id);
        return redirect()->to('/pegawai/barang');
    }

    public function searchBarang()
    {
        $keyword = $this->request->getPost('keyword');
        $barangModel = new Barang();
        $data['barang'] = $barangModel->like('nama_barang', $keyword)->findAll();
        return view('pegawai/barang', $data);
    }

    // Users
    public function Users()
    {
        $UsersModel = new Users();
        $data['Users'] = $UsersModel->findAll();
        return view('pegawai/Users', $data);
    }

    public function tambahUsers()
    {
        if ($this->request->getMethod() === 'post') {
            $UsersModel = new Users();
            $UsersModel->save($this->request->getPost());
            return redirect()->to('/pegawai/Users');
        }
        return view('pegawai/tambah_Users');
    }

    public function detailUsers($id)
    {
        $UsersModel = new Users();
        $data['Users'] = $UsersModel->find($id);
        return view('pegawai/detail_Users', $data);
    }

    public function editUsers($id)
    {
        $UsersModel = new Users();
        $data['Users'] = $UsersModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $UsersModel->update($id, $this->request->getPost());
            return redirect()->to('/pegawai/Users');
        }

        return view('pegawai/edit_Users', $data);
    }

    public function hapusUsers($id)
    {
        $UsersModel = new Users();
        $UsersModel->delete($id);
        return redirect()->to('/pegawai/Users');
    }

    public function searchUsers()
    {
        $keyword = $this->request->getPost('keyword');
        $UsersModel = new Users();
        $data['Users'] = $UsersModel->like('fullname', $keyword)->findAll();
        return view('pegawai/Users', $data);
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
                return redirect()->to('/pegawai/Users')->with('message', 'Password berhasil diubah.');
            }

            return redirect()->back()->with('error', 'Password saat ini salah.');
        

        $data['Users'] =  $Users ->find($id);
        return view('pegawai/ubah_password', $data);
    } 
}

    // Supplier
    public function supplier()
    {
        $supplierModel = new Supplier();
        $data['supplier'] = $supplierModel->findAll();
        return view('pegawai/supplier', $data);
    }

    public function tambahSupplier()
    {
        if ($this->request->getMethod() === 'post') {
            $supplierModel = new Supplier();
            $supplierModel->save($this->request->getPost());
            return redirect()->to('/pegawai/supplier');
        }
        return view('pegawai/tambah_supplier');
    }

    public function editSupplier($id)
    {
        $supplierModel = new Supplier();
        $data['supplier'] = $supplierModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $supplierModel->update($id, $this->request->getPost());
            return redirect()->to('/pegawai/supplier');
        }

        return view('pegawai/edit_supplier', $data);
    }

    public function hapusSupplier($id)
    {
        $supplierModel = new Supplier();
        $supplierModel->delete($id);
        return redirect()->to('/pegawai/supplier');
    }

    public function searchSupplier()
    {
        $keyword = $this->request->getPost('keyword');
        $supplierModel = new Supplier();
        $data['supplier'] = $supplierModel->like('nama_supplier', $keyword)->findAll();
        return view('pegawai/supplier', $data);
    }

    // Pembelian
    public function pembelian()
    {
        $pembelianModel = new Pembelian();
        $data['pembelian'] = $pembelianModel->findAll();
        return view('pegawai/pembelian', $data);
    }

    public function tambahPembelian()
    {
        if ($this->request->getMethod() === 'post') {
            $pembelianModel = new Pembelian();
            $pembelianModel->save($this->request->getPost());
            return redirect()->to('/pegawai/pembelian');
        }
        return view('pegawai/tambah_pembelian');
    }

    public function detailPembelian($id)
    {
        $pembelianModel = new Pembelian();
        $data['pembelian'] = $pembelianModel->find($id);
        return view('pegawai/detail_pembelian', $data);
    }

    public function editPembelian($id)
    {
        $pembelianModel = new Pembelian();
        $data['pembelian'] = $pembelianModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $pembelianModel->update($id, $this->request->getPost());
            return redirect()->to('/pegawai/pembelian');
        }

        return view('pegawai/edit_pembelian', $data);
    }

    public function hapusPembelian($id)
    {
        $pembelianModel = new Pembelian();
        $pembelianModel->delete($id);
        return redirect()->to('/pegawai/pembelian');
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
        $penjualanModel = new Penjualan();
        $data['penjualan'] = $penjualanModel->findAll();
        return view('pegawai/penjualan', $data);
    }

    public function tambahPenjualan()
    {
        if ($this->request->getMethod() === 'post') {
            $penjualanModel = new Penjualan();
            $penjualanModel->save($this->request->getPost());
            return redirect()->to('/pegawai/penjualan');
        }
        return view('pegawai/tambah_penjualan');
    }

    public function detailPenjualan($id)
    {
        $penjualanModel = new Penjualan();
        $data['penjualan'] = $penjualanModel->find($id);
        return view('pegawai/detail_penjualan', $data);
    }

    public function editPenjualan($id)
    {
        $penjualanModel = new Penjualan();
        $data['penjualan'] = $penjualanModel->find($id);

        if ($this->request->getMethod() === 'post') {
            $penjualanModel->update($id, $this->request->getPost());
            return redirect()->to('/pegawai/penjualan');
        }

        return view('pegawai/edit_penjualan', $data);
    }

    public function hapusPenjualan($id)
    {
        $penjualanModel = new Penjualan();
        $penjualanModel->delete($id);
        return redirect()->to('/pegawai/penjualan');
    }

    public function searchPenjualan()
    {
        $keyword = $this->request->getPost('keyword');
        $penjualanModel = new Penjualan();
        $data['penjualan'] = $penjualanModel->like('id_penjualan', $keyword)->findAll();
        return view('pegawai/penjualan', $data);
    }

    // Laporan
    public function laporan()
    {
        return view('pegawai/laporan');
    }

    public function cariLaporan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $penjualanModel = new Penjualan();
        $pembelianModel = new Pembelian();

        $data['penjualan'] = $penjualanModel->cariLaporan($bulan, $tahun);
        $data['pembelian'] = $pembelianModel->cariLaporan($bulan, $tahun);

        return view('pegawai/laporan', $data);
    }

    public function cetakLaporan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $penjualanModel = new Penjualan();
        $pembelianModel = new Pembelian();

        $data['penjualan'] = $penjualanModel->cariLaporan($bulan, $tahun);
        $data['pembelian'] = $pembelianModel->cariLaporan($bulan, $tahun);

        return view('pegawai/cetak_laporan', $data);
    }
}

