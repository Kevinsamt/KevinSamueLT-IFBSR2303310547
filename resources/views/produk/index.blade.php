<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Manajemen Produk</h1>
            <a href="{{ route('produk.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Produk</a>
        </div>

        <!-- Tabel Daftar Produk -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2">NAMA</th>
                        <th class="p-2">HARGA</th>
                        <th class="p-2">STOK</th>
                        <th class="p-2">KATEGORI</th>
                        <th class="p-2">STATUS</th>
                        <th class="p-2">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                    <tr class="border-t">
                        <td class="p-2">{{ $produk->nama }}</td>
                        <td class="p-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $produk->stok }}</td>
                        <td class="p-2">{{ $produk->kategori }}</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded {{ $produk->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $produk->status ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="p-2 space-x-2">
                            <a href="{{ route('produk.edit', $produk) }}" class="bg-yellow-400 px-3 py-1 rounded text-white hover:bg-yellow-500">Edit</a>
                            <form action="{{ route('produk.destroy', $produk) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 px-3 py-1 rounded text-white hover:bg-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $produks->links() }}
        </div>
    </div>
</body>
</html> 