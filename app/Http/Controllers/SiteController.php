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
    $projek = Projek::all(); 

    $site = Site::with('projek_ref')
                ->orderBy('id_site', 'desc')
                ->get();

    // ✅ TAMBAH INI
    $kategori = Site::select('kategori')->distinct()->pluck('kategori');

    return view('layouts.app', [
        'projek' => $projek,
        'sites' => $site,
        'kategori' => $kategori // WAJIB ADA
    ]);
}    
public function store(Request $request)
    {
        $request->validate([
            'id_projek' => 'required|exists:projek,id_projek',
            'kategori' => 'required|in:1,2,3',
            'projek' => 'required|string|max:255',

            // Aturan 'ip' dihapus agar bisa menerima Hostname/Domain
            // Tetap 'unique' agar tidak ada duplikasi alamat perangkat
            'ip_address' => 'required|string|max:255|unique:site,ip_address',

            'tgl_instalasi' => 'required|date',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'note' => 'nullable|string',
        ], [
            'ip_address.unique' => 'Alamat IP/Hostname ini sudah terdaftar!',
            'required' => 'Kolom :attribute wajib diisi!',
        ]);

        try {
            \App\Models\Site::create($request->all());
            return redirect()->back()->with('success', 'Site berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id_site)
    {
        // Validasi input sesuai schema di gambar
        $request->validate([
            'id_projek' => 'required|exists:projek,id_projek',
            'projek' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'kategori' => 'required|in:1,2,3',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'tgl_instalasi' => 'required|date',
            'note' => 'nullable|string',
        ]);

        try {
            // Mencari data berdasarkan primary key id_site
            $site = Site::where('id_site', $id_site)->firstOrFail();

            // Update data
            $site->update([
                'id_projek' => $request->id_projek,
                'projek' => $request->projek,
                'ip_address' => $request->ip_address,
                'kategori' => $request->kategori,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'tgl_instalasi' => $request->tgl_instalasi,
                'note' => $request->note,
            ]);

            return redirect()->back()->with('success', 'Data site berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            // Kita paksa cari berdasarkan kolom id_site
            $site = Site::where('id_site', $id)->first();

            if (!$site) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data dengan ID ' . $id . ' tidak ditemukan.'
                ], 404);
            }

            $site->delete();

            return response()->json([
                'success' => true,
                'message' => 'Site berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal hapus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id_site)
    {
        $site = Site::with('projek_ref')->where('id_site', $id_site)->first();

        if (!$site) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $site
        ]);
    }
    public function checkStatus(Request $request)
    {
        $ip = $request->query('ip');

        // ⚫ 1. CEK IP KOSONG / NULL
        if (!$ip || trim($ip) === '') {
            return response()->json([
                'status' => 'unreachable',
                'message' => 'IP kosong'
            ]);
        }

        // ⚫ 2. VALIDASI FORMAT IP
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return response()->json([
                'status' => 'unreachable',
                'message' => 'IP tidak valid'
            ]);
        }

        $isWindows = PHP_OS_FAMILY === 'Windows';

        $command = $isWindows
            ? "ping -n 1 -w 1000 " . escapeshellarg($ip)
            : "ping -c 1 -W 1 " . escapeshellarg($ip);

        exec($command, $output, $result);

        $outputString = implode(" ", $output);

        // ⚫ 3. DETEKSI HOST UNREACHABLE (LEVEL NETWORK)
        if (
            str_contains(strtolower($outputString), 'unreachable') ||
            str_contains(strtolower($outputString), 'could not find host') ||
            str_contains(strtolower($outputString), 'unknown host')
        ) {
            return response()->json([
                'status' => 'unreachable',
                'ip' => $ip,
                'response_time' => 0
            ]);
        }

        // 🟢 4. ONLINE
        if ($result === 0) {

            $responseTime = 0;

            if ($isWindows) {
                preg_match('/(?:time|waktu)[=<](\d+)ms/i', $outputString, $matches);
                $responseTime = isset($matches[1]) ? $matches[1] : 0;
            } else {
                preg_match('/time=(\d+\.?\d*)\s*ms/i', $outputString, $matches);
                $responseTime = isset($matches[1]) ? round($matches[1]) : 0;
            }

            return response()->json([
                'status' => 'online',
                'ip' => $ip,
                'response_time' => $responseTime
            ]);
        }

        // 🔴 5. OFFLINE (TIMEOUT / NO RESPONSE)
        return response()->json([
            'status' => 'offline',
            'ip' => $ip,
            'response_time' => 0
        ]);
    }
}
