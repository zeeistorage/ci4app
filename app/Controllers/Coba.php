<?php namespace App\Controllers;

class Coba extends BaseController
{
	public function index()
	{
		echo "ini controler coba index";
    }
    
    public function about($nama=""){
        echo "nama saya $nama";
    }

	//--------------------------------------------------------------------

}
