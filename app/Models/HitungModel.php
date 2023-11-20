<?php

namespace App\Models;

use CodeIgniter\Model;

class HitungModel extends Model
{
    protected $table = 'tb_bobot';
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $allowedFields = ["id1","id2"];

    public function getKelompok()
    {
        $query   = $this->db->query('SELECT * FROM tb_kelompok');
        $results = $query->getResult();
        return $results;
    }

    public function getTitikOption($kode_kelompok)
    {
        // dd($kode_kelompok);
        $query = "SELECT kode_titik, nama_titik, lat, lng FROM tb_titik WHERE kode_kelompok='$kode_kelompok' ORDER BY kode_titik";
        $result   = $this->db->query($query);
        $results = $result->getResult();
        // dd($results);
        return $results;
    }

    public function getRow($kode_kelompok, $titik_tujuan)
    {
        $query = "SELECT * 
        FROM tb_bobot 
        WHERE 
            ID1 IN(SELECT kode_titik FROM tb_titik WHERE kode_kelompok='$kode_kelompok') AND
            ID2 IN(SELECT kode_titik FROM tb_titik WHERE kode_kelompok='$kode_kelompok') AND
            ID1 IN ('".implode("','", $titik_tujuan)."') AND
            ID2 IN ('".implode("','", $titik_tujuan)."')
        ORDER BY ID1, ID2";
        $result = $this->db->query($query);
        $results = $result->getResult();
        return $results;
    }

    public function getTitik()
    {
        $result = $this->db->query("SELECT kode_titik, nama_titik, lat, lng FROM tb_titik ORDER BY kode_titik");
        $rows = $result->getResult();

        $TITIK = array();
        // $POINTS = array();
        foreach($rows as $row){
            $TITIK[$row->kode_titik] = $row->nama_titik;
            // $POINTS[$row->kode_titik] = $row;
        }
        return $TITIK;
    }
    public function getPoint()
    {
        $result = $this->db->query("SELECT kode_titik, nama_titik, lat, lng FROM tb_titik ORDER BY kode_titik");
        $rows = $result->getResult();

        // $TITIK = array();
        $POINTS = array();
        foreach($rows as $row){
            // $TITIK[$row->kode_titik] = $row->nama_titik;
            $POINTS[$row->kode_titik] = $row;
        }
        return $POINTS;
    }

    public function get_graph($data = array())
    {
        $graph = array();
        foreach($data as $key => $val)
        {
            $graph[$key] = array_values($val);
        }
        
        return array_values($graph);
    }
}