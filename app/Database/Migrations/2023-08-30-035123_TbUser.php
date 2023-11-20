<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbUsers extends Migration
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
			'nama' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
				// 'null' => TRUE,
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
				// 'null' => TRUE,
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
				// 'null' => TRUE,
			],
			'level' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
				// 'null' => TRUE,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('tb_users');
	}

	public function down()
	{
		$this->forge->dropTable('tb_users');
	}
}
