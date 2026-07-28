@extends('layouts.app')

@section('content')

<x-slot name="header">

<h2 class="text-2xl font-bold">

📝 Jurnal Mengajar

</h2>

</x-slot>

<div class="py-6">

<div class="max-w-4xl mx-auto">

<div class="bg-white shadow rounded-lg p-6">

<form
method="POST"
action="{{ route('jurnal-mengajar.store') }}">

@csrf

<input
type="hidden"
name="sesi_mengajar_id"
value="{{ $sesi->id }}">

<div class="mb-5">

<b>Guru</b>

<br>

{{ $sesi->jadwalMengajar->guruMengajar->guru->nama }}

</div>

<div class="mb-5">

<b>Mata Pelajaran</b>

<br>

{{ $sesi->jadwalMengajar->guruMengajar->mataPelajaran->nama_mapel }}

</div>

<div class="mb-5">

<b>Kelas</b>

<br>

{{ $sesi->jadwalMengajar->guruMengajar->kelas->nama_kelas }}

</div>

<div class="mb-5">

<b>Tanggal</b>

<br>

{{ $sesi->tanggal->format('d-m-Y') }}

</div>

<div class="grid grid-cols-2 gap-4 mb-5">

<div>

<label>Jumlah Hadir</label>

<input
readonly
name="jumlah_hadir"
value="{{ $hadir }}"
class="border rounded w-full p-2">

</div>

<div>

<label>Tidak Hadir</label>

<input
readonly
name="jumlah_tidak_hadir"
value="{{ $tidakHadir }}"
class="border rounded w-full p-2">

</div>

</div>

<div class="mb-4">

<label class="font-semibold">

Materi Pembelajaran

</label>

<textarea
required
name="materi"
rows="4"
class="border rounded w-full p-2"></textarea>

</div>

<div class="mb-4">

<label class="font-semibold">

Tujuan Pembelajaran

</label>

<textarea
name="tujuan"
rows="3"
class="border rounded w-full p-2"></textarea>

</div>

<div class="mb-4">

<label class="font-semibold">

Catatan Guru

</label>

<textarea
name="catatan"
rows="3"
class="border rounded w-full p-2"></textarea>

</div>

<button
type="submit"
class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

💾 Simpan Jurnal

</button>

</form>

</div>

</div>

</div>

@endsection
