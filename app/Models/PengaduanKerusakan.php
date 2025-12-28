<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanKerusakan extends Model
{
    protected $table = 'pengaduan_kerusakan';
    protected $primaryKey = 'id_pengaduan';
    
    protected $fillable = [
        'nama_pelapor',
        'email_pelapor',
        'id_item',
        'tingkat_kerusakan',
        'deskripsi',
        'foto',
        'status'
    ];

    // Relasi ke tabel items
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}