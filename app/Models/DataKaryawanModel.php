<?php

namespace App\Models;

use CodeIgniter\Model;

class DataKaryawanModel extends Model
{
    protected $table = 'karyawan';
    protected $allowedFields = ['namaKaryawan', 'role', 'noTelepon', 'tanggalBergabung', 'idKaryawan', 'serviceDikerjakan', 'bayaranPerProduk', 'tanggalPembayaranGaji', 'alamat'];
    protected $db;
    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getDataKaryawan()
    {
        $builder = $this->db->table('karyawan');
        $builder->select('*');
        $builder->selectSum('hadir');
        $builder->selectSum('absen');
        $builder->selectSum('izin');
        $builder->join('absenKaryawan', 'absenKaryawan.idKaryawan = karyawan.idKaryawan', 'left');
        $builder->groupBy('karyawan.idKaryawan');
        $query = $builder->get();
        return $query;
    }
    public function getTotalGajiKaryawan()
    {
        $builder = $this->db->table('gajikaryawan');
        $builder->select('*');
        $builder->selectSum('totalPembayaran');
        $query = $builder->get();
        return $query;
    }
    public function getDataKaryawanAbsen()
    {
        date_default_timezone_set('Asia/Jakarta');
        $builder = $this->db->table('karyawan');
        $builder->select('*');
        // $builder->selectSum('hadir');
        // $builder->selectSum('absen');
        // $builder->selectSum('izin');
        // $builder->join('waktuabsensi', 'waktuabsensi.idKaryawan = karyawan.idKaryawan', 'left');
        // $builder->groupBy('karyawan.idKaryawan');
        // $builder->orderBy('waktuabsensi.idKaryawan', 'ASC');
        // $builder->where('tanggalAbsen', date('Y-m-d'));

        $query = $builder->get();
        return $query;
    }
    public function getDataAbsen()
    {
        $builder = $this->db->table('waktuabsensi');
        $builder->select('*');
        $builder->groupBy('idKaryawan');
        $builder->orderBy('idKaryawan', 'DESC');
        $query = $builder->get();
        return $query;
    }
    public function getHistoryAbsen()
    {
        $builder = $this->db->table('karyawan');
        $builder->select('*');
        // $builder->join('absenKaryawan', 'absenKaryawan.idKaryawan = karyawan.idKaryawan', 'left');
        $builder->join('waktuabsensi', 'waktuabsensi.idKaryawan = karyawan.idKaryawan', 'left');
        $builder->notLike('waktuAbsen', 'null');
        $builder->notLike('tanggalAbsen', 'null');
        $query = $builder->get();
        return $query;
    }

    public function getFilterByDate($historyDate)
    {
        $builder = $this->db->table('karyawan');
        $builder->select('*');
        $builder->join('waktuabsensi', 'waktuabsensi.idKaryawan = karyawan.idKaryawan', 'left');
        $builder->notLike('waktuAbsen', 'null');
        $builder->notLike('tanggalAbsen', 'null');
        $builder->where('tanggalAbsen', $historyDate);
        $query = $builder->get();
        return $query;
    }

    // public function save_batch($data)
    // {
    //     $builder = $this->db->table('datatransaksi');
    //     $builder->insertBatch($data);
    // }
}
