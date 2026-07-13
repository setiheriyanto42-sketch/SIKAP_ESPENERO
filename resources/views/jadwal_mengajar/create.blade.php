<x-app-layout>

<x-slot name="header">
<h2 class="text-2xl font-bold">
Tambah Jadwal Mengajar
</h2>
</x-slot>

<div class="py-6">

<div class="max-w-2xl mx-auto">

<div class="bg-white shadow rounded p-6">

<form method="POST"
action="{{ route('jadwal-mengajar.store') }}">

@csrf

<div class="mb-4">

<label>Guru - Mapel - Kelas</label>

<select
name="guru_mengajar_id"
class="border rounded w-full p-2">

@foreach($mengajar as $m)

<option value="{{ $m->id }}">

{{ $m->guru->nama }}
-
{{ $m->mataPelajaran->nama_mapel }}
-
{{ $m->kelas->nama_kelas }}

</option>

@endforeach

</select>

</div>

<div class="mb-4">

<label>Hari</label>

<select
name="hari"
class="border rounded w-full p-2">

<option>Senin</option>
<option>Selasa</option>
<option>Rabu</option>
<option>Kamis</option>
<option>Jumat</option>
<option>Sabtu</option>

</select>

</div>

<div class="grid grid-cols-3 gap-3">

<div>

<label>Jam Ke</label>

<input
type="number"
name="jam_ke"
class="border rounded w-full p-2">

</div>

<div>

<label>Mulai</label>

<input
type="time"
name="jam_mulai"
class="border rounded w-full p-2">

</div>

<div>

<label>Selesai</label>

<input
type="time"
name="jam_selesai"
class="border rounded w-full p-2">

</div>

</div>

<div class="mt-5">

<button
class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">

💾 Simpan

</button>

<a href="{{ route('jadwal-mengajar.index') }}"
class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">

Kembali

</a>

</div>

</form>

</div>

</div>

</div>

</x-app-layout>
