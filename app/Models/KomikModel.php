<?php namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    protected $table      = 'komik'; //set nama tabel yg konek
    protected $primaryKey = 'id';   //set prymari key
    protected $useTimestamps = true; // untuk tabel created_at dan update_at
    protected $allowedFields = ['judul', 'slug','penulis','penerbit','sampul'];

    // ========= ATRIBUTE BOLEH DI PAKE OR NOT ===============
    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;
    // =======================================================

    public function getKomik($slug = false){
        if ($slug == false) {
            return $this->findAll(); // Select * nama tabel protected di model
        }
        return $this->where(['slug'=>$slug])->first();
    }
}