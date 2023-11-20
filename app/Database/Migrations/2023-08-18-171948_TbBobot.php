<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbBobot extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'ID' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'auto_increment' => TRUE,
			],
			'ID1' => [
				'type' => 'VARCHAR',
				'constraint' => 16,
				'null' => TRUE,
			],
			'ID2' => [
				'type' => 'VARCHAR',
				'constraint' => 16,
				'null' => TRUE,
			],
			'bobot' => [
				'type' => "DOUBLE",
				'null' => TRUE,
			],
		]);

		$this->forge->addKey('ID', TRUE);
		$this->forge->createTable('tb_bobot');
	}

	public function down()
	{
		$this->forge->dropTable('tb_bobot');
	}
}
