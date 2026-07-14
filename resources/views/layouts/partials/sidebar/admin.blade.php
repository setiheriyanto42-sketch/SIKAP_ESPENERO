<aside class="w-64 bg-slate-900 text-white min-h-screen shadow-lg">

<div class="p-6 border-b border-slate-700">

<h1 class="text-2xl font-bold">

🎓 SIKAP

</h1>

<p class="text-slate-300">

ESPENERO

</p>

</div>

<nav class="p-4">

<a href="{{ route('dashboard') }}"
class="block px-4 py-3 rounded text-white hover:bg-slate-700 hover:text-white transition">>

📊 Dashboard

</a>

<div class="mt-6 text-xs uppercase text-slate-400">

MASTER DATA

</div>

<a href="{{ route('guru.index') }}" class="block px-4 py-2 hover:bg-slate-700 rounded">

👨‍🏫 Guru

</a>

<a href="{{ route('siswa.index') }}" class="block px-4 py-2 hover:bg-slate-700 rounded">

👨‍🎓 Siswa

</a>

<a href="{{ route('kelas.index') }}" class="block px-4 py-2 hover:bg-slate-700 rounded">

🏫 Kelas

</a>

<a href="{{ route('mata-pelajaran.index') }}" class="block px-4 py-2 hover:bg-slate-700 rounded">

📚 Mata Pelajaran

</a>

<a href="{{ route('tahun-ajaran.index') }}" class="block px-4 py-2 hover:bg-slate-700 rounded">

📅 Tahun Ajaran

</a>

<a href="{{ route('user.index') }}" class="block px-4 py-2 hover:bg-slate-700 rounded">

👤 User

</a>

<div class="mt-6 text-xs uppercase text-slate-400">

AKADEMIK

</div>

<a href="{{ route('guru-mengajar.index') }}" class="block px-4 py-2 hover:bg-slate-700 rounded">

📖 Penugasan Guru

</a>

<a href="{{ route('jadwal-mengajar.index') }}" class="block px-4 py-2 hover:bg-slate-700 rounded">

🗓 Jadwal Mengajar

</a>

<a href="{{ route('kehadiran.input') }}" class="block px-4 py-2 hover:bg-slate-700 rounded">

✅ Kehadiran Manual

</a>

<div class="mt-6 text-xs uppercase text-slate-400">

IMPORT DATA

</div>

<a href="{{ route('import.index') }}"
class="block px-4 py-2 hover:bg-slate-700 rounded">

📦 Import Data

</a>

<div class="mt-6 text-xs uppercase text-slate-400">

LAPORAN

</div>

<a href="#">

📊 Rekap

</a>

</nav>

</aside>
