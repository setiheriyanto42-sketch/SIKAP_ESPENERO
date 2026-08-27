<aside class="w-64 bg-slate-900 text-white min-h-screen shadow-lg">

    {{-- =========================================================
         IDENTITAS APLIKASI
    ========================================================== --}}
    <div class="p-6 border-b border-slate-700">

        <h1 class="text-2xl font-bold">
            🎓 SIKAP
        </h1>

        <p class="text-slate-300 text-sm">
            SMPN 2 JATIROTO
        </p>

    </div>


    <nav class="p-4">

        {{-- =====================================================
             DASHBOARD
        ====================================================== --}}
        <a href="{{ route('dashboard') }}"
           class="block px-4 py-3 rounded transition
                  hover:bg-slate-700
                  {{ request()->routeIs('dashboard')
                        ? 'bg-slate-700 text-white'
                        : '' }}">

            📊 Dashboard

        </a>


        {{-- =====================================================
             PEMBELAJARAN
        ====================================================== --}}
        <div class="mt-6 text-xs uppercase text-slate-400 tracking-wider">
            PEMBELAJARAN
        </div>


        {{-- JADWAL HARI INI --}}
        <a href="{{ route('dashboard') }}"
           class="block px-4 py-2 rounded transition
                  hover:bg-slate-700">

            📅 Jadwal Hari Ini

        </a>


        {{-- MULAI MENGAJAR --}}
                <a href="{{ route('dashboard') }}"
        class="block px-4 py-2 rounded hover:bg-slate-700
        {{ request()->routeIs('mengajar.*') ? 'bg-slate-700 text-white' : '' }}">

            🚀 Mulai Mengajar

        </a>


        {{-- MODUL AJAR --}}
        <a href="{{ route('modul-ajar.index') }}"
        class="block px-4 py-2 rounded hover:bg-slate-700
        {{ request()->routeIs('modul-ajar.*') ? 'bg-slate-700 text-white' : '' }}">

            📚 Modul Ajar / RPP

        </a>


        {{-- JURNAL MENGAJAR --}}
        <a href="{{ route('jurnal-mengajar.index') }}"
        class="block px-4 py-2 rounded hover:bg-slate-700
        {{ request()->routeIs('jurnal-mengajar.*') ? 'bg-slate-700 text-white' : '' }}">

            📖 Jurnal Mengajar

        </a>


        {{-- PENILAIAN --}}
        <a href="{{ route('penilaian-akademik.index') }}"
        class="block px-4 py-2 rounded hover:bg-slate-700
        {{ request()->routeIs('penilaian-akademik.*') ? 'bg-slate-700 text-white' : '' }}">

            📝 Penilaian

        </a>


        {{-- PENILAIAN SIKAP --}}
        <a href="#"
           class="block px-4 py-2 rounded transition
                  hover:bg-slate-700">

            ⭐ Sikap

        </a>


        {{-- =====================================================
             WALI KELAS
        ====================================================== --}}

        @if(isset($data['isWaliKelas']) && $data['isWaliKelas'])

            <div class="mt-6 text-xs uppercase text-slate-400 tracking-wider">
                WALI KELAS
            </div>


            <a href="#"
               class="block px-4 py-2 rounded transition
                      hover:bg-slate-700">

                👨‍🎓 Data Kelas

            </a>


            <a href="#"
               class="block px-4 py-2 rounded transition
                      hover:bg-slate-700">

                📋 Absensi Kelas

            </a>


            <a href="#"
               class="block px-4 py-2 rounded transition
                      hover:bg-slate-700">

                📈 Rekap Kehadiran

            </a>


            <a href="#"
               class="block px-4 py-2 rounded transition
                      hover:bg-slate-700">

                📄 Laporan Wali

            </a>

        @endif


        {{-- =====================================================
             LAPORAN GURU
        ====================================================== --}}
        <div class="mt-6 text-xs uppercase text-slate-400 tracking-wider">
            LAPORAN
        </div>


        <a href="#"
           class="block px-4 py-2 rounded transition
                  hover:bg-slate-700">

            📊 Rekap Pembelajaran

        </a>


        {{-- =====================================================
             ESPAI
        ====================================================== --}}
        <div class="mt-8 border-t border-slate-700 pt-5">

            <a href="#"
               class="flex items-center justify-center gap-2
                      bg-gradient-to-r from-blue-600 to-cyan-500
                      hover:from-cyan-500 hover:to-blue-600
                      text-white py-3 rounded-xl shadow-lg transition">

                🤖 ESPAI

            </a>

            <p class="text-center text-[11px] text-slate-400 mt-2">
                Asisten AI ESPENERO
            </p>

        </div>

    </nav>

</aside>