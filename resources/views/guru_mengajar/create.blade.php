<x-app-layout>

<x-slot name="header">

<h2 class="text-2xl font-bold">

Tambah Penugasan Mengajar

</h2>

</x-slot>

<div class="py-6">

<div class="max-w-3xl mx-auto">

<div class="bg-white shadow rounded-lg p-6">

<form method="POST"
      action="{{ route('guru-mengajar.store') }}">

@csrf

<div class="mb-4">

<label class="block font-semibold mb-2">

Guru

</label>

<select
name="guru_id"
class="border rounded w-full p-2">

@foreach($gurus as $guru)

<option value="{{ $guru->id }}">

{{ $guru->nama }}

</option>

@endforeach

</select>

</div>

<div class="mb-4">

<label class="block font-semibold mb-2">

Mata Pelajaran

</label>

<select
name="mata_pelajaran_id"
class="border rounded w-full p-2">

@foreach($mapel as $m)

<option value="{{ $m->id }}">

{{ $m->nama_mapel }}

</option>

@endforeach

</select>

</div>

<div class="mb-4">

<label class="block font-semibold mb-2">

Kelas

</label>

<select
name="kelas_id"
class="border rounded w-full p-2">

@foreach($kelas as $k)

<option value="{{ $k->id }}">

{{ $k->nama_kelas }}

</option>

@endforeach

</select>

</div>

<button
class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">

💾 Simpan

</button>

<a href="{{ route('guru-mengajar.index') }}"
class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">

Kembali

</a>

</form>

</div>

</div>

</div>

</x-app-layout>
