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
        
    
public function update(Request $request, $id)
{
    // 1. Validasi
    $request->validate([
        'nama_projek' => 'required|string|max:255',
    ]);

    // 2. Proses Update
    $projek = Projek::findOrFail($id);
    $projek->nama_projek = $request->nama_projek;
    $projek->save();

    // 3. JANGAN PAKAI redirect()! 
    // Kirim respon JSON agar Fetch API masuk ke blok .then() bukan .catch()
    return response()->json([
        'success' => true,
        'message' => 'Data berhasil diupdate'
    ]);
}
}
