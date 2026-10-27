<?php

namespace App\Http\Controllers;

use App\Models\Tugas;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = today();
        $batasNotifikasi = $hariIni->copy()->addDays(3);

        // ==========================================
        // STATISTIK UTAMA
        // Mengikuti aturan TugasController
        // ==========================================

        // Semua tugas, termasuk tugas yang selesai.
        $totalTugas = Tugas::count();

        // Jumlah tugas berdasarkan status sebenarnya.
        $belumMulai = Tugas::where('status', 'Belum Mulai')->count();

        $dalamProses = Tugas::where(
            'status',
            'Sedang Dikerjakan'
        )->count();

        $selesai = Tugas::where('status', 'Selesai')->count();

        // Tugas aktif = belum mulai + sedang dikerjakan.
        $tugasAktifCount = Tugas::whereIn('status', [
            'Belum Mulai',
            'Sedang Dikerjakan',
        ])->count();

        // Tugas terlambat: belum selesai dan deadline lewat.
        $lewatTenggat = Tugas::where('status', '!=', 'Selesai')
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', $hariIni)
            ->count();

        // Prioritas tinggi:
        // skor >= 80 ATAU deadline lewat,
        // selama tugas belum selesai.
        $prioritasTinggi = Tugas::where('status', '!=', 'Selesai')
            ->where(function ($query) use ($hariIni) {
                $query->where('skor_prioritas', '>=', 80)
                    ->orWhere(function ($sub) use ($hariIni) {
                        $sub->whereNotNull('deadline')
                            ->whereDate('deadline', '<', $hariIni);
                    });
            })
            ->count();

        // ==========================================
        // DISTRIBUSI PRIORITAS
        // ==========================================

        $jumlahPrioritasTinggi = Tugas::whereNotNull('skor_prioritas')
            ->where('skor_prioritas', '>=', 80)
            ->count();

        $jumlahPrioritasSedang = Tugas::where('skor_prioritas', '>=', 50)
            ->where('skor_prioritas', '<', 80)
            ->count();

        $jumlahPrioritasRendah = Tugas::whereNotNull('skor_prioritas')
            ->where('skor_prioritas', '<', 50)
            ->count();

        $jumlahPrioritasBelumDihitung = Tugas::whereNull(
            'skor_prioritas'
        )->count();

        // ==========================================
        // DATA DIAGRAM STATUS
        // ==========================================

        $diagramStatus = [
            'labels' => [
                'Belum Mulai',
                'Sedang Dikerjakan',
                'Selesai',
            ],
            'data' => [
                $belumMulai,
                $dalamProses,
                $selesai,
            ],
        ];

        $diagramPrioritas = [
            'labels' => [
                'Tinggi',
                'Sedang',
                'Rendah',
                'Belum dihitung',
            ],
            'data' => [
                $jumlahPrioritasTinggi,
                $jumlahPrioritasSedang,
                $jumlahPrioritasRendah,
                $jumlahPrioritasBelumDihitung,
            ],
        ];

        // ==========================================
        // PENGINGAT DEADLINE 7 HARI KE DEPAN
        // ==========================================

        $reminders = Tugas::whereIn('status', [
            'Belum Mulai',
            'Sedang Dikerjakan',
        ])
            ->whereNotNull('deadline')
            ->whereDate('deadline', '>=', $hariIni)
            ->whereDate(
                'deadline',
                '<=',
                $hariIni->copy()->addDays(7)
            )
            ->orderBy('deadline')
            ->orderByDesc('skor_prioritas')
            ->limit(5)
            ->get();

        // ==========================================
        // NOTIFIKASI TUGAS
        // ==========================================

        $notifikasiQuery = Tugas::whereIn('status', [
            'Belum Mulai',
            'Sedang Dikerjakan',
        ])->where(function ($query) use (
            $hariIni,
            $batasNotifikasi
        ) {
            $query->where(function ($deadlineQuery) use (
                $hariIni,
                $batasNotifikasi
            ) {
                $deadlineQuery->whereNotNull('deadline')
                    ->whereDate('deadline', '<=', $batasNotifikasi);
            })->orWhere('skor_prioritas', '>=', 80);
        });

        $jumlahNotifikasi = (clone $notifikasiQuery)->count();

        $notifikasi = $notifikasiQuery
            ->orderByRaw(
                'CASE
                    WHEN deadline IS NOT NULL AND deadline < ? THEN 3
                    WHEN deadline = ? THEN 2
                    WHEN deadline IS NOT NULL AND deadline <= ? THEN 1
                    ELSE 0
                END DESC',
                [
                    $hariIni->toDateString(),
                    $hariIni->toDateString(),
                    $batasNotifikasi->toDateString(),
                ]
            )
            ->orderByDesc('skor_prioritas')
            ->orderBy('deadline')
            ->limit(5)
            ->get();

        // ==========================================
        // DAFTAR TUGAS AKTIF
        // ==========================================

        $tugasAktif = Tugas::whereIn('status', [
            'Belum Mulai',
            'Sedang Dikerjakan',
        ])
            ->orderByRaw(
                "CASE
                    WHEN deadline IS NOT NULL
                    AND deadline < ?
                    THEN 1 ELSE 0
                END DESC",
                [$hariIni->toDateString()]
            )
            ->orderByDesc('skor_prioritas')
            ->orderBy('deadline')
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'totalTugas',
            'belumMulai',
            'dalamProses',
            'selesai',
            'tugasAktifCount',
            'lewatTenggat',
            'prioritasTinggi',
            'diagramStatus',
            'diagramPrioritas',
            'reminders',
            'notifikasi',
            'jumlahNotifikasi',
            'tugasAktif'
        ));
    }
}
