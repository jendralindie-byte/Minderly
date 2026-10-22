@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- JUDUL HALAMAN -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Tugas</h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola, pantau, dan selesaikan semua tugas dengan efektif.
            </p>
        </div>

        <a href="/tugas/tambah" class="inline-flex items-center justify-center gap-2 bg-[#064B87] hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium shadow-sm transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/>
            </svg>
            Buat Tugas Baru
        </a>
    </div>

    <!-- RINGKASAN TUGAS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        <!-- TOTAL -->
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Tugas</p>
                    <h2 class="text-2xl font-bold text-gray-800 mt-2">
                        {{ $tugas->count() }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M9 5h6M9 9h6M9 13h6M5 5h.01M5 9h.01M5 13h.01"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- TUGAS AKTIF -->
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Tugas Aktif</p>
                    <h2 class="text-2xl font-bold text-blue-600 mt-2">
                        {{ $tugas->whereIn('status', ['Belum Mulai', 'Sedang Dikerjakan'])->count() }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- SELESAI -->
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Tugas Selesai</p>
                    <h2 class="text-2xl font-bold text-green-600 mt-2">
                       {{ $tugasSelesai }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-xl bg-green-100 text-green-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- PRIORITAS TINGGI -->
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Prioritas Tinggi</p>
                    <h2 class="text-2xl font-bold text-red-600 mt-2">
                        {{ $tugas->where('skor_prioritas', '>=', 80)->count() }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.8 2.7 17a2 2 0 001.7 3l15.2 0a2 2 0 001.7-3L13.7 3.8a2 2 0 00-3.4 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    
<!-- FILTER STATUS + PENGURUTAN -->
<div class="bg-white border border-gray-100 rounded-xl p-3 shadow-sm">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">

        
<!-- FILTER STATUS -->
<div class="flex flex-wrap items-center gap-2">
    <a href="/tugas"
       class="shrink-0 px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') && !request('terlambat') ? 'bg-[#064B87] text-white' : 'border border-gray-200 text-gray-600 hover:bg-blue-50' }}">
        Belum Selesai
    </a>

    <a href="/tugas?status=aktif"
       class="shrink-0 px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'aktif' ? 'bg-[#064B87] text-white' : 'border border-gray-200 text-gray-600 hover:bg-blue-50' }}">
        Tugas Aktif
    </a>

    <a href="/tugas?status=selesai"
       class="shrink-0 px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'selesai' ? 'bg-[#064B87] text-white' : 'border border-gray-200 text-gray-600 hover:bg-blue-50' }}">
        Tugas Selesai
    </a>

    <a href="/tugas?terlambat=1"
       class="shrink-0 px-4 py-2 rounded-lg text-sm font-medium {{ request('terlambat') === '1' ? 'bg-[#064B87] text-white' : 'border border-gray-200 text-gray-600 hover:bg-blue-50' }}">
        Tugas Terlambat
    </a>
</div>


        <!-- PENGURUTAN -->
        <form action="/tugas" method="GET" class="shrink-0">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            @if(request('terlambat'))
                <input type="hidden" name="terlambat" value="1">
            @endif

            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <select
                name="sort"
                onchange="this.form.submit()"
                class="w-full lg:w-auto min-w-[190px] border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 cursor-pointer"
            >
                <option value="prioritas" {{ request('sort', 'prioritas') == 'prioritas' ? 'selected' : '' }}>
                    Urutkan: Prioritas
                </option>

                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>
                    Urutkan: Terbaru
                </option>

                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>
                    Urutkan: Terlama
                </option>

                <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>
                    Urutkan: Deadline Terdekat
                </option>
            </select>
        </form>

    </div>
</div>

    <!-- TABEL TUGAS -->
    <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">

        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div>
                <h2 class="font-bold text-gray-800">Daftar Tugas</h2>
                <p class="text-xs text-gray-500 mt-1">
                    Daftar tugas berdasarkan prioritas dan status.
                </p>
            </div>

            <span class="text-xs font-medium text-blue-700 bg-blue-50 px-3 py-1.5 rounded-full">
                {{ $totalTugas }} Tugas
            </span>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-5 py-4 font-semibold whitespace-nowrap">Tugas</th>
                        <th class="px-5 py-4 font-semibold whitespace-nowrap">Kategori</th>
                        <th class="px-5 py-4 font-semibold whitespace-nowrap">Deadline</th>
                        <th class="px-5 py-4 font-semibold whitespace-nowrap">Prioritas</th>
                        <th class="px-5 py-4 font-semibold whitespace-nowrap">Status</th>
                        <th class="px-5 py-4 font-semibold text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($tugas as $item)

                    <tr class="hover:bg-blue-50/40 transition">

                        <!-- TUGAS -->
                        <td class="px-5 py-4 min-w-[260px]">
                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M8 4h8l4 4v12H4V4h4zm0 0v5h8V4M8 13h8M8 17h5"/>
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800">
                                        {{ $item->judul }}
                                    </p>

                                    @if($item->deskripsi)
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                            {{ $item->deskripsi }}
                                        </p>
                                    @else
                                        <p class="text-xs text-gray-400 mt-1">
                                            Tidak ada deskripsi
                                        </p>
                                    @endif
                                </div>

                            </div>
                        </td>

                        <!-- KATEGORI -->
                        <td class="px-5 py-4 whitespace-nowrap">

                            @if($item->id_kategori)
                                <span class="inline-flex items-center bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-medium">
                                    {{ $item->kategori->nama_kategori ?? 'Tidak diketahui' }}
                                </span>
                            @else
                                <span class="inline-flex items-center bg-gray-100 text-gray-500 px-3 py-1.5 rounded-lg text-xs font-medium">
                                    Tanpa Kategori
                                </span>
                            @endif

                        </td>

                        <!-- DEADLINE -->
                        <td class="px-5 py-4 whitespace-nowrap">

                            @if($item->deadline)

                                @php
                                    $deadline = \Carbon\Carbon::parse($item->deadline);
                                    $terlambat = $deadline->isPast() && $item->status != 'Selesai';
                                @endphp

                                <p class="font-medium {{ $terlambat ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ $deadline->format('d M Y') }}
                                </p>

                                <p class="text-xs {{ $terlambat ? 'text-red-400' : 'text-gray-400' }} mt-1">
                                    {{ $deadline->translatedFormat('l') }}
                                </p>

                                @if($terlambat)
                                    <span class="text-xs text-red-500 font-medium">
                                        Terlambat
                                    </span>
                                @endif

                            @else

                                <span class="text-gray-400">
                                    Tidak ada deadline
                                </span>

                            @endif

                        </td>

                        <!-- PRIORITAS -->
                        <td class="px-5 py-4 whitespace-nowrap">

                            @if($item->skor_prioritas >= 80)

                                <div class="flex flex-col items-start gap-1">
                                    <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Tinggi
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        Skor: {{ $item->skor_prioritas }}
                                    </span>
                                </div>

                            @elseif($item->skor_prioritas >= 50)

                                <div class="flex flex-col items-start gap-1">
                                    <span class="inline-flex items-center gap-1.5 bg-orange-50 text-orange-600 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                        Sedang
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        Skor: {{ $item->skor_prioritas }}
                                    </span>
                                </div>

                            @else

                                <div class="flex flex-col items-start gap-1">
                                    <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-600 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Rendah
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        Skor: {{ $item->skor_prioritas ?? 0 }}
                                    </span>
                                </div>

                            @endif

                        </td>

                        <!-- STATUS -->
                        <td class="px-5 py-4 whitespace-nowrap">

                            @if($item->status == 'Selesai')

                                <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Selesai
                                </span>

                            @elseif($item->status == 'Sedang Dikerjakan')

                                <span class="inline-flex items-center gap-1.5 bg-orange-50 text-orange-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                    Sedang Dikerjakan
                                </span>

                            @else

                                <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Belum Mulai
                                </span>

                            @endif

                        </td>

                        <!-- AKSI -->
                        <td class="px-5 py-4 whitespace-nowrap">

                            <div class="flex items-center justify-center gap-2">

                                <a
                                    href="/tugas/edit/{{ $item->id_tugas }}"
                                    title="Edit tugas"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="m16 4 4 4M4 20l4-.8L19 8a2.1 2.1 0 00-3-3L5 16l-1 4z"/>
                                    </svg>
                                </a>

                                <form action="/tugas/hapus/{{ $item->id_tugas }}" method="POST" class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Apakah kamu yakin ingin menghapus tugas ini?')"
                                        title="Hapus tugas"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-red-500 hover:bg-red-50 hover:border-red-200 transition"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3"/>
                                        </svg>
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">

                            <div class="flex flex-col items-center">

                                <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M8 4h8l4 4v12H4V4h4zm0 0v5h8V4M8 13h8M8 17h5"/>
                                    </svg>
                                </div>

                                <p class="font-semibold text-gray-700">
                                    Belum ada tugas
                                </p>

                                <p class="text-sm text-gray-500 mt-1">
                                    Tambahkan tugas baru untuk mulai mengelola pekerjaanmu.
                                </p>

                                <a
                                    href="/tugas/tambah"
                                    class="mt-4 text-sm font-semibold text-blue-700 hover:text-blue-900"
                                >
                                    + Buat Tugas Baru
                                </a>

                            </div>

                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

        <!-- FOOTER -->
        <div class="px-5 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-2">

            <p class="text-xs text-gray-500">
                Menampilkan {{ $tugas->count() }} data tugas
            </p>

            <p class="text-xs text-gray-400">
                Minderly Task Management
            </p>

        </div>

    </div>

</div>
@endsection