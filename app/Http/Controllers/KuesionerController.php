<?php

namespace App\Http\Controllers;

use App\Models\ProfilPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuesionerController extends Controller
{
    private function pertanyaan(): array
    {
        return [
            'Kemampuan dan Keterampilan' => [
                'riset' => 'Seberapa baik kemampuanmu dalam mencari informasi dan melakukan riset?',
                'menulis' => 'Seberapa baik kemampuanmu dalam menulis laporan, makalah, atau merangkum materi?',
                'desain' => 'Seberapa baik kemampuanmu dalam membuat desain atau karya kreatif?',
                'presentasi' => 'Seberapa baik kemampuanmu dalam menyampaikan ide dan melakukan presentasi?',
                'analisis' => 'Seberapa baik kemampuanmu dalam menganalisis data dan memecahkan masalah?',
                'perencanaan' => 'Seberapa baik kemampuanmu dalam merencanakan pekerjaan dan mengatur jadwal?',
                'ketelitian' => 'Seberapa teliti kamu dalam memeriksa hasil pekerjaan dan menemukan kesalahan?',
            ],
            'Gaya Kerja dan Tanggung Jawab' => [
                'kolaborasi' => 'Seberapa nyaman kamu bekerja sama dan berdiskusi dengan anggota kelompok?',
                'disiplin_deadline' => 'Seberapa konsisten kamu menyelesaikan tugas sesuai tenggat waktu?',
                'mandiri' => 'Seberapa mampu kamu menyelesaikan tugas secara mandiri tanpa banyak arahan?',
            ],
            'Ketersediaan dan Beban Kerja' => [
                'waktu_tersedia' => 'Seberapa banyak waktu yang bisa kamu sediakan untuk mengerjakan proyek kelompok?',
                'beban_kerja' => 'Seberapa besar beban tugas dan kegiatan lain yang sedang kamu miliki?',
            ],
        ];
    }

    public function create()
    {
        $pengguna = Auth::user();

        $profil = ProfilPengguna::where(
            'id_pengguna',
            $pengguna->id_pengguna
        )->first();

        return view('Auth.kuesioner', [
            'pertanyaan' => $this->pertanyaan(),
            'profil' => $profil,
        ]);
    }

    public function store(Request $request)
    {
        $aturan = [];

        foreach ($this->pertanyaan() as $kelompok) {
            foreach (array_keys($kelompok) as $field) {
                $aturan[$field] = ['required', 'integer', 'between:1,5'];
            }
        }

        $data = $request->validate($aturan, [
            '*.required' => 'Semua pertanyaan wajib dijawab.',
            '*.integer' => 'Pilih rating yang tersedia.',
            '*.between' => 'Rating harus antara 1 sampai 5.',
        ]);

        ProfilPengguna::updateOrCreate(
            [
                'id_pengguna' => Auth::user()->id_pengguna,
            ],
            $data
        );

        return redirect()->route('dashboard')
            ->with('success', 'Kuesioner berhasil disimpan. Selamat datang di Minderly!');
    }
}
