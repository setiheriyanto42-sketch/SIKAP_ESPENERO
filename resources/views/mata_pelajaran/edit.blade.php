<x-app-layout>

<x-slot name="header">

<h2 class="text-2xl font-bold">

Edit Mata Pelajaran

</h2>

</x-slot>

<div class="py-6">

<div class="max-w-3xl mx-auto">

<div class="bg-white shadow rounded p-6">

<form method="POST"
action="{{ route('mata-pelajaran.update',$mataPelajaran) }}">

@csrf
@method('PUT')

<div class="mb-4">

<label>Kode Mapel</label>

<input
type="text"
name="kode_mapel"
value="{{ $mataPelajaran->kode_mapel }}"
class="border rounded w-full p-2">

</div>

<div class="mb-4">

<label>Nama Mata Pelajaran</label>

<input
type="text"
name="nama_mapel"
value="{{ $mataPelajaran->nama_mapel }}"
class="border rounded w-full p-2">

</div>

<div class="mb-4">

<label>Kelompok</label>

<select
name="kelompok"
class="border rounded w-full p-2">

<option
value="Umum"
{{ $mataPelajaran->kelompok=='Umum'?'selected':'' }}>

Umum

</option>

<option
value="Muatan Lokal"
{{ $mataPelajaran->kelompok=='Muatan Lokal'?'selected':'' }}>

Muatan Lokal

</option>

</select>

</div>

<div class="mb-4">

<label>

<input
type="checkbox"
name="aktif"
{{ $mataPelajaran->aktif?'checked':'' }}>

Aktif

</label>

</div>

<button
class="bg-green-600 text-white px-6 py-2 rounded">

💾 Update

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
