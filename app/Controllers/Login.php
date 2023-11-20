<?php

namespace App\Controllers;

// use App\Controllers\BaseController;
use CodeIgniter\Controller;

class Login extends Controller
{
	public function index()
	{
		// d(session('level'));
		$data = ['title' => 'Login'];
		return view('frontend/login', $data);
	}
	public function register()
	{
		// session();
		$data = [
			'validate' => \Config\Services::validation(),
		];
		return view('frontend/register', $data);
	}
}
