<x-app-layout>

<x-slot name="header">
<h2 class="text-2xl font-bold">
Tambah Mata Pelajaran
</h2>
</x-slot>

<div class="py-6">

<div class="max-w-3xl mx-auto">

<div class="bg-white shadow rounded p-6">

<form method="POST"
action="{{ route('mata-pelajaran.store') }}">

@csrf

<div class="mb-4">

<label>Kode Mapel</label>

<input
type="text"
name="kode_mapel"
class="border rounded w-full p-2">

</div>

<div class="mb-4">

<label>Nama Mata Pelajaran</label>

<input
type="text"
name="nama_mapel"
class="border rounded w-full p-2">

</div>

<div class="mb-4">

<label>Kelompok</label>

<select
name="kelompok"
class="border rounded w-full p-2">

<option value="Umum">Umum</option>
<option value="Muatan Lokal">Muatan Lokal</option>

</select>

</div>

<button
class="bg-green-600 text-white px-6 py-2 rounded">

💾 Simpan

</button>

<a
href="{{ route('mata-pelajaran.index') }}"
class="bg-gray-500 text-white px-6 py-2 rounded">

Kembali

</a>

</form>

</div>

</div>

</div>

</x-app-layout>
