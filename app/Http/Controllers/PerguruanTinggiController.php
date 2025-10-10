<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PerguruanTinggiController extends Controller
{
    public function index()
    {
        try {
            $response = Http::timeout(10)->get('https://frontend-pddikti.classy.id/api/perguruan_tinggi');

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Gagal mengambil data dari PDDikti'], $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Tidak dapat terhubung ke API PDDikti'], 500);
        }
    }
}
