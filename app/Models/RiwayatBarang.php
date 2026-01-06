<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatBarang extends Model
{
    use HasFactory;

    protected $table = 'riwayat_barang';
    protected $primaryKey = 'id_riwayat';
    public $incrementing = true; // PENTING: pastikan ini true
    protected $keyType = 'int';  // PENTING: tipe primary key

    protected $fillable = [
        'id_item',
        'kode_barang',
        'nama_item',
        'kondisi_lama',
        'kondisi_baru',
        'id_ruangan_lama',   // SUDAH ADA di database
        'id_ruangan_baru',   // SUDAH ADA di database
        'jenis_perubahan',
        'keterangan',
        'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke tabel items
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }

    // Relasi ke ruangan lama
    public function ruanganLama()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan_lama', 'id_ruangan');
    }

    // Relasi ke ruangan baru
    public function ruanganBaru()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan_baru', 'id_ruangan');
    }

    // Scope untuk filter berdasarkan item
    public function scopeByItem($query, $itemId)
    {
        return $query->where('id_item', $itemId);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Format keterangan perubahan
    public function getFormattedPerubahan()
    {
        $perubahan = [];
        
        if ($this->kondisi_lama !== $this->kondisi_baru) {
            $perubahan[] = "Kondisi: {$this->kondisi_lama} → {$this->kondisi_baru}";
        }
        
        if ($this->id_ruangan_lama !== $this->id_ruangan_baru) {
            $ruanganLama = $this->ruanganLama ? $this->ruanganLama->nama_ruangan : 'Tidak ada';
            $ruanganBaru = $this->ruanganBaru ? $this->ruanganBaru->nama_ruangan : 'Tidak ada';
            $perubahan[] = "Ruangan: {$ruanganLama} → {$ruanganBaru}";
        }
        
        return implode(' | ', $perubahan);
    }
}