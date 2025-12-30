<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanKerusakan extends Model
{
    use HasFactory;
    
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

    // Relasi ke tabel items (SUDAH ADA DI KODE ANDA)
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
    
    // TAMBAHAN BARU: Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Menunggu' => 'warning',
            'Diproses' => 'info',
            'Selesai' => 'success',
        ];
        
        return $badges[$this->status] ?? 'secondary';
    }
    
    // TAMBAHAN BARU: Accessor untuk badge tingkat kerusakan
    public function getTingkatBadgeAttribute()
    {
        $badges = [
            'Ringan' => 'success',
            'Sedang' => 'warning',
            'Berat' => 'danger',
        ];
        
        return $badges[$this->tingkat_kerusakan] ?? 'secondary';
    }
}