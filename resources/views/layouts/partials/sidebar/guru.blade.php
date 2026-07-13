<aside class="w-64 bg-slate-900 text-Grey min-h-screen shadow-lg">

    <div class="p-6 border-b border-slate-700">

        <h1 class="text-2xl font-bold">
            🎓 SIKAP
        </h1>

        <p class="text-slate-300 text-sm">
            ESPENERO
        </p>

    </div>

    <nav class="p-4">

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
           class="block px-4 py-3 rounded hover:bg-slate-700">

            📊 Dashboard

        </a>

        <div class="mt-6 text-xs uppercase text-slate-400">

            PEMBELAJARAN

        </div>

        <a href="{{ route('dashboard') }}"
           class="block px-4 py-2 rounded hover:bg-slate-700">

            📅 Jadwal Hari Ini

        </a>

        <a href="{{ route('dashboard') }}"
           class="block px-4 py-2 rounded hover:bg-slate-700">

            🚀 Mulai Mengajar

        </a>

        <a href="#"
           class="block px-4 py-2 rounded hover:bg-slate-700">

            📝 Penilaian

        </a>

        <a href="#"
           class="block px-4 py-2 rounded hover:bg-slate-700">

            ⭐ Sikap

        </a>

        @if(isset($data['isWaliKelas']) && $data['isWaliKelas'])

            <div class="mt-6 text-xs uppercase text-slate-400">

                WALI KELAS

            </div>

            <a href="#"
               class="block px-4 py-2 rounded hover:bg-slate-700">

                👨‍🎓 Data Kelas

            </a>

            <a href="#"
               class="block px-4 py-2 rounded hover:bg-slate-700">

                📋 Absensi Kelas

            </a>

            <a href="#"
               class="block px-4 py-2 rounded hover:bg-slate-700">

                📈 Rekap Kehadiran

            </a>

            <a href="#"
               class="block px-4 py-2 rounded hover:bg-slate-700">

                📄 Laporan Wali

            </a>

        @endif

    </nav>

</aside>
