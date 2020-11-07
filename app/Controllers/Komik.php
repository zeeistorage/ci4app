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
			'komik'	=> $this->komikModel->getKomik(),
			'validation'=> \Config\Services::validation(),
			
		];
		
		

		return view('komik/index',$data);
	}

	public function detail($slug){
		$komik = $this->komikModel->getKomik($slug);
		$data = [
			'judul' => 'Detail',
			'komik'	=> $komik,
			'validation'=> \Config\Services::validation()
		];

		if (empty($data['komik'])) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik tidak ditemukan');
			
		}

		return view('komik/detail',$data);
	}

	public function create(){
		$valid = \Config\Services::validation();
		if ($valid) {
			// $statusnya ="ada";
			dd(session());
		}else{
			dd(session());
			// $statusnya="no";
			// echo session();
		}
		$data = [
			'judul' 	=> 'tambah data',
			'validation'=> \Config\Services::validation(),
		];
		
	}

	public function save(){
		// ========== VALIDATION ============
		if (!$this->validate([
			
			'judul' => [
				'rules'		=> 'required|is_unique[komik.judul]',
				'errors'	=> [
					'required'	=> '{field} komik harus diisi',
					'is_unique'	=> '{field} komik sudah terdaftar'
				]
				],
			'sampul' => [
				'rules'		=> 'max_size[sampul,2024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
				'errors'	=> [
					'max_size'	=> 'max 2 mb',
					'is_image'	=> 'Harus gambar',
					'mime_in'	=> 'Harus gambar',
				]
			]
		])) {
			// JIKA SALAH
			// $validation = \Config\Services::validation();
			$statusnya  = 'gagal';
			session()->setFlashdata('status','Gagal');
			// return redirect()->to('/komik')->withInput()->with('validation',$validation);
			return redirect()->to('/komik')->withInput();
		}
		// ==========END VALIDATION =========

		// ========== Lanjtan upload =========
			// ambil gambar
			$filesampul = $this->request->getFile('sampul');
			// cek upload gk
			if ($filesampul->getError()==4) {
				$namafile ='default.jpg';
			}else{
				// pindah ke folder hosting
				$filesampul->move('img');
				// ambil nama file
				$namafile = $filesampul->getName();

			}
		// ========== END upload =========


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
			'sampul'	=> $namafile
		]);
		$statusnya = 'berhasil';
		session()->setFlashdata('pesan','Berhasil');

		return redirect()->to('/komik')->with('statusnya',$statusnya);

	}

	public function delete($id){

		$komik = $this->komikModel->find($id); //find where id
		
		if ($komik['sampul'] != 'default.jpg') {

			if (is_file('img/'.$komik['sampul'])) {
				// jika ada filenya di folder
				unlink('img/'.$komik['sampul']);
			}
		}
		
		$this->komikModel->delete($id);
		session()->setFlashdata('pesan','Data berhasil dihapus');
		
		return redirect()->to('/komik');
	}

	public function edit(){
		$slug = $this->request->getVar('slug');
		$getdata = $this->komikModel->getKomik($slug);
		return json_encode($getdata);
	}

	public function update(){
		// cek judul lama n baru
		$komiklama = $this->komikModel->getKomik($this->request->getVar('slug'));
		if ($komiklama['judul'] == $this->request->getVar('judul')) {
			$rules = 'required';
		}else{
			$rules = 'required|is_unique[komik.judul]';
		}

		// validation
		if (!$this->validate([
			
			'judul' => [
				'rules'		=> $rules,
				'errors'	=> [
					'required'	=> '{field} komik harus diisi',
					'is_unique'	=> '{field} komik sudah terdaftar'
				]
			],
			'sampul' => [
				'rules'		=> 'max_size[sampul,2024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
				'errors'	=> [
					'max_size'	=> 'max 2 mb',
					'is_image'	=> 'Harus gambar',
					'mime_in'	=> 'Harus gambar',
				]
			]
		])) {
			// JIKA SALAH
			$validation = \Config\Services::validation();
			$statusnya  = 'gagal';
			session()->setFlashdata('status','Gagal');
			return redirect()->to('/komik/'. $this->request->getVar('slug'))->withInput()->with('validation',$validation);
		}

		// Jika benar validation

		$filesampul = $this->request->getFile('sampul');
		// cek apakah ganti gambar
		if ($filesampul->getError()==4) {
			$namasampul = $this->request->getVar('sampullama');
		}else{
			$filesampul->move('img');
			// ambil nama file
			$namasampul = $filesampul->getName();
			unlink('img/'.$this->request->getVar('sampullama'));
		}

		// ===== koding update ===========
		// sama dengan SAVE/ create sayaratnya harus ada ID
		$slug 	= url_title($this->request->getVar('judul'),'-',true);
		$this->komikModel->save([
			'id'		=> $this->request->getVar('id'),
			'judul'		=> $this->request->getVar('judul'),
			'slug'		=> $slug,
			'penulis'	=> $this->request->getVar('penulis'),
			'penerbit'	=> $this->request->getVar('penerbit'),
			'sampul'	=> $namasampul
		]);
		$statusnya = 'berhasil';
		session()->setFlashdata('pesan','Berhasil di ubah');

		return redirect()->to('/komik')->with('statusnya',$statusnya);
	}

	//--------------------------------------------------------------------

}