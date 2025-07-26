<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

Class HomeController extends Controller
{
    public function index()
    {
        $data = [
            [
                'id' => 1,
                'title' => 'Promo Juni 2025',
                'description' => 'Diskon 50% untuk semua layanan'
            ],
            [
                'id' => 2,
                'title' => 'Fitur Baru',
                'description' => 'Sekarang bisa bayar dengan QRIS!'
            ]
        ];
        return response()->json($data);
    }
}