<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokModel extends Model
{
    protected $table = 'tb_kelompok';
    protected $useTimestamps = false;
    protected $returnType = 'array';
    // protected $primaryKey = 'kode_kelompok';
    protected $allowedFields = ["kode_kelompok", "nama_kelompok"];


    


    public function kodeOto()
    {
        $field = "kode_kelompok";
        $prefix = "K";
        $length = 2;
        $var = $this->db->query("SELECT $field FROM $this->table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");
        
        if ($var->getResult() == null) {
            $res = 'K00';
        }
        else {
            $res = $var->getResult()[0]->$field;
        }
    
        
        if($res){
            return $prefix . substr( str_repeat('0', $length) . (substr($res, - $length) + 1), - $length );
        } else {
            return $prefix . str_repeat('0', $length - 1) . 1;
        }
    }

    


}