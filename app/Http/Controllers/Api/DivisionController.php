<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DivisionResource;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query builder untuk divisions
        $query = Division::query();

        // Terapkan filter berdasarkan nama jika ada di request
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Ambil data dengan paginasi (sesuai permintaan soal)
        $divisions = $query->paginate(10); 

        // Kembalikan data menggunakan resource collection.
        // Laravel akan otomatis membungkusnya dengan format pagination yang benar.
        return DivisionResource::collection($divisions);
    }
}
