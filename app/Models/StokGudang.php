<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokGudang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stok_gudangs';

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'jumlah',
        'satuan',
        'harga_satuan',
        'lokasi',
        'jenis_barang',
        'kategori',
        'tanggal_masuk',
        'tanggal_expired',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'status' => 'boolean',
        'jumlah' => 'integer',
        'harga_satuan' => 'decimal:2',
        'tanggal_masuk' => 'date',
        'tanggal_expired' => 'date'
    ];
    
    public function transaksiStock()
    {
        return $this->hasMany(TransaksiStock::class, 'stock_id', 'id');
    }
    
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
} 