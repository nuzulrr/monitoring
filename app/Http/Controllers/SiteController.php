<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Projek;
use App\Models\DowntimeLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SiteController extends Controller
{
    public function index()
    {
        $projek = Projek::withCount('sites')->get();

        $site = Site::with('projek_ref')
            ->orderBy('id_site', 'desc')
            ->get();

        $totalSites = $projek->sum('sites_count');
        $kategori = Site::select('kategori')->distinct()->pluck('kategori');

        return view('layouts.app', [
            'projek' => $projek,
            'totalSites' => $totalSites,
            'sites' => $site,
            'kategori' => $kategori
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
            Site::create($request->all());
            return redirect()->back()->with('success', 'Site berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id_site)
    {
        $request->validate([
            'id_projek' => 'required|exists:projek,id_projek',
            'projek' => 'required|string|max:255',
            'ip_address' => 'required|ip|unique:site,ip_address,' . $id_site . ',id_site',
            'kategori' => 'required|in:1,2,3',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'tgl_instalasi' => 'required|date',
            'note' => 'nullable|string',
        ], [
            // Pesan kustom sesuai permintaan Anda
            'ip_address.unique' => 'IP ini sudah digunakan oleh site lain.',
        ]);

        // Proses update data
        $site = Site::where('id_site', $id_site)->firstOrFail();
        $site->update($request->all());

        // Berikan respon JSON agar Fetch di JavaScript tidak masuk ke bagian .catch(error)
        if ($request->ajax()) {
            return response()->json(['message' => 'Data berhasil diperbarui']);
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
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
        $siteId = $request->query('site_id');

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
            $this->logDowntime($siteId, $ip, 'unreachable');
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

            // Jika ada recovery dari downtime, log recovery
            if ($siteId) {
                $this->logRecovery($siteId, $ip);
            }

            return response()->json([
                'status' => 'online',
                'ip' => $ip,
                'response_time' => $responseTime
            ]);
        }

        // 🔴 5. OFFLINE (TIMEOUT / NO RESPONSE)
        $this->logDowntime($siteId, $ip, 'offline');
        return response()->json([
            'status' => 'offline',
            'ip' => $ip,
            'response_time' => 0
        ]);
    }

    /**
     * Log downtime event
     */
    private function logDowntime($siteId, $ip, $status)
    {
        if (!$siteId)
            return;

        $site = Site::where('id_site', $siteId)->first();
        if (!$site)
            return;

        // Cek apakah sudah ada downtime yang sedang berjalan untuk site ini
        $activeDowntime = DowntimeLog::where('id_site', $siteId)
            ->whereNull('recovered_at')
            ->first();

        // Jika tidak ada downtime aktif, buat yang baru
        if (!$activeDowntime) {
            DowntimeLog::create([
                'id_site' => $siteId,
                'ip_address' => $ip,
                'projek' => $site->projek,
                'status' => $status,
                'down_at' => Carbon::now(),
                'recovered_at' => null,
                'alert_sent' => false
            ]);
        }
    }

    /**
     * Log recovery event
     */
    private function logRecovery($siteId, $ip)
    {
        $activeDowntime = DowntimeLog::where('id_site', $siteId)
            ->whereNull('recovered_at')
            ->first();

        if ($activeDowntime) {
            $durationMinutes = $activeDowntime->down_at->diffInMinutes(Carbon::now());

            $activeDowntime->update([
                'recovered_at' => Carbon::now(),
                'durasi_menit' => $durationMinutes
            ]);
        }
    }

    /**
     * Get downtime logs untuk satu site
     */
    public function getDowntimeLogs(Request $request, $id_site)
    {
        $logs = DowntimeLog::where('id_site', $id_site)
            ->orderBy('down_at', 'desc')
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'projek' => $log->projek,
                    'ip_address' => $log->ip_address,
                    'status' => $log->status,
                    'down_at' => $log->down_at->format('d-m-Y H:i:s'),
                    'recovered_at' => $log->recovered_at ? $log->recovered_at->format('d-m-Y H:i:s') : 'Belum Recover',
                    'durasi_menit' => $log->durasi_menit ?? '-'
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $logs
        ]);
    }

    /**
     * Download downtime logs sebagai CSV
     */
    public function downloadDowntimeLogs(Request $request)
    {
        $request->validate([
            'site_id' => 'nullable|exists:site,id_site',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $query = DowntimeLog::query();

        if ($request->has('site_id') && $request->site_id) {
            $query->where('id_site', $request->site_id);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->where('down_at', '>=', $request->start_date . ' 00:00:00');
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->where('down_at', '<=', $request->end_date . ' 23:59:59');
        }

        $logs = $query->orderBy('down_at', 'desc')->get();

        // Generate CSV
        $fileName = 'downtime_logs_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0"
        );

        $columns = array('ID', 'Project', 'IP Address', 'Status', 'Down At', 'Recovered At', 'Duration (Minutes)');

        $callback = function () use ($logs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($logs as $log) {
                fputcsv($file, array(
                    $log->id,
                    $log->projek,
                    $log->ip_address,
                    $log->status,
                    $log->down_at->format('d-m-Y H:i:s'),
                    $log->recovered_at ? $log->recovered_at->format('d-m-Y H:i:s') : 'Belum Recover',
                    $log->durasi_menit ?? '-'
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
