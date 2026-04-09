<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projek;

class homeController extends Controller
{
    public function store(Request $request)
{
    Projek::create([
        'nama_projek' => $request->nama_projek,
    
    ]);

    return redirect()->back()->with('success', 'Projek berhasil ditambahkan');
}
}
