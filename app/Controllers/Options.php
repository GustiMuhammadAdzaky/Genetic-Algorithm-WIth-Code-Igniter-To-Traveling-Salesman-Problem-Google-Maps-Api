<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OptionsModel;

class Options extends BaseController
{
	protected $OptionsModel;
	public function __construct()
	{
		$this->OptionsModel = new OptionsModel();
	}
	public function index()
	{

		$data = [
			"title" => "Options",
			"biaya" => $this->OptionsModel->findAll()[0]["cost_per_kilo"],
		];
		return view("Options/index", $data);
	}

	public function update()
	{
		// Ambil data dari form input
		$biaya = $this->request->getVar('biaya');

		// Buat array data untuk diupdate
		$data = [
			'cost_per_kilo' => $biaya
		];

		// Panggil model OptionsModel untuk melakukan pembaruan data
		$model = new \App\Models\OptionsModel();
		$id = 1; // Contoh: ID data yang ingin diupdate
		$model->update($id, $data);
		return redirect()->to('/Options');
	}
}
