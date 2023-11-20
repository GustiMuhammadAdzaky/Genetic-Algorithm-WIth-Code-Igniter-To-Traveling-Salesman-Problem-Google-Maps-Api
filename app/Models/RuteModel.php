<?php

namespace App\Models;

use CodeIgniter\Model;

class RuteModel extends Model
{
	protected $table = 'tb_rute';
	protected $useTimestamps = false;
	protected $primaryKey = 'id';
	protected $allowedFields = ['json_data', 'nama_kelompok'];
}
