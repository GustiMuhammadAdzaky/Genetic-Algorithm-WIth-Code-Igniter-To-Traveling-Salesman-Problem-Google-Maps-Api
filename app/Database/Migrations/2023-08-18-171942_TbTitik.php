<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbTitik extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			],
			'kode_titik' => [
				'type' => 'VARCHAR',
				'constraint' => 16,
			],
			'nama_titik' => [
				'type' => 'VARCHAR',
				'constraint' => '200',
				'null' => TRUE,
			],
			'kode_kelompok' => [
				'type' => 'VARCHAR',
				'constraint' => '200',
				'null' => TRUE,
			],
			'lat' => [
				'type' => 'double',
				'null' => TRUE,
			],
			'lng' => [
				'type' => 'double',
				'null' => TRUE,
			]
		]);

		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('tb_titik');
	}

	public function down()
	{
		$this->forge->dropTable('tb_titik');
	}
}
