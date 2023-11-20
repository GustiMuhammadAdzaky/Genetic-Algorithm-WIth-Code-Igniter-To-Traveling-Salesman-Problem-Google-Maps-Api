<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		// $session = session();
		// if (!$session->get('isLoggedIn')) {
		// 	return redirect()->to('/');
		// }
		$data = ['title' => 'Dashboard'];
		return view('index', $data);
	}
}
