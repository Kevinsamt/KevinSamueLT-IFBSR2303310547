@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="text-2xl font-semibold mb-4">Transaksi Stocks</h2>
            
            <!-- Filters -->
            <div class="mb-4">
                <form action="{{ route('transaksi-stocks.index') }}" method="GET" class="flex gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis</label>
                        <select name="jenis" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua</option>
                            <option value="Debit" {{ request('jenis') == 'Debit' ? 'selected' : '' }}>Debit</option>
                            <option value="Kredit" {{ request('jenis') == 'Kredit' ? 'selected' : '' }}>Kredit</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="self-end">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Filter</button>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ route('transaksi-stocks.index', array_merge(request()->query(), ['sort' => 'tanggal', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                                    Tanggal
                                    @if(request('sort') == 'tanggal')
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ route('transaksi-stocks.index', array_merge(request()->query(), ['sort' => 'jumlah', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                                    Jumlah
                                    @if(request('sort') == 'jumlah')
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transaksiStocks as $transaksi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->tanggal->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->stock->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->keterangan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->jumlah }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaksi->jenis === 'Debit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $transaksi->jenis }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $transaksiStocks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 