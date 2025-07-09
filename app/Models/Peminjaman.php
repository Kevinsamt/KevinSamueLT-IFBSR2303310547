<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
