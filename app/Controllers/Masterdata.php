<?php

namespace App\Controllers;

use App\Models\StockModel;
use App\Models\PembelianModel;
use App\Models\JenisBebanModel;
use App\Models\PembayaranModel;
use App\Models\UserProfileModel;
use App\Models\JenisServiceModel;
use App\Controllers\BaseController;
use App\Models\DataKelolaAdminModel;
use App\Models\JenisTransaksiLainnyaModel;

class Masterdata extends BaseController
{
    protected $db, $builder;
    protected $PembelianModel;
    protected $DataKelolaAdminModel;
    protected $PembayaranModel;
    protected $StockModel;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->UserProfileModel = new UserProfileModel();
        $this->PembelianModel = new PembelianModel();
        $this->DataKelolaAdminModel = new DataKelolaAdminModel();
        $this->PembayaranModel = new PembayaranModel();
        $this->StockModel = new StockModel();
        $this->JenisServiceModel = new JenisServiceModel();
        $this->JenisTransaksiLainnyaModel = new JenisTransaksiLainnyaModel();
        $this->JenisBebanModel = new JenisBebanModel();
    }
    
    public function satuan()
    {
        $model = new DataKelolaAdminModel;
        $currentPage = $this->request->getVar('page_produk') ? $this->request->getVar('page_produk') : 1;
        $satuan = $this->db->table('tb_satuan')->get()->getResult();
        $data = [
            'model' => $model,
            'dataTransaksi' => $model->get(),
            'all_data' => $model->getDataTransaksi(),
            'totalPembelian' => $model->getTotalPembelian(),
            'namaAdmin' => $model->getNamaAdmin(),
            'tanggalPembelian' => $model->getTanggalPembelian(),
            'totalHistoryPembayaran' => $model->getTotalHistoryPembayaran(),
            'title' => 'Home',
            'tampil' => 'masterdata/satuan/index',
            'pager' => $model->pager,
            'currentPage' => $currentPage,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'satuan' => $satuan
        ];
        return view('wrapp', $data);
    }

    public function satuanSave()
    {
        $keterangan = $this->request->getVar('keterangan');
        $data = [
            'keterangan' => $keterangan
        ];
        $this->db->table('tb_satuan')
        ->insert($data);

        return redirect()->to('/user/dashboard/masterdata/satuan');
    }

    public function satuanEdit()
    {
        $id = $this->request->getVar('id');
        $keterangan = $this->request->getVar('keterangan');

        $data = [
            'keterangan' => $keterangan
        ];

        $this->db->table('tb_satuan')
        ->where('id', $id)
        ->update($data);

        return redirect()->to('/user/dashboard/masterdata/satuan');
    }

    /** pelanggan */
    public function pelanggan()
    {
        $model = new DataKelolaAdminModel;
        $currentPage = $this->request->getVar('page_produk') ? $this->request->getVar('page_produk') : 1;
        $pelanggan = $this->db->table('tb_pelanggan')->get()->getResult();

        $data = [
            'model' => $model,
            'dataTransaksi' => $model->get(),
            'all_data' => $model->getDataTransaksi(),
            'totalPembelian' => $model->getTotalPembelian(),
            'namaAdmin' => $model->getNamaAdmin(),
            'tanggalPembelian' => $model->getTanggalPembelian(),
            'totalHistoryPembayaran' => $model->getTotalHistoryPembayaran(),
            'title' => 'Home',
            'tampil' => 'masterdata/pelanggan/index',
            'pager' => $model->pager,
            'currentPage' => $currentPage,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'pelanggan' => $pelanggan,
        ];
        return view('wrapp', $data);
    }

    public function pelangganSave()
    {
        $id_pelanggan = $this->request->getVar('id_pelanggan');
        $nama_pelanggan = $this->request->getVar('nama_pelanggan');
        $alamat_domisili = $this->request->getVar('alamat_domisili');
        $no_telp = $this->request->getVar('no_telp');

        $data = [
            'id_pelanggan' => $id_pelanggan,
            'nama' => $nama_pelanggan,
            'alamat' => $alamat_domisili,
            'no_telp' => $no_telp,
        ];

        $this->db->table('tb_pelanggan')
        ->insert($data);

        return redirect()->to('/user/dashboard/masterdata/pelanggan');
    }

    public function pelangganEdit()
    {
        $id_pelanggan = $this->request->getVar('id_pelanggan');
        $nama_pelanggan = $this->request->getVar('nama_pelanggan');
        $alamat_domisili = $this->request->getVar('alamat_domisili');
        $no_telp = $this->request->getVar('no_telp');

        $data = [
            'nama' => $nama_pelanggan,
            'alamat' => $alamat_domisili,
            'no_telp' => $no_telp,
        ];

        $this->db->table('tb_pelanggan')
        ->where('id_pelanggan', $id_pelanggan)
        ->update($data);

        return redirect()->to('/user/dashboard/masterdata/pelanggan');
    }

    /** kategori */
    public function kategori()
    {
        $model = new DataKelolaAdminModel;
        $currentPage = $this->request->getVar('page_produk') ? $this->request->getVar('page_produk') : 1;
        $kategori = $this->db->table('tb_kategori')->get()->getResult();
        $data = [
            'model' => $model,
            'dataTransaksi' => $model->get(),
            'all_data' => $model->getDataTransaksi(),
            'totalPembelian' => $model->getTotalPembelian(),
            'namaAdmin' => $model->getNamaAdmin(),
            'tanggalPembelian' => $model->getTanggalPembelian(),
            'totalHistoryPembayaran' => $model->getTotalHistoryPembayaran(),
            'title' => 'Home',
            'tampil' => 'masterdata/kategori/index',
            'pager' => $model->pager,
            'currentPage' => $currentPage,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'kategori' => $kategori
        ];
        return view('wrapp', $data);
    }

    public function kategoriSave()
    {
        $keterangan = $this->request->getVar('keterangan');
        $data = [
            'keterangan' => $keterangan
        ];
        $this->db->table('tb_kategori')
        ->insert($data);

        return redirect()->to('/user/dashboard/masterdata/kategori');
    }

    public function kategoriEdit()
    {
        $id = $this->request->getVar('id');
        $keterangan = $this->request->getVar('keterangan');

        $data = [
            'keterangan' => $keterangan
        ];

        $this->db->table('tb_kategori')
        ->where('id', $id)
        ->update($data);

        return redirect()->to('/user/dashboard/masterdata/kategori');
    }
}
