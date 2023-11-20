<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BobotModel;



class Bobot extends BaseController
{
	protected $BobotModel;
	public function __construct()
	{
		$this->BobotModel = new BobotModel();
	}
	public function index()
	{
		$getData = $this->request->getGet();
		// dd($getData);
		// dd($this->BobotModel->getRow($getData["kode_kelompok"]));

		if ($getData != null) {
			$titikOption = $this->BobotModel->getTitikOption($getData["kode_kelompok"]);
			$rows = $this->BobotModel->getRow($getData["kode_kelompok"]);
		} else {
			$titikOption = "";
			$rows = "";
		}
		// $titikOption = $this->BobotModel->getTitikOption($getData["kode_kelompok"]);
		$kelompokModel = $this->BobotModel->getKelompok();
		$TITIK = $this->BobotModel->getTitik();
		$data = [
			'title' => 'Pembobotan',
			'kelompok' => $kelompokModel,
			'getData' => $getData,
			'titikOption' => $titikOption,
			'rows' => $rows,
			'model' => $this->BobotModel,
			'TITIK' => $TITIK,
		];
		return view('Bobot/index', $data);
	}
	public function save()
	{
		$this->BobotModel->saveBobot($this->request->getVar('bobot'));
		return redirect()->to('/Bobot');
	}
}
