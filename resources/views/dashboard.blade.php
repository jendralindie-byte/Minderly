<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Minderly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white flex flex-col">
            <div class="p-6 flex items-center justify-center border-b border-indigo-800">
                <i class="fas fa-check-double text-2xl mr-2 text-indigo-400"></i>
                <span class="text-2xl font-bold tracking-wider">Minderly</span>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="/dashboard" class="flex items-center px-4 py-3 bg-indigo-800 rounded-lg transition">
                    <i class="fas fa-chart-pie w-6"></i>
                    <span>Dashboard</span>
                </a>
                <a href="/tugas" class="flex items-center px-4 py-3 hover:bg-indigo-800 rounded-lg transition">
                    <i class="fas fa-tasks w-6"></i>
                    <span>Tugas Saya</span>
                </a>
            </nav>
        </aside>

  
        <main class="flex-1 flex flex-col h-screen overflow-y-auto">
            
            <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-slate-800">Ringkasan Aktivitas</h1>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold mr-2">
                            R
                        </div>
                        <span class="font-medium text-sm">Radiyta</span>
                    </div>
                </div>
            </header>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 flex items-center">
                        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-xl mr-4">
                            <i class="fas fa-list"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Total Tugas</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $totalTugas }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 flex items-center">
                        <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-xl mr-4">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Dalam Proses</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $dalamProses }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 flex items-center">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl mr-4">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Selesai</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $selesai }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-red-100 flex items-center relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-2 h-full bg-red-500"></div>
                        <div class="w-12 h-12 rounded-full bg-red-50 text-red-500 flex items-center justify-center text-xl mr-4">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Lewat Tenggat</p>
                            <p class="text-2xl font-bold text-red-600">{{ $lewatTenggat }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-1">
                        <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-xl p-6 shadow-sm border border-red-100 h-full">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-clock text-red-500 text-xl mr-2"></i>
                                <h2 class="text-lg font-bold text-slate-800">Reminder Deadline!</h2>
                            </div>
                            
                            <div class="space-y-3">
                                @forelse($reminders as $tugas)
                                    @php
                                        $hariIni = \Carbon\Carbon::today();
                                        $tglDeadline = \Carbon\Carbon::parse($tugas->deadline);
                                        $selisihHari = $hariIni->diffInDays($tglDeadline, false);
                                        
                                        $warnaBorder = $selisihHari == 0 ? 'border-red-500' : 'border-orange-500';
                                        $warnaLabel = $selisihHari == 0 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700';
                                        $teksLabel = $selisihHari == 0 ? 'Hari Ini' : $selisihHari . ' Hari Lagi';
                                    @endphp
                                    <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 {{ $warnaBorder }} flex justify-between items-center">
                                        <div>
                                            <h3 class="font-semibold text-slate-800 text-sm">{{ $tugas->judul }}</h3>
                                            <p class="text-xs text-slate-500 mt-1">{{ $tglDeadline->format('d M Y') }}</p>
                                        </div>
                                        <span class="text-xs font-bold px-2 py-1 rounded {{ $warnaLabel }}">{{ $teksLabel }}</span>
                                    </div>
                                @empty
                                    <p class="text-sm text-slate-500">Belum ada tugas yang mendekati deadline.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-100 h-full">
                            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                                <h2 class="text-lg font-bold text-slate-800">Daftar Tugas Anda</h2>
                                <a href="/tugas" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Kelola Semua</a>
                            </div>
                            <div class="p-6">
                                <ul class="divide-y divide-slate-100">
                                    @forelse($tugasAktif as $tugas)
                                        <li class="py-3 flex justify-between items-center">
                                            <div class="flex items-center">
                                                <input type="checkbox" {{ $tugas->status == 'Selesai' ? 'checked' : '' }} disabled class="w-4 h-4 text-indigo-600 rounded border-gray-300 mr-4">
                                                <span class="{{ $tugas->status == 'Selesai' ? 'text-slate-400 line-through' : 'text-slate-700' }} font-medium">
                                                    {{ $tugas->judul }}
                                                </span>
                                            </div>
                                            <span class="text-xs px-2 py-1 rounded 
                                                {{ $tugas->status == 'Selesai' ? 'bg-emerald-100 text-emerald-700' : ($tugas->status == 'Sedang Dikerjakan' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                                {{ $tugas->status }}
                                            </span>
                                        </li>
                                    @empty
                                        <p class="text-sm text-slate-500">Belum ada tugas yang ditambahkan.</p>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>
</html>