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
}
