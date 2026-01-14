<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KerusakanReport extends Model
{
    protected $fillable = [
        'peminjaman_detail_id',
        'file_path',
        'catatan',
        'jumlah_rusak',
    ];
}
