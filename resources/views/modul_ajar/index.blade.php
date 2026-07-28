@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6">

@if(session('success'))

<div class="bg-green-100 border border-green-300 text-green-700 rounded-lg p-4 mb-6">

{{ session('success') }}

</div>

@endif

<div class="flex justify-between items-center mb-6">

<div>

<h1 class="text-3xl font-bold">

📚 Modul Ajar

</h1>

<p class="text-gray-500">

Kelola seluruh modul ajar guru.

</p>

</div>

<a
href="{{ route('modul-ajar.create') }}"
class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">

+ Tambah Modul

</a>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full">

<thead class="bg-gray-100">

<tr>

<th class="p-4 text-left">Judul Modul</th>

<th class="p-4 text-left">Guru</th>

<th class="p-4 text-center">Kelas</th>

<th class="p-4 text-center">BAB</th>

<th class="p-4 text-center">Status</th>

<th class="p-4 text-center">Aksi</th>

</tr>

</thead>

<tbody>

@forelse($data as $modul)

<tr class="border-t hover:bg-gray-50">

<td class="p-4">

<div class="font-semibold">

{{ $modul->judul }}

</div>

<div class="text-sm text-gray-500">

{{ $modul->mataPelajaran->nama_mapel }}

|

{{ $modul->semester }}

</div>

</td>

<td class="p-4">

{{ $modul->guru->nama ?? '-' }}

</td>

<td class="p-4 text-center">

{{ $modul->kelas->count() }}

</td>

<td class="p-4 text-center">

{{ $modul->babs->count() }}

</td>

<td class="p-4 text-center">

@if($modul->aktif)

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Aktif

</span>

@else

<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

Nonaktif

</span>

@endif

</td>

<td class="p-4 text-center">

<a

href="{{ route('modul-ajar.show',$modul) }}"

class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

Detail

</a>

</td>

</tr>

@empty

<tr>

<td colspan="6" class="text-center py-10 text-gray-500">

Belum ada Modul Ajar.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-6">

{{ $data->links() }}

</div>

</div>

@endsection