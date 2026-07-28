@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="bg-white rounded-xl shadow-lg p-6">

        <div class="flex justify-between items-center mb-6">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">
                    📚 Tambah Modul Ajar
                </h1>

                <p class="text-gray-500">
                    Buat perencanaan pembelajaran.
                </p>

            </div>

            <a href="{{ route('modul-ajar.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg">

                ← Kembali

            </a>

        </div>

        <form
            action="{{ route('modul-ajar.store') }}"
            method="POST">

            @csrf

            @if(auth()->user()->guru_id==null)

            <div class="mb-6">

                <label class="font-semibold">

                    Guru

                </label>

                <select
                    name="guru_id"
                    class="w-full border rounded-lg p-3 mt-2">

                    @foreach($gurus as $guru)

                        <option value="{{ $guru->id }}">

                            {{ $guru->nama }}

                        </option>

                    @endforeach

                </select>

            </div>

            @endif

            <div class="grid grid-cols-2 gap-6">

                <div>

                    <label class="font-semibold">

                        Mata Pelajaran

                    </label>

                    <select
                        id="mapel"
                        name="mata_pelajaran_id"
                        class="w-full border rounded-lg p-3 mt-2"
                        required>

                        <option value="">

                            -- Pilih Mata Pelajaran --

                        </option>

                        @foreach($mapel as $m)

                            <option value="{{ $m->id }}">

                                {{ $m->nama_mapel }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="font-semibold">

                        Tahun Ajaran Aktif

                    </label>

                    <input
                        type="text"
                        readonly
                        class="w-full border rounded-lg p-3 mt-2 bg-gray-100"
                        value="{{ $tahun ? $tahun->tahun_ajaran.' - '.$tahun->semester : '-' }}">

                </div>

                <div>

                    <label class="font-semibold">

                        Tingkat

                    </label>

                    <select
                        id="tingkat"
                        name="tingkat"
                        class="w-full border rounded-lg p-3 mt-2">

                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>

                    </select>

                </div>

                <div>

                    <label class="font-semibold">

                        Semester

                    </label>

                    <select
                        id="semester"
                        name="semester"
                        class="w-full border rounded-lg p-3 mt-2">

                        <option value="Ganjil">

                            Ganjil

                        </option>

                        <option value="Genap">

                            Genap

                        </option>

                    </select>

                </div>

                <div class="col-span-2">

                    <label class="font-semibold">

                        Judul Modul

                    </label>

                    <input
                        id="judul"
                        type="text"
                        name="judul"
                        class="w-full border rounded-lg p-3 mt-2">

                </div>

                <div class="col-span-2">

                    <label class="font-semibold">

                        Keterangan

                    </label>

                    <textarea
                        name="keterangan"
                        rows="5"
                        class="w-full border rounded-lg p-3 mt-2"></textarea>

                </div>

            </div>

            <div class="mt-8">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg">

                    💾 Simpan Modul

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function updateJudul(){

    let mapel=document.getElementById('mapel');

    let tingkat=document.getElementById('tingkat');

    let semester=document.getElementById('semester');

    let judul=document.getElementById('judul');

    if(mapel.selectedIndex<1){

        judul.value='';

        return;

    }

    let namaMapel=mapel.options[mapel.selectedIndex].text;

    judul.value=
        namaMapel+
        " Kelas "+
        tingkat.value+
        " Semester "+
        semester.value;

}

document.getElementById('mapel').addEventListener('change',updateJudul);

document.getElementById('tingkat').addEventListener('change',updateJudul);

document.getElementById('semester').addEventListener('change',updateJudul);

window.onload=updateJudul;

</script>

@endsection