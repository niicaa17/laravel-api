<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use App\Http\Resources\PromoResource;
use Illuminate\Support\Facades\Validator;

class PromoController extends Controller
{
    public function index()
    {
        return PromoResource::collection(Promo::latest()->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uraian' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $promo = Promo::create($request->only(['uraian', 'tanggal']));
        return new PromoResource($promo);
    }
    public function show($id)
    {
        $promo = Promo::findOrFail($id);
        return new PromoResource($promo);
    }
    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'uraian' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $promo->update($request->only(['uraian', 'tanggal']));
        return new PromoResource($promo);
    }
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);

        $promo->delete();
        return response()->json(['message' => 'Promo berhasil dihapus']);
    }
}
