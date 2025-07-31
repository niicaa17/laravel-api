<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Http\Resources\ArtikelResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->get();
        return ArtikelResource::collection($artikels);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('artikels', 'public/artikels');
        }
        $artikel = Artikel::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
        ]);
        return new ArtikelResource($artikel);
    }
    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return new ArtikelResource($artikel);
    }
    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->hasFile('gambar')) {
            if ($artikel->gambar && Storage::disk('public/artikels')->exists($artikel->gambar)) {
                Storage::disk('public/artikels')->delete($artikel->gambar);
            }
            $artikel->gambar = $request->file('gambar')->store('artikels', 'public/artikels');
        }
        $artikel->judul = $request->judul;
        $artikel->isi = $request->isi;
        $artikel->save();
        return new ArtikelResource($artikel);
    }
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        if ($artikel->gambar && Storage::disk('public/artikels')->exists($artikel->gambar)) {
            Storage::disk('public/artikels')->delete($artikel->gambar);
        }
        $artikel->delete();
        return response()->json(['message' => 'Artikel berhasil dihapus']);
    }
}
