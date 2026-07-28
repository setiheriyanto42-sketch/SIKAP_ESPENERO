@extends('layouts.app')

@section('content')

<x-slot name="header">

<h2 class="text-2xl font-bold">

Edit Tahun Ajaran

</h2>

</x-slot>

<div class="py-6">

<div class="max-w-2xl mx-auto">

<div class="bg-white shadow rounded p-6">

<form
method="POST"
action="{{ route('tahun-ajaran.update',$tahunAjaran) }}">

@csrf
@method('PUT')

<div class="mb-4">

<label>Tahun Ajaran</label>

<input
type="text"
name="tahun_ajaran"
value="{{ $tahunAjaran->tahun_ajaran }}"
class="border rounded w-full p-2">

</div>

<div class="mb-4">

<label>Semester</label>

<select
name="semester"
class="border rounded w-full p-2">

<option
value="Ganjil"
{{ $tahunAjaran->semester=='Ganjil'?'selected':'' }}>

Ganjil

</option>

<option
value="Genap"
{{ $tahunAjaran->semester=='Genap'?'selected':'' }}>

Genap

</option>

</select>

</div>

<div class="mb-4">

<label>

<input
type="checkbox"
name="aktif"
{{ $tahunAjaran->aktif?'checked':'' }}>

Aktif

</label>

</div>

<button
class="bg-green-600 text-white px-6 py-2 rounded">

💾 Update

</button>

<a
href="{{ route('tahun-ajaran.index') }}"
class="bg-gray-500 text-white px-6 py-2 rounded">

Kembali

</a>

</form>

</div>

</div>

</div>

@endsection
