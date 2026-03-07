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
        'foto',
        'id_kategori',
        'id_ruangan',
        'kondisi',
        'jumlah_perawatan', // ← kolom permanen penghitung perawatan
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function riwayat()
    {
        return $this->hasMany(RiwayatBarang::class, 'id_item', 'id_item')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Relasi ke riwayat perawatan barang.
     * Digunakan untuk withCount('riwayatPerawatan') di BarangController.
     */
    public function riwayatPerawatan()
    {
        return $this->hasMany(RiwayatPerawatan::class, 'id_item', 'id_item');
    }

    // ── Event listener untuk tracking perubahan ─────────────

    protected static function boot()
    {
        parent::boot();

        // Saat akan update
        static::updating(function ($item) {
            $original = $item->getOriginal();
            $changes  = $item->getDirty();

            // Cek apakah ada perubahan pada field yang perlu di-track
            if (isset($changes['kondisi']) || isset($changes['id_ruangan'])) {
                RiwayatBarang::create([
                    'id_item'         => $item->id_item,
                    'kode_barang'     => $item->kode_barang,
                    'nama_item'       => $item->nama_item,
                    'kondisi_lama'    => $original['kondisi'] ?? null,
                    'kondisi_baru'    => $item->kondisi,
                    'id_ruangan_lama' => $original['id_ruangan'] ?? null,
                    'id_ruangan_baru' => $item->id_ruangan,
                    'jenis_perubahan' => self::detectChangeType($changes),
                    'keterangan'      => self::generateKeterangan($original, $item),
                    'updated_by'      => auth()->user()->name ?? 'System'
                ]);
            }
        });

        // Saat barang baru dibuat
        static::created(function ($item) {
            RiwayatBarang::create([
                'id_item'         => $item->id_item,
                'kode_barang'     => $item->kode_barang,
                'nama_item'       => $item->nama_item,
                'kondisi_lama'    => null,
                'kondisi_baru'    => $item->kondisi,
                'id_ruangan_lama' => null,
                'id_ruangan_baru' => $item->id_ruangan,
                'jenis_perubahan' => 'Data',
                'keterangan'      => 'Barang baru ditambahkan',
                'updated_by'      => auth()->user()->name ?? 'System'
            ]);
        });
    }

    // ── Helper methods ───────────────────────────────────────

    // Deteksi jenis perubahan
    private static function detectChangeType($changes)
    {
        $hasKondisi = isset($changes['kondisi']);
        $hasRuangan = isset($changes['id_ruangan']);

        if ($hasKondisi && $hasRuangan) {
            return 'Semua';
        } elseif ($hasKondisi) {
            return 'Kondisi';
        } elseif ($hasRuangan) {
            return 'Ruangan';
        } else {
            return 'Data';
        }
    }

    // Generate keterangan otomatis
    private static function generateKeterangan($original, $item)
    {
        $keterangan = [];

        if ($original['kondisi'] !== $item->kondisi) {
            $keterangan[] = "Kondisi berubah dari '{$original['kondisi']}' menjadi '{$item->kondisi}'";
        }

        if (($original['id_ruangan'] ?? null) !== $item->id_ruangan) {
            $ruanganLama = $original['id_ruangan']
                ? Ruangan::find($original['id_ruangan'])->nama_ruangan ?? 'Tidak diketahui'
                : 'Belum ada ruangan';
            $ruanganBaru = $item->id_ruangan
                ? Ruangan::find($item->id_ruangan)->nama_ruangan ?? 'Tidak diketahui'
                : 'Tidak ada ruangan';

            $keterangan[] = "Ruangan berubah dari '{$ruanganLama}' ke '{$ruanganBaru}'";
        }

        return implode('. ', $keterangan);
    }
}