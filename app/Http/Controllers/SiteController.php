<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Projek;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
public function index()
{
    return view('layouts.app', [
        'projek' => Projek::all(), // 
        'site' => Site::with('projek')->get()
    ]);
}
public function store(Request $request)
{
    $request->validate([
        'id_projek'      => 'required|exists:projek,id_projek',
        'alamat'         => 'required|string|max:255',
        'latitude'       => 'required|numeric',
        'longitude'      => 'required|numeric',
        'ip_address'     => 'required|ip',
        'note'           => 'nullable|string',
        'tgl_instalasi'  => 'required|date' 
    ]);

    Site::create($request->all());

    return redirect()->back()->with('success', 'Site berhasil disimpan');
}
// app/Http/Controllers/SiteController.php

public function checkStatus(Request $request)
    {
        $ip = $request->query('ip');

        if (!$ip) {
            return response()->json(['status' => 'offline', 'message' => 'IP tidak ditemukan'], 400);
        }

        // Cek OS untuk menentukan parameter ping
        // -c 1 (Linux/Mac), -n 1 (Windows)
        // -W 1 (Timeout 1 detik agar tidak lambat)
        $str = (PHP_OS_FAMILY === 'Windows') 
                ? "ping -n 1 -w 1000 " . escapeshellarg($ip) 
                : "ping -c 1 -W 1 " . escapeshellarg($ip);

        exec($str, $output, $result);

        // Jika $result == 0 artinya Reply (Online)
        // Jika $result != 0 artinya RTO (Offline)
        if ($result === 0) {
            return response()->json([
                'status' => 'online',
                'ip' => $ip
            ]);
        } else {
            return response()->json([
                'status' => 'offline',
                'ip' => $ip
            ]);
        }
    }
}
