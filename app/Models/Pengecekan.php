<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengecekan extends Model
{
   protected $table = 'pengecekan';
    protected $primaryKey = 'id_pengecekan';
    
    protected $fillable = [
        'id_ruangan',
        'tanggal_cek',
        'petugas',
        'catatan'
    ];

    protected $casts = [
        'tanggal_cek' => 'date'
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function detailPengecekan()
    {
        return $this->hasMany(DetailPengecekan::class, 'id_pengecekan', 'id_pengecekan');
    }
}