<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    protected $fillable = [];

    /**
     * Get the transaksi stocks for the stock.
     */
    public function transaksiStocks(): HasMany
    {
        return $this->hasMany(TransaksiStock::class);
    }
} 