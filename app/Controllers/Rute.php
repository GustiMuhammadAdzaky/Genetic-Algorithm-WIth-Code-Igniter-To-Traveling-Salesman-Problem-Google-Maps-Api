<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RuteModel;
use App\Models\OptionsModel;

class Rute extends BaseController
{
	protected $RuteModel;
	protected $OptionsModel;
	public function __construct()
	{
		$this->RuteModel = new RuteModel();
		$this->OptionsModel = new OptionsModel();
	}
	public function index()
	{
		$data = [
			"title" => "Rute Yang Tersimpan",
			"model" => $this->RuteModel->findAll()
		];
		return view('Rute/index', $data);
	}
	public function detail()
	{
		// Mendapatkan string JSON dari data yang diberikan:
		$jsonDataString = $this->request->getVar('data');
		// decode
		$jsonData = json_decode($jsonDataString);
		// Akses
		// d($jsonData);
		// d($destination);






		$data = [
			// "tempat_awal" => $jsonData->tempatAwal,
			// "destination" => $jsonData->destination,
			// "waypoint" =>  $jsonData->waypoint,
			// "arr_poly" => $jsonData->arr_poly,
			"title" => "Detail Maps",
			"jsonData" => $jsonData,
			"cost_per_kilo" => $this->OptionsModel->findAll()[0]["cost_per_kilo"],
			"id" => $this->request->getVar("id"),
		];

		return view('Rute/detail', $data);
	}


	public function delete()
	{
		$id = $this->request->getVar("id");
		$this->RuteModel->where('id', $id)->delete();
		return redirect()->to('/rute')->with("success", "Data berhasil ditambahkan");
	}
}
