<x-app-layout>

<x-slot name="header">
    <h2 class="text-2xl font-bold">
        📦 Import Data Guru
    </h2>
</x-slot>

<div class="py-6">

<div class="max-w-5xl mx-auto">

@if(session('success'))
<div class="mb-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">

<ul class="list-disc ml-5">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>
@endif

<div class="grid lg:grid-cols-3 gap-6">

<div class="lg:col-span-2">

<div class="bg-white shadow rounded-xl p-6">

<h3 class="text-xl font-bold mb-5">

Upload File Excel Guru

</h3>

<form
action="{{ route('guru.import') }}"
method="POST"
enctype="multipart/form-data">

@csrf

<div class="mb-5">

<label class="font-semibold">

Pilih File Excel

</label>

<div
x-data="{ fileName:'' }"
class="mt-3">

<label
class="flex items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer hover:border-blue-500 transition">

<div class="text-center">

<div class="text-5xl">

📁

</div>

<p class="font-semibold mt-3">

Klik atau tarik file Excel ke sini

</p>

<p
class="text-blue-600 mt-2"
x-text="fileName"></p>

</div>

<input
type="file"
name="file"
accept=".xlsx,.xls"
required
class="hidden"
@change="fileName=$event.target.files[0].name">

</label>

</div>

</div>

<div class="flex gap-3">

<button
class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

📥 Import Data Guru

</button>

<a
href="{{ route('guru.index') }}"
class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

Kembali

</a>

</div>

</form>

</div>

</div>

<div>

<div class="bg-blue-50 border border-blue-200 rounded-xl p-6">

<h4 class="font-bold text-lg mb-4">

📄 Format Excel

</h4>

<table class="w-full text-sm">

<tr>

<td>NIP</td>

</tr>

<tr>

<td>Nama</td>

</tr>

<tr>

<td>Jenis Kelamin</td>

</tr>

<tr>

<td>No HP</td>

</tr>

<tr>

<td>Email</td>

</tr>

<tr>

<td>Alamat</td>

</tr>

</table>

<hr class="my-4">

<a
href="{{ route('guru.template') }}"
class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg">

⬇ Download Template Excel

</a>

</div>

</div>

</div>

</div>

</div>

</x-app-layout>
