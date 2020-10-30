<?php 
namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
	protected $komikModel; // ngenalin var $komikModel ke turunan (koding ini semua)
	public function __construct()
	{
		$this->komikModel	= new KomikModel();
	}

	public function index()
	{   
		
		// ============== Konek manual ke DB ===============
		// =================================================
		// $db		= \Config\Database::connect();
		// $komik	= $db->query("SELECT * FROM komik ");
		// foreach ($komik->getResultArray() as $key) {
		// 	d($key);
		// }
		// OR PAKE INI
		// $komik	= $db->query("SELECT * FROM komik ")->getResultArray();
		// ==================================================

		// ============== Konek DB Pakai Model ==============
		// ==================================================
		$komik 	= $this->komikModel->findAll(); // SELECT * FROM nama tabel di komik model
		
		$data = [
			'judul' => 'Daftar Komik',
			'komik'	=> $komik
		];
		
		

		return view('komik/index',$data);
	}

	//--------------------------------------------------------------------

}