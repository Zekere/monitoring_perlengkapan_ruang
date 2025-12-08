<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
     protected $table = 'items';
    protected $primaryKey = 'id_item';
    
    protected $fillable = [
        'nama_item',
        'merk',
        'id_kategori'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function detailPengecekan()
    {
        return $this->hasMany(DetailPengecekan::class, 'id_item', 'id_item');
    }
}