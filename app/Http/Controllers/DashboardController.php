<?php

namespace App\Http\Controllers;

use App\Models\Tugas;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = today();
        $batasNotifikasi = $hariIni->copy()->addDays(3);

        $totalTugas = Tugas::count();
        $dalamProses = Tugas::where('status', 'Sedang Dikerjakan')->count();
        $selesai = Tugas::where('status', 'Selesai')->count();
        $belumMulai = Tugas::where('status', 'Belum Mulai')->count();
        $lewatTenggat = Tugas::where('status', '!=', 'Selesai')
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', $hariIni)
            ->count();

        $jumlahPrioritasTinggi = Tugas::whereNotNull('skor_prioritas')
            ->where('skor_prioritas', '>=', 80)
            ->count();
        $jumlahPrioritasSedang = Tugas::where('skor_prioritas', '>=', 50)
            ->where('skor_prioritas', '<', 80)
            ->count();
        $jumlahPrioritasRendah = Tugas::whereNotNull('skor_prioritas')
            ->where('skor_prioritas', '<', 50)
            ->count();
        $jumlahPrioritasBelumDihitung = Tugas::whereNull('skor_prioritas')->count();

        $diagramStatus = [
            'labels' => ['Belum Mulai', 'Sedang Dikerjakan', 'Selesai'],
            'data' => [$belumMulai, $dalamProses, $selesai],
        ];
        $diagramPrioritas = [
            'labels' => ['Tinggi', 'Sedang', 'Rendah', 'Belum dihitung'],
            'data' => [
                $jumlahPrioritasTinggi,
                $jumlahPrioritasSedang,
                $jumlahPrioritasRendah,
                $jumlahPrioritasBelumDihitung,
            ],
        ];

        $reminders = Tugas::where('status', '!=', 'Selesai')
            ->whereNotNull('deadline')
            ->whereDate('deadline', '>=', $hariIni)
            ->whereDate('deadline', '<=', $hariIni->copy()->addDays(7))
            ->orderBy('deadline')
            ->orderByDesc('skor_prioritas')
            ->limit(5)
            ->get();

        $notifikasiQuery = Tugas::whereIn('status', [
            'Belum Mulai',
            'Sedang Dikerjakan',
        ])->where(function ($query) use ($hariIni, $batasNotifikasi) {
            $query->where(function ($deadlineQuery) use ($hariIni, $batasNotifikasi) {
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

        $tugasAktif = Tugas::whereIn('status', [
            'Belum Mulai',
            'Sedang Dikerjakan',
        ])
            ->orderByDesc('skor_prioritas')
            ->orderBy('deadline')
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'totalTugas',
            'belumMulai',
            'dalamProses',
            'selesai',
            'lewatTenggat',
            'diagramStatus',
            'diagramPrioritas',
            'reminders',
            'notifikasi',
            'jumlahNotifikasi',
            'tugasAktif'
        ));
    }
}
