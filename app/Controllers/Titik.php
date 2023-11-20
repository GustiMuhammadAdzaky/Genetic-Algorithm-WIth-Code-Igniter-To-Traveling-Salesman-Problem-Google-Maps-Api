<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TitikModel;
use App\Models\KelompokModel;

class Titik extends BaseController
{
	protected $TitikModel;
	protected $KelompokModel;
	public function __construct()
	{
		$this->TitikModel = new TitikModel();
		$this->KelompokModel = new KelompokModel();
	}
	public function index()
	{
		session();
		$titikModel = $this->TitikModel->findAll();
		$data = [
			'title' => 'Titik',
			'titik' => $titikModel,
			'berhasil' => session()->get("success_titik"),
			'validation' => $validation = \Config\Services::validation(),
		];
		return view('Titik/index', $data);
	}
	public function tambah()
	{
		session();
		$kodeOtomatis = $this->TitikModel->kodeOto();
		$kelompokModel = $this->KelompokModel->findAll();
		$data = [
			'title' => 'Tambah Titik',
			'kode' => $kodeOtomatis,
			'kelompok_model' => $kelompokModel,
			'validation' => $validation = \Config\Services::validation(),
		];
		return view('Titik/tambah', $data);
	}
	public function save()
	{
		if (!$this->validate([
			'kode_titik' => [
				'rules' => 'required|is_unique[tb_titik.kode_titik]',
				'errors' => [
					'required' => 'Kode Harus Diisi!.',
					'is_unique' => 'Kode Tidak boleh Sama!'
				]
			],
			'nama_titik' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama Titik Harus Diisi!.',
				]
			],
			'kode_kelompok' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'kelompok Harus Diisi!.',
				]
			],
			'latitude' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Anda belum Mengisikan Info Lokasi',
				]
			],
			'longitude' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Anda belum Mengisikan Info Lokasi',
				]
			]


		])) {
			$validation = \Config\Services::validation();
			return redirect()->to('/Titik/tambah')->withInput()->with('validation', $validation);
		};

		// dd($this->request->getVar());
		// $this->TitikModel->saveBobot($this->request->getVar('kode_titik'));

		$this->TitikModel->save([
			'kode_titik' => $this->request->getVar('kode_titik'),
			'nama_titik' => $this->request->getVar('nama_titik'),
			'kode_kelompok' => $this->request->getVar('kode_kelompok'),
			'lat' => $this->request->getVar('latitude'),
			'lng' => $this->request->getVar('longitude')
		]);

		$this->TitikModel->saveBobot($this->request->getVar('kode_titik'));

		return redirect()->to('/Titik')->with("success_titik", "Data berhasil ditambahkan");
	}

	public function edit()
	{
		session();
		$getData = $this->request->getVar();
		$data = [
			'validation' => $validation = \Config\Services::validation(),
			'title' => 'Halaman Edit',
			'getData' => $getData,
		];
		return view('Titik/edit', $data);
	}
	public function update()
	{
		if (!$this->validate([
			'kode_titik' => 'required',
			'nama_titik' => 'required',
			'kode_kelompok' => 'required',
			'latitude' => 'required',
			'longitude' => 'required'
		])) {
			// $validation = \Config\Services::validation();
			// dd($validation->getErrors());
			$validation = \Config\Services::validation();
			return redirect()->to('/Titik')->withInput()->with('gagalEditTitik', $validation);
		}

		// dd($this->request->getVar());
		$data = [
			'kode_titik' => $this->request->getVar('kode_titik'),
			'nama_titik' => $this->request->getVar('nama_titik'),
			'kode_kelompok' => $this->request->getVar('kode_kelompok'),
			'lat' => $this->request->getVar('latitude'),
			'lng' => $this->request->getVar('longitude'),
		];

		$this->TitikModel->update($this->request->getVar('id'), $data);
		return redirect()->to('/Titik')->with("success_titik", "Data berhasil Edit");
	}

	public function delete()
	{
		$id = $this->request->getGet();
		$this->TitikModel->where('kode_titik', $id)->delete();
		$this->TitikModel->hapusBobot($id);
		return redirect()->to('/Titik')->with("success_titik", "Data berhasil dihapus");
	}
}
