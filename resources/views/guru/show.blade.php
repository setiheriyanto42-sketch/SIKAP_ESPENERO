<x-app-layout>

<x-slot name="header">
    <h2 class="text-2xl font-bold">
        👨‍🏫 Detail Guru
    </h2>
</x-slot>

<div class="py-6">

<div class="max-w-4xl mx-auto">

<div class="bg-white rounded-xl shadow-lg overflow-hidden">

<div class="bg-blue-600 text-white px-8 py-5">

<h3 class="text-3xl font-bold">
👨‍🏫 Profil Guru
</h3>

<p class="text-blue-100">
Informasi lengkap data guru
</p>

</div>

<div class="p-8">

<div class="grid grid-cols-2 gap-6">

<div>
<label class="font-semibold text-gray-500">
NIP
</label>

<div class="text-lg">
{{ $guru->nip }}
</div>
</div>

<div>
<label class="font-semibold text-gray-500">
Nama
</label>

<div class="text-lg font-bold text-blue-700">
{{ $guru->nama }}
</div>
</div>

<div>
<label class="font-semibold text-gray-500">
Jenis Kelamin
</label>

<div class="text-lg">
{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
</div>
</div>

<div>
<label class="font-semibold text-gray-500">
No HP
</label>

<div class="text-lg">
{{ $guru->no_hp ?? '-' }}
</div>
</div>

<div>
<label class="font-semibold text-gray-500">
Email
</label>

<div class="text-lg">
{{ $guru->email ?? '-' }}
</div>
</div>

<div>
<label class="font-semibold text-gray-500">
Status
</label>

@if($guru->aktif)

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Aktif
</span>

@else

<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
Non Aktif
</span>

@endif

</div>

<div class="col-span-2">

<label class="font-semibold text-gray-500">
Alamat
</label>

<div class="text-lg">
{{ $guru->alamat ?? '-' }}
</div>

</div>

</div>

<hr class="my-8">

<div class="flex gap-3">

<a href="{{ route('guru.edit',$guru) }}"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg">

✏ Edit

</a>

<a href="{{ route('guru.index') }}"
class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg">

⬅ Kembali

</a>

</div>

</div>

</div>

</div>

</div>

</x-app-layout>