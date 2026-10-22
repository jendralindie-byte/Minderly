@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- HEADER HALAMAN -->
    <div class="flex items-center gap-3">
        <a href="/tugas"
           class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-600 hover:text-blue-700 hover:bg-blue-50 transition"
           title="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
            </svg>
        </a>

        <div>
            <h1 class="text-2xl font-bold text-gray-800">Buat Tugas Baru</h1>
            <p class="text-sm text-gray-500 mt-1">
                Tambahkan tugas baru dan tentukan tingkat prioritasnya.
            </p>
        </div>
    </div>

    <!-- INFORMASI -->
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
        <div class="w-9 h-9 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                      d="M12 16v-4m0-4h.01M22 12a10 10 0 11-20 0 10 10 0 0120 0z"/>
            </svg>
        </div>

        <div>
            <p class="text-sm font-semibold text-blue-900">Informasi Tugas</p>
            <p class="text-sm text-blue-800 mt-1">
                Lengkapi informasi tugas dengan benar. Deadline, tingkat kesulitan,
                dan dampak akan digunakan untuk menentukan skor prioritas tugas.
            </p>
        </div>
    </div>

    <!-- PESAN ERROR -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
            <div class="flex items-center gap-2 font-semibold mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v4m0 4h.01M10.3 3.8 2.7 17a2 2 0 001.7 3h15.2a2 2 0 001.7 3L13.7 3.8a2 2 0 00-3.4 0z"/>
                </svg>
                Periksa kembali data yang dimasukkan
            </div>

            <ul class="list-disc pl-6 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM TAMBAH TUGAS -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">Detail Tugas</h2>
            <p class="text-sm text-gray-500 mt-1">
                Masukkan informasi tugas yang ingin ditambahkan.
            </p>
        </div>

        <form action="/tugas/simpan" method="POST">
            @csrf

            <div class="p-6 space-y-5">

                <!-- JUDUL TUGAS -->
                <div>
                    <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Tugas <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        id="judul"
                        name="judul"
                        value="{{ old('judul') }}"
                        placeholder="Contoh: Membuat laporan proyek akhir"
                        required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('judul') border-red-400 @enderror"
                    >

                    @error('judul')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Tugas
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="4"
                        placeholder="Jelaskan detail tugas, tujuan, atau hal yang perlu dikerjakan..."
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition resize-y @error('deskripsi') border-red-400 @enderror"
                    >{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- KATEGORI -->
                <div>
                    <label for="id_kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori Tugas <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="id_kategori"
                        name="id_kategori"
                        required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('id_kategori') border-red-400 @enderror"
                    >
                        <option value="">Pilih kategori</option>

                        @foreach($kategori as $item)
                            <option
                                value="{{ $item->id_kategori }}"
                                {{ old('id_kategori') == $item->id_kategori ? 'selected' : '' }}
                            >
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    @error('id_kategori')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PENANGGUNG JAWAB -->
                <div id="penanggung-jawab-wrapper" class="hidden">
                    <label for="penanggung_jawab" class="block text-sm font-semibold text-gray-700 mb-2">
                        Penanggung Jawab
                    </label>

                    <input
                        type="text"
                        id="penanggung_jawab"
                        name="penanggung_jawab"
                        value="{{ old('penanggung_jawab') }}"
                        placeholder="Contoh: Annas Putra"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('penanggung_jawab') border-red-400 @enderror"
                    >

                    <p class="text-xs text-gray-400 mt-1">
                        Isi nama anggota yang menjadi penanggung jawab tugas kelompok.
                    </p>

                    @error('penanggung_jawab')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- DEADLINE -->
                <div>
                    <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deadline <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        id="deadline"
                        name="deadline"
                        value="{{ old('deadline') }}"
                        required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('deadline') border-red-400 @enderror"
                    >

                    @error('deadline')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PRIORITAS -->
                <div class="border-t border-gray-100 pt-5">
                    <h3 class="text-sm font-bold text-gray-800 mb-1">
                        Pengaturan Prioritas
                    </h3>

                    <p class="text-sm text-gray-500 mb-4">
                        Tentukan tingkat kesulitan dan dampak dari tugas.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <!-- KESULITAN -->
                        <div>
                            <label for="tingkat_kesulitan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tingkat Kesulitan <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="tingkat_kesulitan"
                                name="tingkat_kesulitan"
                                required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('tingkat_kesulitan') border-red-400 @enderror"
                            >
                                <option value="1" {{ old('tingkat_kesulitan', '1') == '1' ? 'selected' : '' }}>
                                    1 - Mudah
                                </option>

                                <option value="2" {{ old('tingkat_kesulitan') == '2' ? 'selected' : '' }}>
                                    2 - Cukup Mudah
                                </option>

                                <option value="3" {{ old('tingkat_kesulitan') == '3' ? 'selected' : '' }}>
                                    3 - Sedang
                                </option>

                                <option value="4" {{ old('tingkat_kesulitan') == '4' ? 'selected' : '' }}>
                                    4 - Sulit
                                </option>

                                <option value="5" {{ old('tingkat_kesulitan') == '5' ? 'selected' : '' }}>
                                    5 - Sangat Sulit
                                </option>
                            </select>

                            @error('tingkat_kesulitan')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DAMPAK -->
                        <div>
                            <label for="dampak" class="block text-sm font-semibold text-gray-700 mb-2">
                                Dampak Tugas <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="dampak"
                                name="dampak"
                                required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('dampak') border-red-400 @enderror"
                            >
                                <option value="1" {{ old('dampak', '1') == '1' ? 'selected' : '' }}>
                                    1 - Rendah
                                </option>

                                <option value="5" {{ old('dampak') == '5' ? 'selected' : '' }}>
                                    5 - Sedang
                                </option>

                                <option value="10" {{ old('dampak') == '10' ? 'selected' : '' }}>
                                    10 - Tinggi
                                </option>
                            </select>

                            @error('dampak')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <!-- TOMBOL -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                <a
                    href="/tugas"
                    class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-gray-300 bg-white text-gray-600 text-sm font-medium hover:bg-gray-100 transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 bg-[#064B87] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Tugas
                </button>

            </div>
        </form>
    </div>
</div>

<!-- SCRIPT KATEGORI -->
<script>
    const kategoriSelect = document.getElementById('id_kategori');
    const penanggungWrapper = document.getElementById('penanggung-jawab-wrapper');
    const penanggungInput = document.getElementById('penanggung_jawab');

    function cekKategori() {
        const selectedText = kategoriSelect.options[kategoriSelect.selectedIndex]?.text;

        if (selectedText === 'Kelompok') {
            penanggungWrapper.classList.remove('hidden');
        } else {
            penanggungWrapper.classList.add('hidden');
            penanggungInput.value = '';
        }
    }

    kategoriSelect.addEventListener('change', cekKategori);

    cekKategori();
</script>
@endsection