<?php namespace App\Controllers;

class Pages extends BaseController
{
	public function index()
	{
        $data = [
            'judul' => "Home"
        ];
        
        // echo view('layout/header', $data);
		return view('pages/home', $data);
        // echo view('layout/footer');
    }
    
    public function about(){ 
        $data = [
            'judul' => "About"
        ];
        
        // echo view('layout/header', $data);
        return view('pages/about', $data);
        // echo view('layout/footer');
    }

	//--------------------------------------------------------------------

}
