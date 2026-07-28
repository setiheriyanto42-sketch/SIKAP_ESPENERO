@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

<div class="bg-white rounded-xl shadow-lg p-8">

<h1 class="text-3xl font-bold mb-8">

✏ Edit BAB

</h1>

<form
action="{{ route('modul-bab.update',$bab) }}"
method="POST">

@csrf
@method('PUT')

<div class="space-y-5">

<div>

<label class="font-semibold">

Nama BAB

</label>

<input
type="text"
name="nama_bab"
value="{{ $bab->nama_bab }}"
class="w-full border rounded-lg p-3 mt-2">

</div>

<div>

<label class="font-semibold">

Tujuan

</label>

<textarea
name="tujuan"
rows="5"
class="w-full border rounded-lg p-3 mt-2">{{ $bab->tujuan }}</textarea>

</div>

<div>

<label class="font-semibold">

Jumlah Pertemuan

</label>

<input
type="number"
name="jumlah_pertemuan"
value="{{ $bab->jumlah_pertemuan }}"
class="w-full border rounded-lg p-3 mt-2">

</div>

</div>

<div class="mt-8 flex gap-4">

<button
class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

💾 Simpan

</button>

<a
href="{{ route('modul-ajar.show',$bab->perencanaan_pembelajaran_id) }}"
class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

Batal

</a>

</div>

</form>

</div>

</div>

@endsection