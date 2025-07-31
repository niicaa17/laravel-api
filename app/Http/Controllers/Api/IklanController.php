<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iklan;
use App\Http\Resources\IklanResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IklanController extends Controller
{
    public function index()
    {
        $iklans = Iklan::latest()->get();
        return IklanResource::collection($iklans);
    }
    public function store(Request $request)

    {
        $validator = Validator::make($request->all(), [
            'uraian' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('iklans', 'public/iklans');
        }
        $iklan = Iklan::create([
            'uraian' => $request->uraian,
            'gambar' => $gambarPath,
        ]);
        return new IklanResource($iklan);
    }
    public function show($id)
    {
        $iklan = Iklan::findOrFail($id);
        return new IklanResource($iklan);
    }
    public function update(Request $request, $id)
    {
        $iklan = Iklan::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'uraian' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->hasFile('gambar')) {

            if ($iklan->gambar && Storage::disk('public/iklans')->exists($iklan->gambar)) {
                Storage::disk('public/iklans')->delete($iklan->gambar);
            }
            $iklan->gambar = $request->file('gambar')->store('iklans', 'public/iklans');
        }
        $iklan->uraian = $request->uraian;
        $iklan->save();
        return new IklanResource($iklan);
    }
    public function destroy($id)
    {
        $iklan = Iklan::findOrFail($id);
        if ($iklan->gambar && Storage::disk('public/iklans')->exists($iklan->gambar)) {
            Storage::disk('public/iklans')->delete($iklan->gambar);
        }
        $iklan->delete();
        return response()->json(['message' => 'Iklan berhasil dihapus']);
    }
}
