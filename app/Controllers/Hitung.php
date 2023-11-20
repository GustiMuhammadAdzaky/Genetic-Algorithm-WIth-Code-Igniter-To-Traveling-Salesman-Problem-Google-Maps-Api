<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HitungModel;
use App\Models\RuteModel;
use App\Models\OptionsModel;
use App\Models\BobotModel;

class Hitung extends BaseController
{
	protected $HitungModel;
	protected $OptionsModel;
	protected $BobotModel;
	public function __construct()
	{
		$this->HitungModel = new HitungModel();
		$this->OptionsModel = new OptionsModel();
		$this->BobotModel = new BobotModel();
	}
	public function index()
	{
		session();
		$getData = $this->request->getGet();

		if ($getData != null) {
			$titikOption = $this->HitungModel->getTitikOption($getData["kode_kelompok"]);
		} else {
			$titikOption = "";
		}


		$data = [
			"validation" => $validation = \Config\Services::validation(),
			"title" => "Hitung",
			"kelompok" => $this->HitungModel->getKelompok(),
			"getData" => $getData,
			"titikOption" => $titikOption,
		];
		return view('Hitung/index', $data);
	}
	public function Generate()
	{

		// if (!$this->validate([
		//     'titikTujuan' => [
		//         'rules' => 'required',
		//         'errors' => [
		//             'required' => 'Gagal Pada titik tujuan',
		//         ]
		// 	],
		// 	'titikTujuan' => [
		//         'rules' => 'required',
		//         'errors' => [
		//             'required' => 'Gagal Pada titik tujuan',
		//         ]
		// 	],
		// 	'num_kromosom' => [
		//         'titikAwal' => 'required',
		//         'errors' => [
		//             'required' => 'Gagal pada Num Kromosom',
		//         ]
		//     ],
		// 	'max_generation' => [
		//         'titikAwal' => 'required',
		//         'errors' => [
		//             'required' => 'Gagal pada Penginputan generasi',
		//         ]
		//     ],
		// ])){
		//     $validation = \Config\Services::validation();
		//     // return redirect()->to('/Hitung')->with('gagalEditTitik', $validation);
		// 	return redirect()->to('/Hitung')->withInput()->with('gagal', $validation);
		// };

		// --------------------
		// rows
		$explode = explode(",", $this->request->getVar("titikTujuan"));
		$kode_kelompok = $this->request->getVar("kode_kelompok");
		$rows = $this->HitungModel->getRow($kode_kelompok, $explode);

		// --------------------
		// ARRAYDATA
		$arr_data = array();
		foreach ($rows as $row) {
			$arr_data[$row->ID1][$row->ID2] = $row->bobot;
		}
		// Titik Awal
		$titikAwal = $this->request->getVar("titikAwal");
		// TITIK
		$TITIK = $this->HitungModel->getTitik();
		// ---------------------

		// d($arr_data);
		// d($titikAwal);
		// d($TITIK);

		$ag = new \App\Models\Ag($arr_data, $titikAwal, $TITIK);

		// $ag->max_generation = $this->request->getVar("max_generation");
		// $ag->debug = $this->request->getVar("debug");
		// $ag->crossover_rate = 75;
		// $ag->generate();


		$data = [
			"title" => "Generate",
			"ag" => $ag,
			"getVar" => $this->request->getVar(),
			"POINTS" => $this->HitungModel->getPoint(),
			"model" => $this->HitungModel,
			"TITIK" => $TITIK,
			"cost_per_kilo" => $this->OptionsModel->findAll()[0]["cost_per_kilo"],
			'rows' => $rows,
			'bobotModel' => $this->BobotModel,
		];
		return view('Hitung/generate', $data);
	}


	public function save()
	{
		$tempatAwal = unserialize($this->request->getVar('origin'));
		$destination = unserialize($this->request->getVar('detination'));
		$waypoint = unserialize($this->request->getVar('waypoint'));
		$arr_poly = unserialize($this->request->getVar('arr_poly'));
		$nama_kelompok = $this->request->getVar('nama_kelompok');
		$arr_rute = unserialize($this->request->getVar('arr_rute'));
		// dd($arr_rute);

		$data = [
			'tempatAwal' => [
				'lat' => $tempatAwal['lat'],
				'lng' => $tempatAwal['lng']
			],
			'destination' => [
				'lat' => $destination['lat'],
				'lng' => $destination['lng']
			],
			'waypoint' => [],
			'arr_poly' => [],
			'arr_rute' => $arr_rute
			// 'nama_kelompok' => $nama_kelompok
		];

		foreach ($waypoint as $index => $point) {
			$data['waypoint'][] = [
				'location' => $point['location'],
				'stopover' => $point['stopover']
			];
		}

		foreach ($arr_poly as $index => $point) {
			$data['arr_poly'][] = [
				'lat' => $point['lat'],
				'lng' => $point['lng']
			];
		}

		// foreach ($arr_rute as $index => $rute) {
		// 	$data['arr_rute'][] = $rute;
		// }

		$json = json_encode($data);

		// d(json);

		// Buat instance model RuteModel
		$ruteModel = new RuteModel();

		// Simpan data ke dalam tabel menggunakan model
		$ruteModel->insert([
			'json_data' => $json,
			'nama_kelompok' => $nama_kelompok,
		]);

		return redirect()->to('/rute');
	}
}
