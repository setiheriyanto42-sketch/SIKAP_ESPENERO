@extends('layouts.app')

@section('content')

<x-slot name="header">
<h2 class="text-2xl font-bold">
Master Tahun Ajaran
</h2>
</x-slot>

<div class="py-6">

<div class="max-w-7xl mx-auto">

@if(session('success'))

<div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-5">

{{ session('success') }}

</div>

@endif

@php
$aktif = $tahun->firstWhere('aktif', true);
@endphp

@if($aktif)

<div class="mb-6 rounded-xl bg-gradient-to-r from-green-600 to-green-500 text-white shadow-lg">

    <div class="p-6">

        <div class="text-sm uppercase tracking-wider">

            📚 Tahun Ajaran Aktif

        </div>

        <div class="text-3xl font-bold mt-2">

            {{ $aktif->tahun_ajaran }}

        </div>

        <div class="text-lg">

            Semester {{ $aktif->semester }}

        </div>

    </div>

</div>

@endif

<div class="mb-5 flex justify-end">

<a href="{{ route('tahun-ajaran.create') }}"
class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">

+ Tambah Tahun Ajaran

</a>

</div>

<div class="bg-white shadow rounded">

<table class="w-full">

<thead class="bg-sky-600 text-white">

<tr>

<th class="p-3">No</th>

<th>Tahun Ajaran</th>

<th>Semester</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($tahun as $item)

<tr class="border-t">

<td class="p-3">

{{ $loop->iteration }}

</td>

<td>

{{ $item->tahun_ajaran }}

</td>

<td>

{{ $item->semester }}

</td>

<td>

@if($item->aktif)

<span class="bg-green-200 px-3 py-1 rounded">

AKTIF

</span>

@else

<span class="bg-red-200 px-3 py-1 rounded">

NONAKTIF

</span>

@endif

@if($item->aktif)

<span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">

🟢 Aktif

</span>

@else

<span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-600 font-semibold">

⚪ Non Aktif

</span>

@endif

</td>

<td>

<a href="{{ route('tahun-ajaran.edit',$item) }}"
class="bg-yellow-500 text-white px-3 py-1 rounded">

Edit

</a>

<form
class="inline"
method="POST"
action="{{ route('tahun-ajaran.destroy',$item) }}">

@csrf
@method('DELETE')

<button
onclick="return confirm('Hapus data?')"
class="bg-red-600 text-white px-3 py-1 rounded">

Hapus

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="5"
class="text-center p-5">

Belum ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection
