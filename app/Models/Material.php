<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_material',
        'satuan',
        'stok',
        'spesifikasi',
        'foto',
        'jenis_kebutuhan',
        'lokasi',
        'tempat',
    ];
}
