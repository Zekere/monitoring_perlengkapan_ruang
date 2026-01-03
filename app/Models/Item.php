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

    // ========================================
    // TAMBAHKAN KODE DI BAWAH INI (SEBELUM KURUNG KURAWAL PENUTUP)
    // ========================================

    /**
     * Relasi ke Riwayat Perawatan
     */
    public function riwayatPerawatan()
    {
        return $this->hasMany(RiwayatPerawatan::class, 'id_item', 'id_item')
                    ->orderBy('tanggal_perawatan', 'desc');
    }

    /**
     * Get riwayat perawatan terakhir
     */
    public function perawatanTerakhir()
    {
        return $this->hasOne(RiwayatPerawatan::class, 'id_item', 'id_item')
                    ->latestOfMany('tanggal_perawatan');
    }
}