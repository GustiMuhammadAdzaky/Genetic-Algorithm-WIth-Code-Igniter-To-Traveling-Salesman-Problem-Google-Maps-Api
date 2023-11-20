<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelompokModel;

class Kelompok extends BaseController
{
    protected $KelompokModel;
    public function __construct()
    {
        $this->KelompokModel = new KelompokModel();
    }

    public function index()
    {
        session();
        $kelompokModel = $this->KelompokModel->findAll();
        $data = [
            'validation' => $validation = \Config\Services::validation(),
            'title' => 'Kelompok',
            'kelompok' => $kelompokModel,
            'berhasil' => session()->get("success")
        ];
        return view('Kelompok/index', $data);
    }
    public function Tambah()
    {
        session();
        $kodeOtomatis = $this->KelompokModel->kodeOto();
        $value = $this->setValue('kode', $kodeOtomatis);
        $data = [
            'title' => 'Tambah data Kelompok',
            'kodeOtomatis' => $value,
            'validation' => $validation = \Config\Services::validation(),
        ];
        return view('Kelompok/tambah', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'kode_kelompok' => [
                'rules' => 'required|is_unique[tb_kelompok.kode_kelompok]',
                'errors' => [
                    'required' => 'Kode Kelpompok Harus Diisi!.',
                    'is_unique' => 'Kode Kelompok Tidak boleh Sama!'
                ]
            ],
            'nama_kelompok' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelpompok Harus Diisi!.',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/Kelompok/tambah')->withInput()->with('validation', $validation);
        };


        $this->KelompokModel->save([
            'kode_kelompok' => $this->request->getVar('kode_kelompok'),
            'nama_kelompok' => $this->request->getVar('nama_kelompok')
        ]);

        return redirect()->to('/Kelompok')->with("success", "Data berhasil ditambahkan");
    }

    public function delete()
    {
        $id = $this->request->getGet();
        $this->KelompokModel->where('kode_kelompok', $id)->delete();
        return redirect()->to('/Kelompok')->with("success", "Data berhasil dihapus");
    }

    public function edit()
    {
        session();
        $getData = $this->request->getVar();
        $data = [
            'validation' => $validation = \Config\Services::validation(),
            'title' => 'Form Ubah Data Kelompok',
            'getData' => $getData,
        ];
        return view('Kelompok/edit', $data);
    }
    public function update()
    {

        if (!$this->validate([
            'kode_kelompok' => 'required',
            'nama_kelompok' => 'required'
        ])) {
            $validation = \Config\Services::validation();
            // dd($validation);
            return redirect()->to('/Kelompok')->withInput()->with('gagalEdit', $validation);
        }


        $data = [
            'kode_kelompok' => $this->request->getVar('kode_kelompok'),
            'nama_kelompok' => $this->request->getVar('nama_kelompok'),
        ];

        $this->KelompokModel->update($this->request->getVar('id'), $data);
        return redirect()->to('/Kelompok')->with("success", "Data berhasil Edit");
    }
}
