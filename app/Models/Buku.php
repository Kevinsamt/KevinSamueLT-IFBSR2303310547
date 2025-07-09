<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'judul',
        'pengarang',
        'kategori',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function scopeTersedia($query)
    {
        return $query->whereDoesntHave('peminjamans', function ($q) {
            $q->whereNull('tanggal_kembali');
        });
    }
}
