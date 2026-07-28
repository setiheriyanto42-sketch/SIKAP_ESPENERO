@extends('layouts.app')

@section('content')

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



    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            Edit Data Siswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto">

            <div class="bg-white shadow rounded-lg p-6">

                <form
                action="{{ route('siswa.update',$siswa) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="font-semibold">NIS</label>
                            <input type="text" name="nis"
                                   value="{{ old('nis',$siswa->nis) }}"
                                   class="border rounded w-full p-2">

                            @error('nis')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="font-semibold">NISN</label>
                            <input type="text" name="nisn"
                                   value="{{ old('nisn',$siswa->nisn) }}"
                                   class="border rounded w-full p-2">

                            @error('nisn')
                                <div class="text-red-600 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="font-semibold">Nama Siswa</label>
                            <input type="text" name="nama"
                                   value="{{ old('nama',$siswa->nama) }}"
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

                                @if($siswa->foto)

                                    <img
                                        id="previewFoto"
                                        src="{{ asset('storage/'.$siswa->foto) }}"
                                        class="w-32 h-40 object-cover rounded-xl border-2 border-slate-300 shadow-md"

                                @else

                                    <img
                                        id="previewFoto"
                                        src="https://placehold.co/120x150/e2e8f0/64748b?text=FOTO"
                                        class="w-32 h-40 object-cover rounded-xl border-2 border-slate-300 shadow-md"

                                @endif

                                <div>

                                    <input
                                        type="file"
                                        name="foto"
                                        id="foto"
                                        accept="image/*"
                                        class="block w-full border rounded p-2">

                                    <p class="text-sm text-gray-500 mt-2">

                                        Kosongkan jika tidak ingin mengganti foto.

                                    </p>

                                </div>

                            </div>

                        </div>

                        <div>
                            <label class="font-semibold">Jenis Kelamin</label>

                            <select
                            name="jenis_kelamin"
                            class="border rounded w-full p-2">

                            <option value="">-- Pilih --</option>

                            <option
                            value="L"
                            {{ old('jenis_kelamin',$siswa->jenis_kelamin)=='L'?'selected':'' }}>

                            Laki-laki

                            </option>

                            <option
                            value="P"
                            {{ old('jenis_kelamin',$siswa->jenis_kelamin)=='P'?'selected':'' }}>

                            Perempuan

                            </option>

                            </select>
                        </div>

                        <div>
                            <label class="font-semibold">Agama</label>

                            <select name="agama"
                                    class="border rounded w-full p-2">

                                <option
                                value="Islam"
                                {{ old('agama',$siswa->agama)=='Islam'?'selected':'' }}>

                                Islam

                                </option>

                                <option
                                value="Kristen"
                                {{ old('agama',$siswa->agama)=='Kristen'?'selected':'' }}>

                                Kristen

                                </option>

                                <option
                                value="Katolik"
                                {{ old('agama',$siswa->agama)=='Katolik'?'selected':'' }}>

                                Katolik

                                </option>

                                <option
                                value="Hindu"
                                {{ old('agama',$siswa->agama)=='Hindu'?'selected':'' }}>

                                Hindu

                                </option>

                                <option
                                value="Buddha"
                                {{ old('agama',$siswa->agama)=='Buddha'?'selected':'' }}>

                                Buddha

                                </option>

                                <option
                                value="Buddha"
                                {{ old('agama',$siswa->agama)=='Buddha'?'selected':'' }}>

                                Buddha

                                </option>

                                <option
                                value="Konghucu"
                                {{ old('agama',$siswa->agama)=='Konghucu'?'selected':'' }}>

                                Konghucu

                                </option>



                            </select>

                        </div>

                        <div>
                            <label class="font-semibold">Tempat Lahir</label>

                            <input
                            type="text"
                            name="tempat_lahir"
                            value="{{ old('tempat_lahir',$siswa->tempat_lahir) }}"
                            class="border rounded w-full p-2">

                        </div>

                        <div>
                            <label class="font-semibold">Tanggal Lahir</label>

                            <input
                            type="date"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir',$siswa->tanggal_lahir) }}"
                            class="border rounded w-full p-2">

                        </div>

                        <div>
                            <label class="font-semibold">Kelas</label>

                            <select
                            name="kelas"
                            class="border rounded w-full p-2">

                            <option value="7"
                            {{ old('kelas',$siswa->kelas)==7?'selected':'' }}>

                            7

                            </option>

                            <option value="8"
                            {{ old('kelas',$siswa->kelas)==8?'selected':'' }}>

                            8

                            </option>

                            <option value="9"
                            {{ old('kelas',$siswa->kelas)==9?'selected':'' }}>

                            9

                            </option>

                            </select>

                        </div>

                        <div>
                            <label class="font-semibold">Rombel</label>

                            <select
                            name="rombel"
                            class="border rounded w-full p-2">

                            @foreach(['A','B','C','D','E','F'] as $r)

                            <option
                            value="{{ $r }}"
                            {{ old('rombel',$siswa->rombel)==$r?'selected':'' }}>

                            {{ $r }}

                            </option>

                            @endforeach

                            </select>

                        </div>

                        <div class="col-span-2">
                            <label class="font-semibold">Alamat</label>

                            <textarea
                            name="alamat"
                            rows="3"
                            class="border rounded w-full p-2">{{ old('alamat',$siswa->alamat) }}</textarea>

                        </div>

                        <div>
                            <label class="font-semibold">Nama Ayah</label>

                            <input
                                type="text"
                                name="nama_ayah"
                                value="{{ old('nama_ayah',$siswa->nama_ayah) }}"
                                class="border rounded w-full p-2">

                        </div>

                        <div>
                            <label class="font-semibold">Nama Ibu</label>

                            <input
                                type="text"
                                name="nama_ibu"
                                value="{{ old('nama_ibu',$siswa->nama_ibu) }}"
                                class="border rounded w-full p-2">

                        </div>

                        <div>
                            <label class="font-semibold">No HP</label>

                            <input
                                type="text"
                                name="no_hp"
                                value="{{ old('no_hp',$siswa->no_hp) }}"
                                class="border rounded w-full p-2">

                        </div>

                    </div>

                    <div class="mt-6">

                        <div class="mt-4">

                        <label class="inline-flex items-center">

                        <input
                        type="checkbox"
                        name="aktif"
                        class="mr-2"
                        {{ $siswa->aktif ? 'checked' : '' }}>

                        Aktif

                        </label>

                        </div>

                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">

                            💾 Simpan Perubahan

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

