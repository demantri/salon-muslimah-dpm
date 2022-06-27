<?php

namespace App\Models;

use CodeIgniter\Model;

class KodeOtomatis extends Model
{
    public function __construct()
    {
        $this->db = db_connect();
    }

    public function id_penjualan()
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

    public function id_service()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_transaksi,3)) as kode FROM tb_transaksi_service WHERE status = 'selesai' and jenis = 'Service'");
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
        $kode   = "SN".$date.$kd;
        return $kode;
    }

    public function id_bayar()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_bayar,3)) as kode FROM tb_bayar WHERE status = 'belum bayar'");
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
        $kode   = "TRXBYR".$date.$kd;
        return $kode;
    }

    public function id_pembelian()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_transaksi,3)) as kode FROM tb_transaksi WHERE status = 'selesai' and jenis = 'Pembelian'");
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
        $kode   = "PMB".$date.$kd;
        return $kode;
    }

    /** coba id */
    public function id_aset()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_aset,3)) as kode FROM tb_aset");
        $kode = "";
        if ($q->getNumRows() > 0) {
            foreach ($q->getResult() as $k) {
                $tmp = ((int) $k->kode) + 1;
                $kd  = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        $kode   = "A".$kd;
        return $kode;
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
