@extends('layouts.app')

@section('content')

<x-slot name="header">
<h2 class="text-2xl font-bold">
Tambah Semester
</h2>
</x-slot>

<div class="py-6">

<div class="max-w-xl mx-auto">

<div class="bg-white shadow rounded p-6">

<form method="POST"
action="{{ route('semester.store') }}">

@csrf

<div class="mb-4">

<label>Nama Semester</label>

<select
name="nama"
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

Jadikan Aktif

</label>

</div>

<button
class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">

💾 Simpan

</button>

<a
href="{{ route('semester.index') }}"
class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">

Kembali

</a>

</form>

</div>

</div>

</div>

@endsection
