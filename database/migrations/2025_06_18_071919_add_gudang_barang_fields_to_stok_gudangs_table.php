<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stok_gudangs', function (Blueprint $table) {
            $table->string('kode_barang', 50)->nullable()->after('nama_barang');
            $table->string('satuan', 20)->nullable()->after('jumlah');
            $table->decimal('harga_satuan', 15, 2)->nullable()->after('satuan');
            $table->string('kategori', 50)->nullable()->after('jenis_barang');
            $table->date('tanggal_masuk')->nullable()->after('kategori');
            $table->date('tanggal_expired')->nullable()->after('tanggal_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_gudangs', function (Blueprint $table) {
            $table->dropColumn([
                'kode_barang',
                'satuan',
                'harga_satuan',
                'kategori',
                'tanggal_masuk',
                'tanggal_expired',
            ]);
        });
    }
};
