<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbRute extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'json_data' => [
				'type' => 'JSON',
				'null' => true,
			],
			'nama_kelompok' => [
				'type' => 'VARCHAR',
				'constraint' => 16,
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('tb_rute');
	}

	public function down()
	{
		$this->forge->dropTable('tb_rute');
	}
}
