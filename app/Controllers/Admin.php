<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Supplier;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    //BARANG
    protected $barangModel;

    public function __constructBarang()
    {
        $this->barangModel = new Barang();
    }

    public function indexBarang()
    {
        $data['barang'] = $this->barangModel->findAll();
        return view('barang/index', $data);
    }

    public function createBarang()
    {
        return view('barang/create');
    }

    public function storeBarang()
    {
        $this->barangModel->save([
            'kode_barang' => $this->request->getPost('kode_barang'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'brand' => $this->request->getPost('brand'),
            'stok' => $this->request->getPost('stok'),
            'harga' => $this->request->getPost('harga'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/barang');
    }

    public function editBarang($id)
    {
        $data['barang'] = $this->barangModel->find($id);
        return view('barang/edit', $data);
    }

    public function updateBarang($id)
    {
        $this->barangModel->update($id, [
            'kode_barang' => $this->request->getPost('kode_barang'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'brand' => $this->request->getPost('brand'),
            'stok' => $this->request->getPost('stok'),
            'harga' => $this->request->getPost('harga'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/barang');
    }

    public function deleteBarang($id)
    {
        $this->barangModel->delete($id);
        return redirect()->to('/barang');
    }

    //DASHBOARD
    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('dashboard/index');
    }
    
    //PEMBELIAN
        protected $pembelianModel;
        protected $supplierModel;
    
        public function __constructPembelian()
        {
            $this->pembelianModel = new Pembelian();
            $this->supplierModel = new Supplier();
        }
    
        public function dataPembelian()
        {
            $data['pembelian'] = $this->pembelianModel->findAll();
            return view('pembelian/index', $data);
        }
    
        public function createPembelian()
        {
            $data['suppliers'] = $this->supplierModel->findAll();
            return view('pembelian/create', $data);
        }
    
        public function storePembelian()
        {
            $this->pembelianModel->save([
                'kode_pembelian' => $this->request->getPost('kode_pembelian'),
                'id_supplier' => $this->request->getPost('id_supplier'),
                'tanggal' => $this->request->getPost('tanggal'),
                'total' => $this->request->getPost('total'),
            ]);
    
            return redirect()->to('/pembelian');
        }
}
