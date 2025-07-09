<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'stock_id',
        'keterangan',
        'jumlah',
        'jenis'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'integer',
        'stock_id' => 'integer',
        'keterangan' => 'string',
        'jenis' => jenistransaksi::class
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }
} 