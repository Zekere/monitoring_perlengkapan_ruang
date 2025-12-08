<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
     protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';
    
    protected $fillable = [
        'nama_ruangan'
    ];

    public function pengecekan()
    {
        return $this->hasMany(Pengecekan::class, 'id_ruangan', 'id_ruangan');
    }
}