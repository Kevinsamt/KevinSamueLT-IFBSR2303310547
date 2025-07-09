<?php

namespace App\Http\Controllers;

use App\Models\TransaksiStock;
use Illuminate\Http\Request;

class TransaksiStockController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiStock::with('stock');

        // Sorting
        $sort = $request->get('sort', 'tanggal');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        // Filter by jenis
        if ($request->has('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $transaksiStocks = $query->paginate(10);
        
        return view('transaksi-stocks.index', compact('transaksiStocks'));
    }
} 