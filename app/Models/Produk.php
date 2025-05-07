<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'deskripsi',
        'status',
        'kategori'
    ];

    protected $casts = [
        'status' => 'boolean',
        'harga' => 'decimal:2'
    ];

    public static function getKategoriValid()
    {
        return ['Elektronik', 'Gadget', 'Aksesoris'];
    }
}
