<?php

namespace App\Controllers;

use App\Models\StockModel;
use App\Models\JurnalModel;
use App\Models\PembelianModel;
use App\Models\JenisBebanModel;
use App\Models\PembayaranModel;
use App\Models\UserProfileModel;
use App\Models\JenisServiceModel;
use App\Controllers\BaseController;
use App\Models\DataKelolaAdminModel;
use App\Models\JenisTransaksiLainnyaModel;
use App\Models\KodeOtomatis;

class Penggajian extends BaseController
{
    public function __construct() {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->UserProfileModel = new UserProfileModel();
        $this->PembelianModel = new PembelianModel();
        $this->DataKelolaAdminModel = new DataKelolaAdminModel();
        $this->PembayaranModel = new PembayaranModel();
        $this->StockModel = new StockModel();
        $this->JenisServiceModel = new JenisServiceModel();
        $this->JenisTransaksiLainnyaModel = new JenisTransaksiLainnyaModel();
        $this->JenisBebanModel = new JenisBebanModel();
        $this->jurnal = new JurnalModel();
    }

    public function index()
    {
        $model = new DataKelolaAdminModel;
        $kode_otomatis = new KodeOtomatis();
        $kode = $kode_otomatis->id_gaji();
        $pegawai = $this->db->query("SELECT * FROM karyawan 
        WHERE left(tanggalPembayaranGaji,7) <> LEFT(SYSDATE(), 7) OR tanggalPembayaranGaji IS NULL")->getResult();
        $data = [
            'model' => $model,
            'dataTransaksi' => $model->get(),
            'all_data' => $model->getDataTransaksi(),
            'totalPembelian' => $model->getTotalPembelian(),
            'namaAdmin' => $model->getNamaAdmin(),
            'tanggalPembelian' => $model->getTanggalPembelian(),
            'totalHistoryPembayaran' => $model->getTotalHistoryPembayaran(),
            'title' => 'Home',
            'tampil' => 'penggajian/index',
            'pager' => $model->pager,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'pegawai' => $pegawai,
            'kode' => $kode,
        ];
        return view('wrapp', $data);
    }

    public function detailPegawai()
    {
        $kode = $this->request->getVar('kode');

        $q ="SELECT
        a.id,
        a.namaKaryawan,
        a.idKaryawan,
        a.tanggalPembayaranGaji,
        b.deskripsi,
        b.gapok, 
        c.jumlah_service,
        c.tgl_transaksi,
        c.total_transaksi_per_pegawai
        FROM karyawan a 
        LEFT JOIN tb_jabatan b ON a.kode_jabatan = b.id
        LEFT JOIN
        (
            SELECT COUNT(kode_karyawan) AS jumlah_service, kode_karyawan, tgl_transaksi, SUM(subtotal) AS total_transaksi_per_pegawai
            FROM tb_transaksi_service
            WHERE LEFT(tgl_transaksi, 7) = '2022-06'
            GROUP BY kode_karyawan
        ) as c ON c.kode_karyawan = a.idKaryawan
        WHERE a.idKaryawan = '$kode'
        GROUP BY a.idKaryawan
        ";

        $data = $this->db->query($q)->getRow();
        echo json_encode($data);
    }

    public function savePenggajian()
    {
        $id_gaji = $this->request->getVar('id_gaji');
        $tgl_gaji = $this->request->getVar('tgl_gaji'); 
        $pegawai = $this->request->getVar('pegawai'); 
        $gapok = $this->request->getVar('gapok'); 
        $bonus = $this->request->getVar('bonus'); 
        $jml_service = $this->request->getVar('jml_service'); 
        $total_transaksi_service = $this->request->getVar('total_transaksi_service'); 
        $bonus_service = $this->request->getVar('bonus_service'); 
        $gaji_bersih = $this->request->getVar('gaji_bersih');

        $data = [
            'id_gaji' => $id_gaji,
            'id_pegawai' => $pegawai,
            'tgl_gaji' => $tgl_gaji,
            'periode' => date('Y-m', strtotime($tgl_gaji)),
            'total_service' => $total_transaksi_service,
            'gajipokok' => $gapok,
            'persentase_bonus' => $bonus,
            'jml_service' => $jml_service,
            'bonus_service' => $bonus_service,
            'gaji_bersih' => $gaji_bersih,
        ];
        $this->db->table("tb_penggajian")->insert($data);

        $update = [
            'tanggalPembayaranGaji' => $tgl_gaji
        ];
        $this->db->table('karyawan')
        ->where('idKaryawan', $pegawai)
        ->update($update);

        /** jurnal */
        $this->jurnal->generateJurnal($id_gaji, date('Y-m-d'), '520', 'Penggajian periode '.date('Y-m', strtotime($tgl_gaji)).' ', 'd', $gaji_bersih);
        $this->jurnal->generateJurnal($id_gaji, date('Y-m-d'), '111', 'Penggajian periode '.date('Y-m', strtotime($tgl_gaji)).' ', 'k', $gaji_bersih);

        return redirect()->to('user/dashboard/penggajian');
    }
}
