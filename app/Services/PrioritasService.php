<?php

namespace App\Services;

use Carbon\Carbon;

class PrioritasService
{
    public function hitung($deadline, $kesulitan, $dampak)
    {
        $hariIni = Carbon::today();
        $tanggalDeadline = Carbon::parse($deadline)->startOfDay();

        // Selisih bertanda: negatif berarti deadline sudah lewat.
        $hariTersisa = $hariIni->diffInDays($tanggalDeadline, false);

        // Skor urgensi deadline.
        if ($hariTersisa <= 1) {
            $deadlineScore = 100;
        } elseif ($hariTersisa <= 3) {
            $deadlineScore = 90;
        } elseif ($hariTersisa <= 7) {
            $deadlineScore = 80;
        } elseif ($hariTersisa <= 14) {
            $deadlineScore = 65;
        } elseif ($hariTersisa <= 30) {
            $deadlineScore = 50;
        } else {
            $deadlineScore = 30;
        }

        // Bobot: deadline 60%, kesulitan 20%, dampak 20%.
        $skor =
            ($deadlineScore * 0.6)
            + (($kesulitan / 5) * 100 * 0.2)
            + (($dampak / 10) * 100 * 0.2);

        return round($skor, 2);
    }
}
