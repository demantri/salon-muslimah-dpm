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

    public function arus_kas()
    {
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $periode = $tahun.'-'.$bulan;
        if (isset($periode)) {
            # code...
            $pnd = $this->db->query("SELECT a.*, b.namaAkun, b.posisi_d_c AS saldo_normal, b.is_arus_kas, SUM(nominal) AS total
            FROM tb_jurnal a 
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE b.is_arus_kas = 1 
            AND b.namaAkun LIKE '%pendapatan jasa%'
            AND left(tgl_jurnal, 7) = '$periode'
            GROUP BY no_coa");
    
            $beban1 = $this->db->query("SELECT a.*, b.namaAkun, b.posisi_d_c AS saldo_normal, b.is_arus_kas, SUM(nominal) AS total
            FROM tb_jurnal a 
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE b.is_arus_kas = 1
            and b.namaAkun like '%beban%'
            AND left(tgl_jurnal, 7) = '$periode'
            GROUP BY no_coa");
    
            $pmb = $this->db->query("SELECT a.*, b.namaAkun, b.posisi_d_c AS saldo_normal, b.is_arus_kas, SUM(nominal) AS total
            FROM tb_jurnal a 
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE b.is_arus_kas = 2
            and b.namaAkun like '%pembelian%'
            AND left(tgl_jurnal, 7) = '$periode'
            GROUP BY no_coa");
    
            $privee = $this->db->query("SELECT a.*, b.namaAkun, b.posisi_d_c AS saldo_normal, b.is_arus_kas, SUM(nominal) AS total
            FROM tb_jurnal a 
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE b.is_arus_kas = 3
            AND left(tgl_jurnal, 7) = '$periode'
            GROUP BY no_coa");
    
            $pendapatan_jasa = $pnd->getRow()->total ?? 0;
            $beban = $beban1->getResult();
            $pembelian = $pmb->getResult();
            $prive = $privee->getResult();
    
            $data = [
                'dataStockBahan' => $this->StockModel->getDataStockBahan(),
                'title' => 'Home',
                'tampil' => 'laporan/arus_kas',
                'dataJenisService' => $this->JenisServiceModel->get(),
                'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
                'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
                'pendapatan_jasa' => $pendapatan_jasa,
                'beban' => $beban,
                'pembelian' => $pembelian,
                'prive' => $prive,
            ];
            return view('wrapp', $data);
        } else {
            $pnd = $this->db->query("SELECT a.*, b.namaAkun, b.posisi_d_c AS saldo_normal, b.is_arus_kas, SUM(nominal) AS total
            FROM tb_jurnal a 
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE b.is_arus_kas = 1 
            AND b.namaAkun LIKE '%pendapatan jasa%'
            AND left(tgl_jurnal, 7) = '$periode'
            GROUP BY no_coa");
    
            $beban1 = $this->db->query("SELECT a.*, b.namaAkun, b.posisi_d_c AS saldo_normal, b.is_arus_kas, SUM(nominal) AS total
            FROM tb_jurnal a 
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE b.is_arus_kas = 1
            and b.namaAkun like '%beban%'
            AND left(tgl_jurnal, 7) = '$periode'
            GROUP BY no_coa");
    
            $pmb = $this->db->query("SELECT a.*, b.namaAkun, b.posisi_d_c AS saldo_normal, b.is_arus_kas, SUM(nominal) AS total
            FROM tb_jurnal a 
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE b.is_arus_kas = 2
            and b.namaAkun like '%pembelian%'
            AND left(tgl_jurnal, 7) = '$periode'
            GROUP BY no_coa");
    
            $privee = $this->db->query("SELECT a.*, b.namaAkun, b.posisi_d_c AS saldo_normal, b.is_arus_kas, SUM(nominal) AS total
            FROM tb_jurnal a 
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE b.is_arus_kas = 3
            AND left(tgl_jurnal, 7) = '$periode'
            GROUP BY no_coa");
    
            $pendapatan_jasa = $pnd->getRow()->total ?? 0;
            $beban = $beban1->getResult();
            $pembelian = $pmb->getResult();
            $prive = $privee->getResult();
    
            $data = [
                'dataStockBahan' => $this->StockModel->getDataStockBahan(),
                'title' => 'Home',
                'tampil' => 'laporan/arus_kas',
                'dataJenisService' => $this->JenisServiceModel->get(),
                'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
                'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
                'pendapatan_jasa' => $pendapatan_jasa,
                'beban' => $beban,
                'pembelian' => $pembelian,
                'prive' => $prive,
            ];
            return view('wrapp', $data);
        }
    }

    public function laporan_stok()
    {
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $periode = $tahun.'-'.$bulan;

        if (isset($periode)) {
            $stok = $this->db->query("SELECT a.*, b.namaKaryawan, c.nama_product, c.stok_akhir
            FROM tb_stok a
            JOIN karyawan b ON a.id_karyawan = b.idKaryawan
            JOIN tb_product c ON a.id_bahan = c.id_product
            WHERE left(date_create, 7) = '$periode'
            ")->getResult();
            $data = [
                'dataStockBahan' => $this->StockModel->getDataStockBahan(),
                'title' => 'Home',
                'tampil' => 'laporan/stok',
                'dataJenisService' => $this->JenisServiceModel->get(),
                'dataJenisTransaksiLainnya' => $this->JenisTransaksiLainnyaModel->get(),
                'dataJenisBeban' => $this->JenisBebanModel->getDataJenisBeban(),
                'stok' => $stok
            ];
            return view('wrapp', $data);
        }
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
        $akun = $this->db->query("SELECT * FROM akun order by kodeAkun asc")->getResult();

        $periode = $tahun.'-'.$bulan;
        $no_coa = $this->request->getVar('coa');
        if (isset($periode, $no_coa)) {
            # code...
            $cek = date('m-Y', strtotime("-1 months", strtotime($periode)));
            $bulan1 = substr($cek, 0, 2);
            $tahun1 = substr($cek, 3, 7);
            $query = $this->db->query("SELECT 
            SUM(nominal) AS debit, 
            (
                SELECT sum(nominal) 
                FROM tb_jurnal 
                WHERE no_coa = '$no_coa' 
                AND MONTH(tgl_jurnal) <= '$bulan1' 
                AND YEAR(tgl_jurnal) <= '$tahun1' 
                and posisi_d_c = 'k' 
            ) AS kredit
            FROM tb_jurnal
            WHERE no_coa = '$no_coa'
            AND MONTH(tgl_jurnal) <= '$bulan1'
            AND YEAR(tgl_jurnal) <= '$tahun1'
            AND posisi_d_c = 'd'");
            
            $debit = $query->getRow()->debit;
            $kredit = $query->getRow()->kredit;
            $pengurangan = $debit - $kredit;
    
            /** cek saldo awal berdasarkan no coa */
            $saldoByCoa = $this->db->query("SELECT * FROM akun WHERE kodeAkun = '$no_coa'")->getRow()->saldo_awal;
            $saldo_awal = $saldoByCoa + $pengurangan;
    
            $query2 = $this->db->query("SELECT 
            a.*, b.namaAkun, b.saldo_awal, b.header
            FROM tb_jurnal a
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE b.kodeAkun = '$no_coa' 
            AND LEFT(a.tgl_jurnal, 7) = '$periode'
            ORDER BY tgl_jurnal ASC");
    
            $listBB = $query2->getResult();
            $getSaldo = $query2->getRow()->saldo_awal ?? 0 ;
    
            $data = [
                'per' => $periode,
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
        } else {
            $cek = date('m-Y', strtotime("-1 months", strtotime($periode)));
            $bulan1 = substr($cek, 0, 2);
            $tahun1 = substr($cek, 3, 7);
            $query = $this->db->query("SELECT 
            SUM(nominal) AS debit, 
            (
                SELECT sum(nominal) 
                FROM tb_jurnal 
                WHERE no_coa = '$no_coa' 
                AND MONTH(tgl_jurnal) <= '$bulan1' 
                AND YEAR(tgl_jurnal) <= '$tahun1' 
                and posisi_d_c = 'k' 
            ) AS kredit
            FROM tb_jurnal
            WHERE no_coa = '$no_coa'
            AND MONTH(tgl_jurnal) <= '$bulan1'
            AND YEAR(tgl_jurnal) <= '$tahun1'
            AND posisi_d_c = 'd'");
            
            $debit = $query->getRow()->debit;
            $kredit = $query->getRow()->kredit;
            $pengurangan = $debit - $kredit;
    
            /** cek saldo awal berdasarkan no coa */
            $saldoByCoa = $this->db->query("SELECT * FROM akun WHERE kodeAkun = '$no_coa'")->getRow()->saldo_awal ?? 0;
            // print_r($saldoByCoa);exit;
            $saldo_awal = $saldoByCoa + $pengurangan;
    
            $query2 = $this->db->query("SELECT 
            a.*, b.namaAkun, b.saldo_awal, b.header
            FROM tb_jurnal a
            JOIN akun b ON a.no_coa = b.kodeAkun
            WHERE b.kodeAkun = '$no_coa' 
            AND LEFT(a.tgl_jurnal, 7) = '$periode'
            ORDER BY tgl_jurnal ASC");
            // print_r($query2);exit;
    
            $listBB = $query2->getResult();
            $getSaldo = $query2->getRow()->saldo_awal ?? 0 ;

            $data = [
                'per' => '',
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
