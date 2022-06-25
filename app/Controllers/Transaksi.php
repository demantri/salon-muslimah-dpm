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

        $product = $this->db->query("select * from tb_product where status = 1 and stok_akhir > 5")->getResult();
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

    private function id_penjualan()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_transaksi,3)) as kode FROM tb_transaksi WHERE status = 'selesai' and jenis = 'Penjualan'");
        $kode = "";
        if ($q->getNumRows() > 0) {
            foreach ($q->getResult() as $k) {
                $tmp = ((int) $k->kode) + 1;
                $kd  = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
		$date = date('Ymd');
        $kode   = "PNJ".$date.$kd;
        return $kode;
    }

    public function detail_penjualan()
    {
        $id_transaksi = $this->request->getVar('id_transaksi');
        $tgl_transaksi = $this->request->getVar('tgl_transaksi');
        $product = $this->request->getVar('product');
        $harga_satuan = $this->request->getVar('harga_satuan');
        $qty = $this->request->getVar('qty');
        $subtotal = $harga_satuan * $qty;

        
        $cekTrans = $this->db->query("select * from tb_transaksi where id_transaksi = '$id_transaksi' and status = 'ongoing'")->getNumRows();
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

    public function list_product()
    {
        $id_product = $this->request->getVar('id_product');
        $data = $this->db->query("select * from tb_product where id_product = '$id_product'")->getRow();
        echo json_encode($data);
    }
}
