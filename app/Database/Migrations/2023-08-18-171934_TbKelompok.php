<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbKelompok extends Migration
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
			'kode_kelompok' => [
				'type' => 'VARCHAR',
				'constraint' => 16,
			],
			'nama_kelompok' => [
				'type' => 'VARCHAR',
				'constraint' => '200',
				'null' => TRUE,
			]
		]);

		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('tb_kelompok');
	}

	public function down()
	{
		$this->forge->dropTable('tb_kelompok');
	}
}
