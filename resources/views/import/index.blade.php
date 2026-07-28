@extends('layouts.app')

@section('content')

<x-slot name="header">

<h2 class="text-2xl font-bold">

📦 Import Data

</h2>

</x-slot>

<div class="py-6">

<div class="max-w-7xl mx-auto">

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

{{-- Guru --}}

<div class="bg-white rounded-xl shadow p-6">

<div class="text-5xl mb-4">
👨‍🏫
</div>

<h3 class="font-bold text-xl mb-2">

Import Guru

</h3>

<p class="text-gray-500 mb-4">

Upload data guru dari Excel.

</p>

<a
href="{{ route('guru.import.form') }}"
class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">

Buka Import

</a>

</div>

{{-- Siswa --}}

<div class="bg-white rounded-xl shadow p-6">

<div class="text-5xl mb-4">
👨‍🎓
</div>

<h3 class="font-bold text-xl mb-2">

Import Siswa

</h3>

<p class="text-gray-500 mb-4">

Segera tersedia.

</p>

<button
disabled
class="w-full bg-gray-300 py-2 rounded">

Coming Soon

</button>

</div>

{{-- User --}}

<div class="bg-white rounded-xl shadow p-6">

<div class="text-5xl mb-4">

👤

</div>

<h3 class="font-bold text-xl mb-2">

Import User

</h3>

<p class="text-gray-500 mb-4">

Segera tersedia.

</p>

<button
disabled
class="w-full bg-gray-300 py-2 rounded">

Coming Soon

</button>

</div>

{{-- Jadwal --}}

<div class="bg-white rounded-xl shadow p-6">

<div class="text-5xl mb-4">

📅

</div>

<h3 class="font-bold text-xl mb-2">

Import Jadwal

</h3>

<p class="text-gray-500 mb-4">

Segera tersedia.

</p>

<button
disabled
class="w-full bg-gray-300 py-2 rounded">

Coming Soon

</button>

</div>

{{-- Mata Pelajaran --}}

<div class="bg-white rounded-xl shadow p-6">

<div class="text-5xl mb-4">

📚

</div>

<h3 class="font-bold text-xl mb-2">

Import Mata Pelajaran

</h3>

<p class="text-gray-500 mb-4">

Segera tersedia.

</p>

<button
disabled
class="w-full bg-gray-300 py-2 rounded">

Coming Soon

</button>

</div>

{{-- Kelas --}}

<div class="bg-white rounded-xl shadow p-6">

<div class="text-5xl mb-4">

🏫

</div>

<h3 class="font-bold text-xl mb-2">

Import Kelas

</h3>

<p class="text-gray-500 mb-4">

Segera tersedia.

</p>

<button
disabled
class="w-full bg-gray-300 py-2 rounded">

Coming Soon

</button>

</div>

</div>

</div>

</div>

@endsection
