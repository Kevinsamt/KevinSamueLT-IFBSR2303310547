<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'deskripsi',
        'status',
        'kategori',
        'version',
    ];

    protected $casts = [
        'status' => 'boolean',
        'harga' => 'decimal:2'
    ];

    public function stock()
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }

    public static function getKategoriValid()
    {
        return ['Elektronik', 'Gadget', 'Aksesoris'];
    }
    public function totalStock(): Attribute
    {
        return Attribute::make(
            get: function(): int {
                return $this->stock()->sum('balance');
            }
        );
    }
}
