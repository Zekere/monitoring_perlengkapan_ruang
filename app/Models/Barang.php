<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id_item';
    
    protected $fillable = [
        'kode_barang',
        'nama_item',
        'merk',
        'foto',
        'id_kategori',
        'id_ruangan',
        'kondisi'
    ];
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
    
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}