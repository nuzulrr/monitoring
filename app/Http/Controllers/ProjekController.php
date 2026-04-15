<?php

namespace App\Http\Controllers;

use App\Models\Projek;
use Illuminate\Http\Request;

class ProjekController extends Controller
{
    public function store(Request $request)
    {
        Projek::create([
            'nama_projek' => $request->nama_projek,
            
        ]);

        return redirect()->back()->with('success', 'Projek berhasil ditambahkan');
    }
    public function destroy($id)
    {
        $projek = Projek::findOrFail($id);
        $projek->delete();

        return redirect()->back()->with('success', 'Projek berhasil dihapus');
    }
}