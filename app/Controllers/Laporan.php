<?php

namespace App\Controllers;

use App\Models\PembelianModel;
use App\Models\AsetModel;
use App\Models\AkunModel;
use App\Models\StockModel;
use App\Models\PengambilanStockModel;
use App\Models\BebanModel;
use App\Models\BahanModel;
use App\Models\TransaksiLainnyaModel;
use App\Models\DataKelolaAsetModel;
use App\Models\DataKelolaBebanModel;
use App\Models\DataKelolaBahanModel;
use App\Models\DataKelolaAdminModel;
use App\Models\DataKelolaTransaksiLainnyaModel;
use App\Models\PembayaranAsetModel;
use App\Models\PembayaranBebanModel;
use App\Models\PembayaranBahanModel;
use App\Models\PembayaranModel;
use App\Models\PembayaranTransaksiLainnyaModel;
use App\Models\UserProfileModel;
use App\Models\DataKelolaServiceModel;
use App\Models\PemesananModel;
use App\Models\PembayaranServiceModel;
use App\Models\DataKaryawanModel;
use App\Models\DataAbsenKaryawanModel;
use App\Models\WaktuAbsensiKaryawanModel;
use App\Models\GajiKaryawanModel;
use App\Models\JenisServiceModel;
use App\Models\JenisTransaksiLainnyaModel;
use App\Models\JenisBebanModel;
use App\Models\UpahGajiModel;


class Laporan extends BaseController
{
    protected $StockModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();;
        $this->UserProfileModel = new UserProfileModel();
        $this->PembelianModel = new PembelianModel();
        $this->AsetModel = new AsetModel();
        $this->AkunModel = new AkunModel();
        $this->StockModel = new StockModel();
        $this->PengambilanStockModel = new PengambilanStockModel();
        $this->BebanModel = new BebanModel();
        $this->BahanModel = new BahanModel();
        $this->TransaksiLainnyaModel = new TransaksiLainnyaModel();
        $this->DataKelolaAsetModel = new DataKelolaAsetModel();
        $this->DataKelolaBebanModel = new DataKelolaBebanModel();
        $this->DataKelolaBahanModel = new DataKelolaBahanModel();
        $this->DataKelolaAdminModel = new DataKelolaAdminModel();
        $this->DataKelolaTransaksiLainnyaModel = new DataKelolaTransaksiLainnyaModel();
        $this->PembayaranAsetModel = new PembayaranAsetModel();
        $this->PembayaranBebanModel = new PembayaranBebanModel();
        $this->PembayaranBahanModel = new PembayaranBahanModel();
        $this->PembayaranModel = new PembayaranModel();
        $this->PembayaranTransaksiLainnyaModel = new PembayaranTransaksiLainnyaModel();
        $this->PemesananModel = new PemesananModel();
        $this->DataKelolaServiceModel = new DataKelolaServiceModel();
        $this->PembayaranServiceModel = new PembayaranServiceModel();
        $this->DataKaryawanModel = new DataKaryawanModel();
        $this->DataAbsenKaryawanModel = new DataAbsenKaryawanModel();
        $this->WaktuAbsensiKaryawanModel = new WaktuAbsensiKaryawanModel();
        $this->GajiKaryawanModel = new GajiKaryawanModel();
        $this->JenisServiceModel = new JenisServiceModel();
        $this->JenisTransaksiLainnyaModel = new JenisTransaksiLainnyaModel();
        $this->JenisBebanModel = new JenisBebanModel();
        $this->UpahGajiModel = new UpahGajiModel();
    }
    public function index()
    {
        $data = [
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'title' => 'Home',
            'tampil' => 'laporan/index',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban()
        ];
        return view('wrapp', $data);
    }
    public function jurnalUmum()
    {
        if ($this->request->getVar('bulan') == null && $this->request->getVar('tahun')) {
            $bulan = null;
            $tahun = null;
        }
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $periode = $tahun .'-'. $bulan;
        if (isset($periode)) {
            $jurnal = $this->db->query("SELECT a.*, b.namaAkun, b.header
            FROM tb_jurnal a
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE LEFT(tgl_jurnal, 7) = '$periode'
            ORDER BY id ASC")->getResult();
            $data = [
                'filterByBulan' => $bulan,
                'filterByTahun' => $tahun,
                'jurnal' => $jurnal,
                'title' => 'Home',
                'tampil' => 'laporan/jurnalUmum',
                'dataJenisService' => $this->JenisServiceModel->get(),
                'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
                'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
                'dataStockBahan' => $this->StockModel->getDataStockBahan(),
                'dataTransaksiAset' => $this->PembayaranAsetModel->get(),
                'dataTransaksiAsetByFilter' => $this->PembayaranAsetModel->getTransaksiAsetByFilter($bulan, $tahun),
                'dataKelolaAset' => $this->DataKelolaAsetModel->get(),
                'all_data_aset' => $this->DataKelolaAsetModel->getDataTransaksiAset(),
                'totalPembelianAset' => $this->DataKelolaAsetModel->getTotalPembelianAset(),
                'upahGaji' => $this->UpahGajiModel->get(),
                'upahGajiByFilter' => $this->UpahGajiModel->getTransaksiGajiByFilter($bulan, $tahun),
            ];
            return view('wrapp', $data);
        }
    }
    public function bukuBesar()
    {
        if ($this->request->getVar('bulan') == null && $this->request->getVar('tahun') && $this->request->getVar('coa')) {
            $bulan = null;
            $tahun = null;
            $coa = null;
        }
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $periode = $tahun.'-'.$bulan;

        $no_coa = $this->request->getVar('coa');
        
        $akun = $this->db->query("SELECT * FROM akun")->getResult();
        $cek = date('m-Y', strtotime("-1 months", strtotime($periode)));
        $bulan1 = substr($cek, 0, 2);
        $tahun1 = substr($cek, 3, 7);
        $query = $this->db->query("SELECT 
        SUM(nominal) AS debit, 
        (
            SELECT sum(nominal) 
            FROM tb_jurnal 
            WHERE no_coa = '111' 
            AND MONTH(tgl_jurnal) <= '06' 
            AND YEAR(tgl_jurnal) <= '2022' 
            and posisi_d_c = 'k' 
        ) AS kredit
        FROM tb_jurnal
        WHERE no_coa = '111'
        AND MONTH(tgl_jurnal) <= '06'
        AND YEAR(tgl_jurnal) <= '2022'
        AND posisi_d_c = 'd'");
        
        $debit = $query->getRow()->debit;
        $kredit = $query->getRow()->kredit;
        // print_r($kredit);exit;
        $pengurangan = $debit - $kredit;

        /** cek saldo awal berdasarkan no coa */
        $saldoByCoa = $this->db->query("SELECT * FROM akun WHERE kodeAkun = '$no_coa'")->getRow()->saldo_awal;
        $saldo_awal = $saldoByCoa + $pengurangan;
        print_r($saldoByCoa);exit;

        $query2 = $this->db->query("SELECT 
        a.*, b.namaAkun, b.saldo_awal, b.header
        FROM tb_jurnal a
        JOIN akun b ON a.no_coa = b.kodeAkun
        WHERE b.kodeAkun = '$no_coa' 
        AND LEFT(a.tgl_jurnal, 7) = '$periode'
        ORDER BY tgl_jurnal ASC");

        $listBB = $query2->result();
        $getSaldo = $query2->getRow()->saldo_awal ?? 0 ;

        $data = [
            'list' => $listBB,
            'saldo_awal' => $saldo_awal,
            'coa' => $akun,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'title' => 'Home',
            'tampil' => 'laporan/bukuBesar',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataTransaksiAset' => $this->PembayaranAsetModel->get(),
            'dataTransaksiAsetByFilter' => $this->PembayaranAsetModel->getTransaksiAsetByFilter($bulan, $tahun),
            'dataKelolaAset' => $this->DataKelolaAsetModel->get(),
            'all_data_aset' => $this->DataKelolaAsetModel->getDataTransaksiAset(),
            'totalPembelianAset' => $this->DataKelolaAsetModel->getTotalPembelianAset(),
        ];
        return view('wrapp', $data);
    }
    public function labaRugi()
    {
        if ($this->request->getVar('bulan') == null && $this->request->getVar('tahun')) {
            $bulan = null;
            $tahun = null;
        }
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $data = [
            'filterByBulan' => $bulan,
            'filterByTahun' => $tahun,
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'title' => 'Home',
            'tampil' => 'laporan/labaRugi',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataTransaksiAset' => $this->PembayaranAsetModel->get(),
            'dataTransaksiAsetByFilter' => $this->PembayaranAsetModel->getTransaksiAsetByFilter($bulan, $tahun),
            'dataKelolaAset' => $this->DataKelolaAsetModel->get(),
            'all_data_aset' => $this->DataKelolaAsetModel->getDataTransaksiAset(),
            'totalPembelianAset' => $this->DataKelolaAsetModel->getTotalPembelianAset(),
            // 'title' => 'Home',
            // 'tampil' => 'pencatatan/pengeluaran/aset/history',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataTransaksiBeban' => $this->PembayaranBebanModel->get(),
            'dataTransaksiBebanByFilter' => $this->PembayaranBebanModel->getTransaksiBebanByFilter($bulan, $tahun),
            'dataKelolaBeban' => $this->DataKelolaBebanModel->get(),
            'all_data' => $this->DataKelolaBebanModel->getDataTransaksiBeban(),
            'totalPembelianBeban' => $this->DataKelolaBebanModel->getTotalPembelianBeban(),
            // 'title' => 'Home',
            // 'tampil' => 'pencatatan/pengeluaran/beban/history',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataTransaksiBahan' => $this->PembayaranBahanModel->get(),
            'dataTransaksiBahanByFilter' => $this->PembayaranBahanModel->getTransaksiBahanByFilter($bulan, $tahun),
            'dataKelolaBahan' => $this->DataKelolaBahanModel->get(),
            'all_data_bahan' => $this->DataKelolaBahanModel->getDataTransaksiBahan(),
            'totalPembelianBahan' => $this->DataKelolaBahanModel->getTotalPembelianBahan(),
            // 'title' => 'Home',
            // 'tampil' => 'pencatatan/pengeluaran/bahan/history',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataTransaksiLainnya' => $this->PembayaranTransaksiLainnyaModel->get(),
            'dataTransaksiLainnyaByFilter' => $this->PembayaranTransaksiLainnyaModel->getTransaksiTransaksiLainnyaByFilter($bulan, $tahun),
            'dataKelolaTransaksiLainnya' => $this->DataKelolaTransaksiLainnyaModel->get(),
            'all_data_lainnya' => $this->DataKelolaTransaksiLainnyaModel->getDataTransaksiLainnya(),
            'totalPembelianTransaksiLainnya' => $this->DataKelolaTransaksiLainnyaModel->getTotalPembelianTransaksiLainnya(),
            // 'title' => 'Home',
            // 'tampil' => 'pencatatan/pengeluaran/lainnya/history',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            // 'dataTransaksiAset' => $model->get(),
            // 'all_data' => $model->getDataTransaksiAset(),
            // 'totalPembelianAset' => $model->getTotalPembelianAset(),
            'model' => $this->DataKaryawanModel,
            'dataGajiKaryawan' => $this->DataKaryawanModel->get(),
            'dataKaryawan' => $this->DataKaryawanModel->getDataKaryawan(),
            'dataKaryawanAbsen' => $this->DataKaryawanModel->getDataKaryawanAbsen(),
            'dataAbsen' => $this->DataKaryawanModel->getDataAbsen(),
            // 'title' => 'Home',
            // 'tampil' => 'pencatatan/pengeluaran/gaji/index',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'upahGaji' => $this->UpahGajiModel->get(),
            'upahGajiByFilter' => $this->UpahGajiModel->getTransaksiGajiByFilter($bulan, $tahun),
            'totalHistoryPembayaranProductByFilter' => $this->DataKelolaAdminModel->getTotalHistoryPembayaranByFilter($bulan, $tahun),
            'totalHistoryPembayaranServiceByFilter' => $this->DataKelolaServiceModel->getTotalHistoryPembayaranByFilter($bulan, $tahun)
        ];
        return view('wrapp', $data);
    }
    public function neraca()
    {
        $data = [
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'title' => 'Home',
            'tampil' => 'laporan/neraca',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataTransaksiAset' => $this->PembayaranAsetModel->get(),
            'dataKelolaAset' => $this->DataKelolaAsetModel->get(),
            'all_data_aset' => $this->DataKelolaAsetModel->getDataTransaksiAset(),
            'totalPembelianAset' => $this->DataKelolaAsetModel->getTotalPembelianAset(),
            // 'title' => 'Home',
            // 'tampil' => 'pencatatan/pengeluaran/aset/history',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataTransaksiBeban' => $this->PembayaranBebanModel->get(),
            'dataKelolaBeban' => $this->DataKelolaBebanModel->get(),
            'all_data' => $this->DataKelolaBebanModel->getDataTransaksiBeban(),
            'totalPembelianBeban' => $this->DataKelolaBebanModel->getTotalPembelianBeban(),
            // 'title' => 'Home',
            // 'tampil' => 'pencatatan/pengeluaran/beban/history',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataTransaksiBahan' => $this->PembayaranBahanModel->get(),
            'dataKelolaBahan' => $this->DataKelolaBahanModel->get(),
            'all_data_bahan' => $this->DataKelolaBahanModel->getDataTransaksiBahan(),
            'totalPembelianBahan' => $this->DataKelolaBahanModel->getTotalPembelianBahan(),
            // 'title' => 'Home',
            // 'tampil' => 'pencatatan/pengeluaran/bahan/history',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            'dataTransaksiLainnya' => $this->PembayaranTransaksiLainnyaModel->get(),
            'dataKelolaTransaksiLainnya' => $this->DataKelolaTransaksiLainnyaModel->get(),
            'all_data_lainnya' => $this->DataKelolaTransaksiLainnyaModel->getDataTransaksiLainnya(),
            'totalPembelianTransaksiLainnya' => $this->DataKelolaTransaksiLainnyaModel->getTotalPembelianTransaksiLainnya(),
            // 'title' => 'Home',
            // 'tampil' => 'pencatatan/pengeluaran/lainnya/history',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'dataStockBahan' => $this->StockModel->getDataStockBahan(),
            // 'dataTransaksiAset' => $model->get(),
            // 'all_data' => $model->getDataTransaksiAset(),
            // 'totalPembelianAset' => $model->getTotalPembelianAset(),
            'model' => $this->DataKaryawanModel,
            'dataGajiKaryawan' => $this->DataKaryawanModel->get(),
            'dataKaryawan' => $this->DataKaryawanModel->getDataKaryawan(),
            'dataKaryawanAbsen' => $this->DataKaryawanModel->getDataKaryawanAbsen(),
            'dataAbsen' => $this->DataKaryawanModel->getDataAbsen(),
            // 'title' => 'Home',
            // 'tampil' => 'pencatatan/pengeluaran/gaji/index',
            'dataJenisService' => $this->JenisServiceModel->get(),
            'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
            'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
            'upahGaji' => $this->UpahGajiModel->get(),
            'totalHistoryPembayaranProduct' => $this->DataKelolaAdminModel->getTotalHistoryPembayaran(),
            'totalHistoryPembayaranService' => $this->DataKelolaServiceModel->getTotalHistoryPembayaran(),
        ];
        return view('wrapp', $data);
    }
}
