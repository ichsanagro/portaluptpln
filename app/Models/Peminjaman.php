<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans'; // Explicitly set the table name

    protected $fillable = [
        'user_id',
        'tanggal_peminjaman',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
