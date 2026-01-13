<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'peminjaman_id',
        'material_id',
        'jumlah',
        'returned_jumlah',
        'catatan',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
