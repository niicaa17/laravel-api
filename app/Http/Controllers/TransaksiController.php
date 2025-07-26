<?php
namespace App\Http\Controllers\Api;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::all();
        return response()->json([
            'status' => true,
            'message' => 'List Transaksi',
            'data' => $data
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'total' => 'required|numeric'
        ]);

        $transaksi = Transaksi::create($validated);

        return response()->json([
            'message' => 'Transaksi Berhasil Disimpan',
            'data' => $transaksi
        ], 201);
    }

    public function show(Transaksi $transaksi)
    {
        return $transaksi;
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $transaksi->update($request->all());
        return $transaksi;
    }

    public function destroy($id)
    {
        Transaksi::destroy($id);
        return response()->json(['message' => 'Transaksi Berhasil Dihapus']);
    }
}