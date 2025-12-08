<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengecekan extends Model
{
     protected $table = 'detail_pengecekan';
    protected $primaryKey = 'id_detail';
    
    protected $fillable = [
        'id_pengecekan',
        'id_item',
        'kondisi',
        'catatan'
    ];

    public function pengecekan()
    {
        return $this->belongsTo(Pengecekan::class, 'id_pengecekan', 'id_pengecekan');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}