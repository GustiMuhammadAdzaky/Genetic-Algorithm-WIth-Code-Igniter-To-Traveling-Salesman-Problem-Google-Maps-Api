<?php

namespace App\Models;

use CodeIgniter\Model;

class BobotModel extends Model
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
        $query = "SELECT kode_titik, nama_titik, lat, lng FROM tb_titik WHERE kode_kelompok='$kode_kelompok' ORDER BY kode_titik";
        $result   = $this->db->query($query);
        $results = $result->getResult();
        // dd($results);
        return $results;
    }

    public function getRow($kode_kelompok)
    {
        $query = "SELECT * 
        FROM tb_bobot 
        WHERE 
            ID1 IN(SELECT kode_titik FROM tb_titik WHERE kode_kelompok='$kode_kelompok') AND
            ID2 IN(SELECT kode_titik FROM tb_titik WHERE kode_kelompok='$kode_kelompok') 
        ORDER BY ID1, ID2";
        $result = $this->db->query($query);
        $results = $result->getResult();
        return $results;
    }

    public function getTitik()
    {
        $result = $this->db->query("SELECT kode_titik, nama_titik, lat, lng FROM tb_titik ORDER BY kode_titik");
        return $result->getResult();
    }

    public function saveBobot($bobot)
    {
        foreach($bobot as $key => $val){
            foreach($val as $k => $v){
                $this->db->query("UPDATE tb_bobot SET bobot='$v' WHERE (ID1='$key' AND ID2='$k')");
            }
        }
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