<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanKerusakan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan_kerusakan';

    protected $fillable = [
        'nama_pelapor',
        'email_pelapor',
        'barang_id',
        'tingkat_kerusakan',
        'deskripsi',
        'status',
        'foto'
    ];
}