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
use App\Models\KodeOtomatis;

class Transaksi extends BaseController
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

    public function penjualan()
    {
        $model = new DataKelolaAdminModel;
        $pnj = $this->db->query("select * from tb_transaksi where jenis = 'penjualan'")->getResult();
        $data = [
            'model' => $model,
            'dataTransaksi' => $model->get(),
            'all_data' => $model->getDataTransaksi(),
            'totalPembelian' => $model->getTotalPembelian(),
            'namaAdmin' => $model->getNamaAdmin(),
            'tanggalPembelian' => $model->getTanggalPembelian(),
            'totalHistoryPembayaran' => $model->getTotalHistoryPembayaran(),
            'title' => 'Home',
            'tampil' => 'transaksi/penjualan/index',
            'pager' => $model->pager,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'pnj' => $pnj
        ];
        return view('wrapp', $data);
    }

    public function form_penjualan()
    {
        $model = new DataKelolaAdminModel;

        $kodeOtomatis = new KodeOtomatis();
        $kode = $kodeOtomatis->id_penjualan();

        // $product = $this->db->query("select * from tb_product where status = 1 and stok_akhir > 5")->getResult();
        $product = $this->db->query("SELECT a.*, b.keterangan 
        FROM tb_product a 
        JOIN tb_kategori b ON a.id_kategori = b.id
        WHERE keterangan != 'operasional' 
        AND status = 1")->getResult();
        
        $detail_penjualan = $this->db->query("SELECT a.* , b.nama_product
        FROM tb_detail_transaksi a 
        LEFT JOIN tb_product b ON a.id_product = b.id_product
        where id_transaksi = '$kode'
        ORDER BY a.id ASC")->getResult();
        $pelanggan = $this->db->query("select * from tb_pelanggan")->getResult();
        
        $data = [
            'model' => $model,
            'dataTransaksi' => $model->get(),
            'all_data' => $model->getDataTransaksi(),
            'totalPembelian' => $model->getTotalPembelian(),
            'namaAdmin' => $model->getNamaAdmin(),
            'tanggalPembelian' => $model->getTanggalPembelian(),
            'totalHistoryPembayaran' => $model->getTotalHistoryPembayaran(),
            'title' => 'Home',
            'tampil' => 'transaksi/penjualan/add',
            'pager' => $model->pager,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'product' => $product,
            'detail_penjualan' => $detail_penjualan,
            'pelanggan' => $pelanggan,
            'kode' => $kode
        ];
        return view('wrapp', $data);   
    }

    public function detail_penjualan()
    {
        $id_transaksi = $this->request->getVar('id_transaksi');
        $tgl_transaksi = $this->request->getVar('tgl_transaksi');
        $product = $this->request->getVar('product');
        $harga_satuan = $this->request->getVar('harga_satuan');
        $qty = $this->request->getVar('qty');
        $subtotal = $harga_satuan * $qty;

        
        $cekTrans = $this->db->query("select * from tb_transaksi where id_transaksi = '$id_transaksi' and status = 'ongoing' and jenis = 'penjualan'")->getNumRows();
        $cekProduct = $this->db->query("select * from tb_detail_transaksi where id_transaksi = '$id_transaksi' and id_product = '$product'")->getRow();
        // print_r(count($cekTransDetail));exit;
        
        if ($cekTrans == 0) {
            /** insert tb_transaksi */
            $data = [
                'id_transaksi' => $id_transaksi,
                'tgl_transaksi' => $tgl_transaksi,
                'jenis' => 'Penjualan',
                'status' => 'ongoing',
            ];
            $this->db->table('tb_transaksi')
            ->insert($data);

            $detail = [
                'id_transaksi' => $id_transaksi,
                'id_product' => $product,
                'qty' => $qty,
                'harga_satuan' => $harga_satuan,
                'subtotal' => $subtotal,
            ];
            $this->db->table('tb_detail_transaksi')
            ->insert($detail);
        } else {
            if (empty($cekProduct->id_product)) {
                $detail = [
                    'id_transaksi' => $id_transaksi,
                    'id_product' => $product,
                    'qty' => $qty,
                    'harga_satuan' => $harga_satuan,
                    'subtotal' => $subtotal,
                ];
                $this->db->table('tb_detail_transaksi')
                ->insert($detail);
            } else {
                $data = [
                    'qty' => $qty + $cekProduct->qty
                ];

                $this->db->table('tb_detail_transaksi')
                ->where('id_transaksi', $id_transaksi)
                ->where('id_product', $product)
                ->update($data);
            }
        }

        return redirect()->to('Transaksi/form_penjualan');
    }

    public function savePenjualan()
    {
        $id_transaksi = $this->request->getVar('id_transaksi_bayar');
        $nama_pelanggan = $this->request->getVar('nama_pelanggan');
        $jenis_pembayaran = $this->request->getVar('jenis_pembayaran');
        $grandtotal = $this->request->getVar('grandtotal');
        $jumlah_bayar = $this->request->getVar('jumlah_bayar');
        $kembalian = $this->request->getVar('kembalian');

        $data = [
            'status' => 'selesai',
            'subtotal' => $grandtotal,
            'kembalian' => $kembalian,
            'jumlah_bayar' => $jumlah_bayar,
            'nama_pelanggan' => $nama_pelanggan,
            'jenis_pembayaran' => $jenis_pembayaran
        ];

        $this->db->table('tb_transaksi')
        ->where('id_transaksi', $id_transaksi)
        ->update($data);

        return redirect()->to('Transaksi/penjualan');
    }

    /** pembelian */
    public function pembelian()
    {
        $model = new DataKelolaAdminModel;
        $pmb = $this->db->query("select * from tb_transaksi where jenis = 'pembelian'")->getResult();
        $data = [
            'model' => $model,
            'dataTransaksi' => $model->get(),
            'all_data' => $model->getDataTransaksi(),
            'totalPembelian' => $model->getTotalPembelian(),
            'namaAdmin' => $model->getNamaAdmin(),
            'tanggalPembelian' => $model->getTanggalPembelian(),
            'totalHistoryPembayaran' => $model->getTotalHistoryPembayaran(),
            'title' => 'Home',
            'tampil' => 'transaksi/pembelian/index',
            'pager' => $model->pager,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'pmb' => $pmb
        ];
        return view('wrapp', $data);
    }

    public function form_pembelian()
    {
        $model = new DataKelolaAdminModel;

        $kodeOtomatis = new KodeOtomatis();
        $kode = $kodeOtomatis->id_pembelian();

        // $product = $this->db->query("select * from tb_product where status = 1 and stok_akhir > 5")->getResult();
        $product = $this->db->query("SELECT a.*, b.keterangan 
        FROM tb_product a 
        JOIN tb_kategori b ON a.id_kategori = b.id
        WHERE keterangan = 'operasional' 
        AND status = 1")->getResult();
        
        $detail_penjualan = $this->db->query("SELECT a.* , b.nama_product
        FROM tb_detail_transaksi a 
        LEFT JOIN tb_product b ON a.id_product = b.id_product
        where id_transaksi = '$kode'
        ORDER BY a.id ASC")->getResult();
        $pelanggan = $this->db->query("select * from tb_pelanggan")->getResult();
        
        $data = [
            'model' => $model,
            'dataTransaksi' => $model->get(),
            'all_data' => $model->getDataTransaksi(),
            'totalPembelian' => $model->getTotalPembelian(),
            'namaAdmin' => $model->getNamaAdmin(),
            'tanggalPembelian' => $model->getTanggalPembelian(),
            'totalHistoryPembayaran' => $model->getTotalHistoryPembayaran(),
            'title' => 'Home',
            'tampil' => 'transaksi/pembelian/add',
            'pager' => $model->pager,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'product' => $product,
            'detail_penjualan' => $detail_penjualan,
            'pelanggan' => $pelanggan,
            'kode' => $kode
        ];
        return view('wrapp', $data);   
    }

    public function detail_pembelian()
    {
        $id_transaksi = $this->request->getVar('id_transaksi');
        $tgl_transaksi = $this->request->getVar('tgl_transaksi');
        $product = $this->request->getVar('product');
        $harga_satuan = $this->request->getVar('harga_satuan');
        $qty = $this->request->getVar('qty');
        $subtotal = $harga_satuan * $qty;

        
        $cekTrans = $this->db->query("select * from tb_transaksi where id_transaksi = '$id_transaksi' and status = 'ongoing' and jenis = 'pembelian'")->getNumRows();
        $cekProduct = $this->db->query("select * from tb_detail_transaksi where id_transaksi = '$id_transaksi' and id_product = '$product'")->getRow();
        // print_r(count($cekTransDetail));exit;
        
        if ($cekTrans == 0) {
            /** insert tb_transaksi */
            $data = [
                'id_transaksi' => $id_transaksi,
                'tgl_transaksi' => $tgl_transaksi,
                'jenis' => 'Pembelian',
                'status' => 'ongoing',
            ];
            $this->db->table('tb_transaksi')
            ->insert($data);

            $detail = [
                'id_transaksi' => $id_transaksi,
                'id_product' => $product,
                'qty' => $qty,
                'harga_satuan' => $harga_satuan,
                'subtotal' => $subtotal,
            ];
            $this->db->table('tb_detail_transaksi')
            ->insert($detail);
        } else {
            if (empty($cekProduct->id_product)) {
                $detail = [
                    'id_transaksi' => $id_transaksi,
                    'id_product' => $product,
                    'qty' => $qty,
                    'harga_satuan' => $harga_satuan,
                    'subtotal' => $subtotal,
                ];
                $this->db->table('tb_detail_transaksi')
                ->insert($detail);
            } else {
                $data = [
                    'qty' => $qty + $cekProduct->qty
                ];

                $this->db->table('tb_detail_transaksi')
                ->where('id_transaksi', $id_transaksi)
                ->where('id_product', $product)
                ->update($data);
            }
        }

        return redirect()->to('Transaksi/form_pembelian');
    }

    public function savePembelian()
    {
        $id_transaksi = $this->request->getVar('id_transaksi_bayar');
        $supplier = $this->request->getVar('supplier');
        $jenis_pembayaran = $this->request->getVar('jenis_pembayaran');
        $grandtotal = $this->request->getVar('grandtotal');
        $jumlah_bayar = $this->request->getVar('jumlah_bayar');
        $kembalian = $this->request->getVar('kembalian');

        $data = [
            'status' => 'selesai',
            'subtotal' => $grandtotal,
            'kembalian' => $kembalian,
            'jumlah_bayar' => $jumlah_bayar,
            'jenis_pembayaran' => $jenis_pembayaran,
            'supplier' => $supplier,
        ];

        $this->db->table('tb_transaksi')
        ->where('id_transaksi', $id_transaksi)
        ->update($data);

        return redirect()->to('Transaksi/pembelian');
    }

    public function list_product()
    {
        $id_product = $this->request->getVar('id_product');
        $data = $this->db->query("select * from tb_product where id_product = '$id_product'")->getRow();
        echo json_encode($data);
    }

    public function service()
    {
        $model = new DataKelolaAdminModel;
        $tb_serivce = $this->db->query("SELECT a.*, b.status
        FROM tb_transaksi_service a
        JOIN tb_bayar b ON a.id_transaksi = b.id_transaksi
        WHERE jenis = 'service'")->getResult();
        $jenis_service = $this->db->query("select * from jenisservice")->getResult();
        $kodeOtomatis = new KodeOtomatis();
        // $kode_bayar = $kodeOtomatis->id_bayar();
        $kode_bayar = $kodeOtomatis->generateRandomString();
        $data = [
            'model' => $model,
            'dataTransaksi' => $model->get(),
            'all_data' => $model->getDataTransaksi(),
            'totalPembelian' => $model->getTotalPembelian(),
            'namaAdmin' => $model->getNamaAdmin(),
            'tanggalPembelian' => $model->getTanggalPembelian(),
            'totalHistoryPembayaran' => $model->getTotalHistoryPembayaran(),
            'title' => 'Home',
            'tampil' => 'transaksi/service/index',
            'pager' => $model->pager,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'tb_serivce' => $tb_serivce,
            'jenis_service' => $jenis_service,
            'kode_bayar' => $kode_bayar
        ];
        return view('wrapp', $data);
    }

    public function form_service()
    {
        $model = new DataKelolaAdminModel;

        $kodeOtomatis = new KodeOtomatis();
        $kode = $kodeOtomatis->id_service();
        $pelanggan = $this->db->query("select * from tb_pelanggan")->getResult();

        $jenis_service = $this->db->query("select * from jenisservice")->getResult();
        $karyawan = $this->db->query("select * from karyawan")->getResult();
        
        $data = [
            'model' => $model,
            'dataTransaksi' => $model->get(),
            'all_data' => $model->getDataTransaksi(),
            'totalPembelian' => $model->getTotalPembelian(),
            'namaAdmin' => $model->getNamaAdmin(),
            'tanggalPembelian' => $model->getTanggalPembelian(),
            'totalHistoryPembayaran' => $model->getTotalHistoryPembayaran(),
            'title' => 'Home',
            'tampil' => 'transaksi/service/add',
            'pager' => $model->pager,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'pelanggan' => $pelanggan,
            'kode' => $kode,
            'jenis_service' => $jenis_service,
            'karyawan' => $karyawan,
        ];
        return view('wrapp', $data);   
    }

    public function saveService()
    {
        $id_transaksi = $this->request->getVar('id_transaksi');
        $tgl_transaksi = $this->request->getVar('tgl_transaksi');
        $pelanggan = $this->request->getVar('pelanggan');
        $jenis_pesan = $this->request->getVar('jenis_pesan');
        $jenis_pelayanan = $this->request->getVar('jenis_pelayanan');
        $karyawan = $this->request->getVar('karyawan');
        $service = $this->request->getVar('service');
        $harga = $this->request->getVar('harga');
        $diskon = $this->request->getVar('diskon');
        $subtotal = $this->request->getVar('subtotal');

        $data = [
            'id_transaksi' => $id_transaksi,
            'tgl_transaksi' => $tgl_transaksi,
            'jenis' => 'Service',
            'status' => 'selesai',
            'diskon' => $diskon,
            'subtotal' => $subtotal,
            'nama_pelanggan' => $pelanggan,
            'jenis_pembayaran' => 'Tunai',
            'jenis_pesan' => $jenis_pesan,
            'jenis_pelayanan' => $jenis_pelayanan,
            'kode_karyawan' => $karyawan,
        ];
        $this->db->table('tb_transaksi_service')
        ->insert($data);

        foreach ($service as $key => $value) {
            $data = [
                'id_transaksi' => $id_transaksi,
                'id_service' => $service[$key],
                'harga' => $harga[$key]
            ];
            $this->db->table('tb_detail_service')
            ->insert($data);
        }

        $tb_bayar = [
            'id_transaksi' => $id_transaksi,
            'total_transaksi' => $subtotal
        ];
        $this->db->table('tb_bayar')->insert($tb_bayar);

        return redirect()->to('user/transaksi/service');
    }

    public function bayarService()
    {
        $id_bayar = $this->request->getVar('id_bayar');
        $id_transaksi = $this->request->getVar('id_transaksi');
        $jenis_pembayaran = $this->request->getVar('jenis_pembayaran');
        $jumlah_bayar = $this->request->getVar('jumlah_bayar');
        $total_transaksi = $this->request->getVar('total_transaksi');
        $kembalian = $this->request->getVar('kembalian');

        $data = [
            'id_bayar' => $id_bayar,
            'status' => 'sudah bayar',
            'total_bayar' => $total_transaksi,
            'kembalian' => $kembalian,
        ];
        $this->db->table('tb_bayar')
        ->where('id_transaksi', $id_transaksi)
        ->update($data);

        return redirect()->to('user/transaksi/service');
    }

    public function list_harga_service()
    {
        $id = $this->request->getVar('id');
        $data = $this->db->query("select * from jenisService where id = '$id'")->getRow();
        echo json_encode($data);
    }
}
