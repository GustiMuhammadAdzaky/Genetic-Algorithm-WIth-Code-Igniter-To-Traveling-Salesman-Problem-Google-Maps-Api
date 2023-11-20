<?php

namespace App\Models;

use CodeIgniter\Model;

class TitikModel extends Model
{
    protected $table = 'tb_titik';
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $allowedFields = ["kode_titik", "nama_titik", "kode_kelompok", "lat", "lng"];


    public function kodeOto()
    {
        $field = "kode_titik";
        $prefix = "T";
        $length = 3;
        $var = $this->db->query("SELECT $field FROM $this->table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");


        if ($var->getResult() == null) {
            $res = 'T000';
        } else {
            $res = $var->getResult()[0]->$field;
        }

        if ($res) {
            return $prefix . substr(str_repeat('0', $length) . (substr($res, -$length) + 1), -$length);
        } else {
            return $prefix . str_repeat('0', $length - 1) . 1;
        }
    }


    public function saveBobot($kode)
    {
        // tambah data tb_bobot id1 = kode_titik, id2 = $kode(inputan), bobot = 0 daro tb_titik
        $this->db->query("INSERT INTO tb_bobot(ID1, ID2, bobot) SELECT kode_titik, '$kode', 0  FROM tb_titik");
        // tambah data tb_bobot id1 = $kode(inputan), id2 = kode_titik, bobot = 0 dari tb_titik jika kode_titik tidak ada $kode
        // query banyak data tangpa ada kode_titik yang sama
        $this->db->query("INSERT INTO tb_bobot(ID1, ID2, bobot) SELECT '$kode', kode_titik, 0  FROM tb_titik WHERE kode_titik<>'$kode'");
        // insert ke1
        // $kode = t001, kode_titik = t001(false)
        // insert ke2
        // $kode = t002, kode_titik = t001(true), kode_titik = t001(false)
    }


    public function hapusBobot($id)
    {
        // dd($id);
        $idData = $id["id"];
        $this->db->query("DELETE FROM tb_titik WHERE kode_titik='$idData'");
        $this->db->query("DELETE FROM tb_bobot WHERE ID1='$idData' OR ID2='$idData'");
    }
}
