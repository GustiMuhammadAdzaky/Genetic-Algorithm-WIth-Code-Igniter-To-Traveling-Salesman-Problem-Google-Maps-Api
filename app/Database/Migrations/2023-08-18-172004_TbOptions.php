<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbOptions extends Migration
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
			'cost_per_kilo' => [
				'type' => 'VARCHAR',
				'constraint' => 16,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('tb_option');
	}

	public function down()
	{
		$this->forge->dropTable('tb_option');
	}
}
