<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori', 'deskripsi'];
    
    // Relasi ke items
    public function items()
    {
        return $this->hasMany(Item::class, 'id_kategori', 'id_kategori');
    }
}