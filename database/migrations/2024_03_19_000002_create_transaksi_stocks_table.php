<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_stocks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('stock_id')->constrained('stocks')->onDelete('cascade');
            $table->string('keterangan');
            $table->unsignedInteger('jumlah');
            $table->enum('jenis', ['Debit', 'Kredit']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_stocks');
    }
}; 