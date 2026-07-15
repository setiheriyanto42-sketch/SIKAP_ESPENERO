<x-app-layout>

<x-slot name="header">
    <h2 class="text-2xl font-bold">
        📦 Import Data Siswa
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
Upload File Excel Siswa
</h3>

<form
id="importForm"
action="{{ route('siswa.import') }}"
method="POST"
enctype="multipart/form-data">

@csrf

<div class="mb-5">

<label class="font-semibold">
Pilih File Excel
</label>

<div x-data="{ fileName:'' }" class="mt-3">

<label
class="flex items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer hover:border-blue-500 transition">

<div class="text-center">

<div class="text-5xl">
📁
</div>

<p class="font-semibold mt-3">
Klik atau tarik file Excel ke sini
</p>

<p class="text-blue-600 mt-2" x-text="fileName"></p>

</div>

<input
id="fileInput"
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
type="submit"
class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

📥 Import Data

</button>

<button
type="button"
id="btnPreview"
class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

👁 Preview

</button>

<a
href="{{ route('siswa.index') }}"
class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

Kembali

</a>

</div>

</form>

<hr class="my-8">

<div
id="preview-area"
class="mt-8">

</div>

</div>

</div>

<div>

<div class="bg-blue-50 border border-blue-200 rounded-xl p-6">

<h4 class="font-bold text-lg mb-4">
📄 Format Excel
</h4>

<table class="w-full text-sm">

<tr><td>NIS</td></tr>
<tr><td>NISN</td></tr>
<tr><td>Nama</td></tr>
<tr><td>Jenis Kelamin</td></tr>
<tr><td>Kelas</td></tr>
<tr><td>No HP</td></tr>
<tr><td>Alamat</td></tr>

</table>

<hr class="my-4">

<a
href="{{ route('siswa.template') }}"
class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg">

⬇ Download Template Excel

</a>

</div>

</div>

</div>

</div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function(){

const btn=document.getElementById('btnPreview');

btn.addEventListener('click', async function(){

const input=document.getElementById('fileInput');

if(!input.files.length){

alert('Pilih file Excel terlebih dahulu.');

return;

}

let formData=new FormData();

formData.append('file',input.files[0]);

formData.append('_token','{{ csrf_token() }}');

try{

let response=await fetch("{{ route('siswa.preview') }}",{

method:'POST',

body:formData,

headers:{
'Accept':'application/json'
}

});

if(!response.ok){

throw new Error("Preview gagal");

}

let data=await response.json();

let html=`

<div class="bg-white rounded-xl shadow p-5">

<div class="flex justify-between mb-4">

<h3 class="text-xl font-bold">

📋 Preview Data Siswa

</h3>

<span class="bg-blue-600 text-white px-3 py-1 rounded">

${data.length} Data

</span>

</div>

<div class="overflow-x-auto rounded-lg border">

<div class="overflow-x-auto">

<table class="min-w-full border-collapse">
<thead>

<tr class="bg-blue-600 text-white">

<th class="border p-2 w-52">No</th>

<th class="border p-2">NIS</th>

<th class="border p-2">NISN</th>

<th class="border p-2">Nama</th>

<th class="border p-2">JK</th>

<th class="border p-2">Kelas</th>

<th class="border p-2">No HP</th>

<th class="border p-2">Alamat</th>

</tr>

</thead>

<tbody>

`;

data.forEach(function(row,index){

html += `

<tr>

<td class="border p-2 text-center">${index+1}</td>

<td class="border p-2">${row[0] ?? ''}</td>

<td class="border p-2">${row[1] ?? ''}</td>

<td class="border p-2">${row[2] ?? ''}</td>

<td class="border p-2">${row[3] ?? ''}</td>

<td class="border p-2">${row[4] ?? ''}</td>

<td class="border p-2">${row[5] ?? ''}</td>

<td class="border p-2">${row[6] ?? ''}</td>

</tr>

`;

});

html+=`

</tbody>

</table>

</div>

</div>

`;

document.getElementById('preview-area').innerHTML=html;

}catch(e){

alert(e.message);

console.log(e);

}

});

});

</script>

</x-app-layout>
