<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = 'id_item';

    protected $fillable = [
        'kode_barang',
        'nama_item',
        'merk',
        'id_kategori',
        'foto',
        'id_ruangan',
        'kondisi'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationship dengan Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Relationship dengan Ruangan
     */
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    /**
     * Relationship dengan Detail Pengecekan
     */
    public function detailPengecekan()
    {
        return $this->hasMany(DetailPengecekan::class, 'id_item', 'id_item');
    }

    /**
     * Accessor untuk format nilai
     */
    public function getFormattedNilaiAttribute()
    {
        return 'Rp ' . number_format($this->nilai, 0, ',', '.');
    }

    /**
     * Accessor untuk URL foto
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('assets/img/no-image.png');
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori($query, $kategoriId)
    {
        if ($kategoriId) {
            return $query->where('id_kategori', $kategoriId);
        }
        return $query;
    }

    /**
     * Scope untuk filter berdasarkan ruangan
     */
    public function scopeByRuangan($query, $ruanganId)
    {
        if ($ruanganId) {
            return $query->where('id_ruangan', $ruanganId);
        }
        return $query;
    }

    /**
     * Scope untuk filter berdasarkan kondisi
     */
    public function scopeByKondisi($query, $kondisi)
    {
        if ($kondisi) {
            return $query->where('kondisi', $kondisi);
        }
        return $query;
    }

    /**
     * Scope untuk search
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_item', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%");
            });
        }
        return $query;
    }
}