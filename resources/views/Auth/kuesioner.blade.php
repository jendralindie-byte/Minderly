@extends('layouts.kuesioner')

@section('title', 'Kuesioner Profil - Minderly')
@section('header', 'Kuesioner Profil')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Kenali Gaya Kerjamu
        </h1>
        <p class="text-sm text-gray-500 mt-2">
            Jawabanmu akan digunakan untuk membantu pembagian tugas kelompok
            berdasarkan kemampuan, tanggung jawab, dan ketersediaan waktu.
        </p>
    </div>

    <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">
        <p class="font-semibold text-blue-900">Petunjuk pengisian</p>
        <p class="mt-1 text-sm text-blue-800">
            Pilih satu rating untuk setiap pertanyaan.
        </p>
        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-blue-900">
            <p>1 = Sangat rendah</p>
            <p>2 = Rendah</p>
            <p>3 = Sedang</p>
            <p>4 = Tinggi</p>
            <p>5 = Sangat tinggi</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-semibold">Periksa kembali jawabanmu.</p>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kuesioner.store') }}" method="POST"
          class="space-y-6">
        @csrf

        @php
            $nomor = 0;
        @endphp

        @foreach ($pertanyaan as $kategori => $daftarPertanyaan)
            <section class="quiz-card overflow-hidden">

                <div class="border-b border-gray-100 px-5 py-4 sm:px-6">
                    <h2 class="font-bold text-gray-800">
                        {{ $kategori }}
                    </h2>
                </div>

                <div class="space-y-6 p-5 sm:p-6">
                    @foreach ($daftarPertanyaan as $field => $teks)
                        @php
                            $nomor++;
                            $nilaiTersimpan = old(
                                $field,
                                $profil ? $profil->{$field} : null
                            );
                        @endphp

                        <fieldset class="border-b border-gray-100 pb-5 last:border-0 last:pb-0">
                            <legend class="text-sm font-semibold leading-6 text-gray-800">
                                {{ $nomor }}. {{ $teks }}
                            </legend>

                            <div class="mt-4 grid grid-cols-5 gap-2">
                                @for ($rating = 1; $rating <= 5; $rating++)
                                    <label class="cursor-pointer">
                                        <input
                                            type="radio"
                                            name="{{ $field }}"
                                            value="{{ $rating }}"
                                            class="peer sr-only"
                                            required
                                            {{ (string) $nilaiTersimpan === (string) $rating ? 'checked' : '' }}
                                        >

                                        <span class="flex min-h-12 items-center justify-center rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 transition hover:border-blue-400 peer-checked:border-[#064B87] peer-checked:bg-[#064B87] peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-blue-400">
                                            {{ $rating }}
                                        </span>
                                    </label>
                                @endfor
                            </div>

                            <div class="mt-2 flex justify-between text-xs text-gray-400">
                                <span>Sangat rendah</span>
                                <span>Sangat tinggi</span>
                            </div>
                        </fieldset>
                    @endforeach
                </div>
            </section>
        @endforeach

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            @if ($profil)
                <a href="{{ route('dashboard') }}"
                   class="inline-flex justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                    Kembali ke Dashboard
                </a>
            @endif

            <button type="submit"
                    class="inline-flex justify-center rounded-xl bg-[#064B87] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800">
                {{ $profil ? 'Perbarui Jawaban' : 'Simpan dan Lanjutkan' }}
            </button>
        </div>

    </form>
</div>
@endsection
