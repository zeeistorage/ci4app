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
		// $komik 	= $this->komikModel->findAll(); // SELECT * FROM nama tabel di komik model
		
		$data = [
			'judul' => 'Daftar Komik',
			'komik'	=> $this->komikModel->getKomik()
		];
		
		

		return view('komik/index',$data);
	}

	public function detail($slug){
		$komik = $this->komikModel->getKomik($slug);
		$data = [
			'judul' => 'Detail',
			'komik'	=> $komik
		];

		if (empty($data['komik'])) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik tidak ditemukan');
			
		}

		return view('komik/detail',$data);
	}

	public function create(){
		$data = [
			'judul' => 'tambah data'
		];
		
	}

	public function save(){
		// dd($this->request->getPost()); 
		// echo var_dump($_POST);
		// ========AMBIL DATA DARI METHOT =============
		// getVar 	= bisa ambil get dan post
		// getPost	= data post
		// getGet	= data Get
		$slug 	= url_title($this->request->getVar('judul'),'-',true);
		$this->komikModel->save([
			'judul'		=> $this->request->getVar('judul'),
			'slug'		=> $slug,
			'penulis'	=> $this->request->getVar('penulis'),
			'penerbit'	=> $this->request->getVar('penerbit'),
			'sampul'	=> $this->request->getVar('sampul')
		]);
		
		session()->setFlashdata('pesan','Berhasil');

		return redirect()->to('/komik');

	}

	//--------------------------------------------------------------------

}