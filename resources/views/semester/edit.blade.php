@extends('layouts.app')

@section('content')

<x-slot name="header">
<h2 class="text-2xl font-bold">
Edit Semester
</h2>
</x-slot>

<div class="py-6">

<div class="max-w-xl mx-auto">

<div class="bg-white shadow rounded p-6">

<form method="POST"
action="{{ route('semester.update',$semester) }}">

@csrf
@method('PUT')

<div class="mb-4">

<label>Nama Semester</label>

<select
name="nama"
class="border rounded w-full p-2">

<option
value="Ganjil"
{{ $semester->nama=='Ganjil'?'selected':'' }}>

Ganjil

</option>

<option
value="Genap"
{{ $semester->nama=='Genap'?'selected':'' }}>

Genap

</option>

</select>

</div>

<div class="mb-4">

<label>

<input
type="checkbox"
name="aktif"
{{ $semester->aktif?'checked':'' }}>

Aktif

</label>

</div>

<button
class="bg-green-600 text-white px-6 py-2 rounded">

💾 Update

</button>

<a
href="{{ route('semester.index') }}"
class="bg-gray-500 text-white px-6 py-2 rounded">

Kembali

</a>

</form>

</div>

</div>

</div>

@endsection
