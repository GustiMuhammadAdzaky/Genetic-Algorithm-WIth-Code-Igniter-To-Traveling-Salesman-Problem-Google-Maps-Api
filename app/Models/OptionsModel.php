<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionsModel extends Model
{
	protected $table                = 'tb_option';
	protected $primaryKey           = 'id';
	// protected $returnType 			= 'array';
	protected $allowedFields 		= ["cost_per_kilo"];


	public function updateData($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('tb_option', $data);
		return $this->db->affected_rows();
	}
}
