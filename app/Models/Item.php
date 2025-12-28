<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
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

    // Relasi ke pengaduan
    public function pengaduanKerusakan()
    {
        return $this->hasMany(PengaduanKerusakan::class, 'id_item', 'id_item');
    }

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}