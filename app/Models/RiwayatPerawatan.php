<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerawatan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_perawatan';
    protected $primaryKey = 'id_perawatan';

    protected $fillable = [
        'id_item',
        'tanggal_perawatan',
        'jenis_perawatan',
        'deskripsi',
        'teknisi',
        'biaya',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_perawatan' => 'date',
        'biaya' => 'decimal:2'
    ];

    // Relasi ke Item
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }

    // Format biaya
    public function getFormattedBiayaAttribute()
    {
        return 'Rp ' . number_format($this->biaya, 0, ',', '.');
    }
}