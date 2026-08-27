<aside class="w-64 bg-slate-900 text-white min-h-screen shadow-lg">

    <div class="p-6 border-b border-slate-700">

        <h1 class="text-2xl font-bold">
            🎓 SIKAP
        </h1>

        <p class="text-slate-300">
            SMPN 2 JATIROTO
        </p>

    </div>

    <nav class="p-4">

        <a
            href="{{ route('dashboard') }}"
            class="block px-4 py-3 rounded hover:bg-slate-700
            {{ request()->routeIs('dashboard') ? 'bg-slate-700' : '' }}"
        >
            📊 Dashboard
        </a>


        <div class="mt-6 text-xs uppercase text-slate-400 tracking-wider">
            MASTER DATA
        </div>

        <a
            href="{{ route('guru.index') }}"
            class="block px-4 py-2 hover:bg-slate-700 rounded
            {{ request()->routeIs('guru.*') ? 'bg-slate-700' : '' }}"
        >
            👨‍🏫 Guru
        </a>

        <a
            href="{{ route('siswa.index') }}"
            class="block px-4 py-2 hover:bg-slate-700 rounded
            {{ request()->routeIs('siswa.*') ? 'bg-slate-700' : '' }}"
        >
            👨‍🎓 Siswa
        </a>

        <a
            href="{{ route('kelas.index') }}"
            class="block px-4 py-2 hover:bg-slate-700 rounded
            {{ request()->routeIs('kelas.*') ? 'bg-slate-700' : '' }}"
        >
            🏫 Kelas
        </a>

        <a
            href="{{ route('mata-pelajaran.index') }}"
            class="block px-4 py-2 hover:bg-slate-700 rounded
            {{ request()->routeIs('mata-pelajaran.*') ? 'bg-slate-700' : '' }}"
        >
            📚 Mata Pelajaran
        </a>

        <a
            href="{{ route('tahun-ajaran.index') }}"
            class="block px-4 py-2 hover:bg-slate-700 rounded
            {{ request()->routeIs('tahun-ajaran.*') ? 'bg-slate-700' : '' }}"
        >
            📅 Tahun Ajaran
        </a>

        <a
            href="{{ route('user.index') }}"
            class="block px-4 py-2 hover:bg-slate-700 rounded
            {{ request()->routeIs('user.*') ? 'bg-slate-700' : '' }}"
        >
            👤 User
        </a>


        <div class="mt-6 text-xs uppercase text-slate-400 tracking-wider">
            AKADEMIK
        </div>

        <a
            href="{{ route('template-jadwal.index') }}"
            class="block px-4 py-2 hover:bg-slate-700 rounded
            {{ request()->routeIs('template-jadwal.*') ? 'bg-slate-700' : '' }}"
        >
            📅 Template Jadwal
        </a>

        <a
            href="{{ route('guru-mengajar.index') }}"
            class="block px-4 py-2 hover:bg-slate-700 rounded
            {{ request()->routeIs('guru-mengajar.*') ? 'bg-slate-700' : '' }}"
        >
            👨‍🏫 Penugasan Guru
        </a>

        <a
            href="{{ route('jadwal-mengajar.index') }}"
            class="block px-4 py-2 hover:bg-slate-700 rounded
            {{ request()->routeIs('jadwal-mengajar.*') ? 'bg-slate-700' : '' }}"
        >
            🗓 Jadwal Mengajar
        </a>

        <a href="{{ route('modul-ajar.index') }}"
        class="block px-4 py-2 hover:bg-slate-700 rounded">
            📚 Modul Ajar
        </a>

        <a href="{{ route('kehadiran.input') }}"
        class="block px-4 py-2 hover:bg-slate-700 rounded">
            ✅ Kehadiran
        </a>

        <a href="{{ route('jurnal-mengajar.index') }}"
        class="block px-4 py-2 hover:bg-slate-700 rounded
        {{ request()->routeIs('jurnal-mengajar.*') ? 'bg-slate-700 text-white' : '' }}">
            📖 Jurnal Mengajar
        </a>

        <a href="{{ route('penilaian-akademik.index') }}"
        class="block px-4 py-2 hover:bg-slate-700 rounded
        {{ request()->routeIs('penilaian-akademik.*') ? 'bg-slate-700 text-white' : '' }}">
            📝 Penilaian
        </a>


        <div class="mt-6 text-xs uppercase text-slate-400 tracking-wider">
            IMPORT DATA
        </div>

        <a
            href="{{ route('import.index') }}"
            class="block px-4 py-2 hover:bg-slate-700 rounded
            {{ request()->routeIs('import.*') ? 'bg-slate-700' : '' }}"
        >
            📦 Import Data
        </a>


        <div class="mt-6 text-xs uppercase text-slate-400 tracking-wider">
            LAPORAN
        </div>

        <a
            href="#"
            class="block px-4 py-2 hover:bg-slate-700 rounded"
        >
            📊 Rekap
        </a>


        <div class="mt-8 border-t border-slate-700 pt-5">

            <a
                href="#"
                class="flex items-center justify-center gap-2
                bg-gradient-to-r from-blue-600 to-cyan-500
                hover:from-cyan-500 hover:to-blue-600
                text-white py-3 rounded-xl shadow-lg transition"
            >
                🤖 ESPAI
            </a>

            <p class="text-center text-[11px] text-slate-400 mt-2">
                Asisten AI ESPENERO
            </p>

        </div>

    </nav>

</aside>