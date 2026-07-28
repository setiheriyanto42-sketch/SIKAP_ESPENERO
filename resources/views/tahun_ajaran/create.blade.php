@extends('layouts.app')

@section('content')

<x-slot name="header">

<h2 class="text-2xl font-bold">

Tambah Tahun Ajaran

</h2>

</x-slot>

<div class="py-6">

<div class="max-w-2xl mx-auto">

<div class="bg-white shadow rounded p-6">

<form
method="POST"
action="{{ route('tahun-ajaran.store') }}">

@csrf

<div class="mb-4">

<label>Tahun Ajaran</label>

<input
type="text"
name="tahun_ajaran"
placeholder="2026/2027"
class="border rounded w-full p-2">

</div>

<div class="mb-4">

<label>Semester</label>

<select
name="semester"
class="border rounded w-full p-2">

<option value="Ganjil">

Ganjil

</option>

<option value="Genap">

Genap

</option>

</select>

</div>

<div class="mb-4">

<label>

<input
type="checkbox"
name="aktif">

Jadikan Tahun Ajaran Aktif

</label>

</div>

<button
class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">

💾 Simpan

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
