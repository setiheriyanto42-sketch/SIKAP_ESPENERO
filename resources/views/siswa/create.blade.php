<script>

document
.getElementById('foto')
.addEventListener('change',function(e){

const file=e.target.files[0];

if(file){

document
.getElementById('previewFoto')
.src=URL.createObjectURL(file);

}

});

</script>

@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            Tambah Data Siswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto">

            <div class="bg-white shadow rounded-lg p-6">

                <form
                action="{{ route('siswa.store') }}"
                method="POST"
                enctype="multipart/form-data">

                    @csrf

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="font-semibold">NIS</label>
                            <input type="text" name="nis"
                                   value="{{ old('nis') }}"
                                   class="border rounded w-full p-2">

                            @error('nis')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="font-semibold">NISN</label>
                            <input type="text" name="nisn"
                                   value="{{ old('nisn') }}"
                                   class="border rounded w-full p-2">

                            @error('nisn')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="font-semibold">Nama Siswa</label>
                            <input type="text" name="nama"
                                   value="{{ old('nama') }}"
                                   class="border rounded w-full p-2">

                            @error('nama')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-2">

                        <label class="font-semibold">

                        Foto Siswa

                        </label>

                        <div class="mt-2 flex items-center gap-6">

                        <img
                        id="previewFoto"
                        src="https://placehold.co/120x150/e2e8f0/64748b?text=FOTO"
                        class="w-28 h-36 rounded-lg border object-cover">

                        <div>

                        <input
                        type="file"
                        name="foto"
                        id="foto"
                        accept="image/*"
                        class="block w-full border rounded p-2">

                        <p class="text-sm text-gray-500 mt-2">

                        Format JPG / PNG
                        Maksimal 2 MB

                        </p>

                        </div>

                        </div>

                        </div>

                        <div>
                            <label class="font-semibold">Jenis Kelamin</label>

                            <select name="jenis_kelamin"
                                    class="border rounded w-full p-2">

                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>

                            </select>
                        </div>

                        <div>
                            <label class="font-semibold">Agama</label>

                            <select name="agama"
                                    class="border rounded w-full p-2">

                                <option>Islam</option>
                                <option>Kristen</option>
                                <option>Katolik</option>
                                <option>Hindu</option>
                                <option>Buddha</option>
                                <option>Konghucu</option>

                            </select>

                        </div>

                        <div>
                            <label class="font-semibold">Tempat Lahir</label>

                            <input type="text"
                                   name="tempat_lahir"
                                   class="border rounded w-full p-2">

                        </div>

                        <div>
                            <label class="font-semibold">Tanggal Lahir</label>

                            <input type="date"
                                   name="tanggal_lahir"
                                   class="border rounded w-full p-2">

                        </div>

                        <div>
                            <label class="font-semibold">Kelas</label>

                            <select name="kelas"
                                    class="border rounded w-full p-2">

                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>

                            </select>

                        </div>

                        <div>
                            <label class="font-semibold">Rombel</label>

                            <select name="rombel"
                                    class="border rounded w-full p-2">

                                <option>A</option>
                                <option>B</option>
                                <option>C</option>
                                <option>D</option>
                                <option>E</option>
                                <option>F</option>

                            </select>

                        </div>

                        <div class="col-span-2">
                            <label class="font-semibold">Alamat</label>

                            <textarea
                                name="alamat"
                                rows="3"
                                class="border rounded w-full p-2"></textarea>

                        </div>

                        <div>
                            <label class="font-semibold">Nama Ayah</label>

                            <input type="text"
                                   name="nama_ayah"
                                   class="border rounded w-full p-2">

                        </div>

                        <div>
                            <label class="font-semibold">Nama Ibu</label>

                            <input type="text"
                                   name="nama_ibu"
                                   class="border rounded w-full p-2">

                        </div>

                        <div>
                            <label class="font-semibold">No HP</label>

                            <input type="text"
                                   name="no_hp"
                                   class="border rounded w-full p-2">

                        </div>

                    </div>

                    <div class="mt-6">

                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">

                            Simpan

                        </button>

                        <a href="{{ route('siswa.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection
