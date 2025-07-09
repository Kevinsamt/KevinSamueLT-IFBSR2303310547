<?php

namespace App;

use Illuminate\Support\Str;

enum jenistransaksi:string
{
    case debit = 'debit';
    case kredit = 'kredit';
    public function getLabel(): ?string
    {
        return Str::of($this->value)->title();
    }
}
