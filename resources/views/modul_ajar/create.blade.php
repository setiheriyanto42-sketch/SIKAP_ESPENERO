@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="bg-white rounded-xl shadow-lg p-6">

        {{-- HEADER --}}
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
               class="bg-gray-500 hover:bg-gray-600
                      text-white px-5 py-3 rounded-lg">

                ← Kembali

            </a>

        </div>


        {{-- ERROR VALIDASI --}}
        @if($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200
                        text-red-700 rounded-xl p-4">

                <div class="font-bold mb-2">
                    ⚠ Data belum dapat disimpan
                </div>

                <ul class="list-disc ml-5 text-sm space-y-1">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FLASH ERROR --}}
        @if(session('error'))

            <div class="mb-6 bg-red-50 border border-red-200
                        text-red-700 rounded-xl p-4">

                ⚠ {{ session('error') }}

            </div>

        @endif


        {{-- INFORMASI GURU --}}
        @if(auth()->user()->guru_id)

            <div class="mb-6 bg-blue-50 border border-blue-200
                        rounded-xl p-4">

                <div class="text-xs uppercase tracking-wide
                            text-blue-500 font-semibold">

                    Guru Penyusun

                </div>

                <div class="font-bold text-blue-900 mt-1">

                    {{ auth()->user()->guru->nama ?? auth()->user()->name }}

                </div>

                <div class="text-sm text-blue-700 mt-1">

                    Mata pelajaran dan tingkat yang tersedia
                    disesuaikan dengan penugasan mengajar Anda.

                </div>

            </div>

        @endif


        <form
            action="{{ route('modul-ajar.store') }}"
            method="POST">

            @csrf


            {{-- ADMIN PILIH GURU --}}
            @if(auth()->user()->guru_id == null)

                <div class="mb-6">

                    <label class="font-semibold text-slate-700">

                        Guru

                    </label>

                    <select
                        name="guru_id"
                        class="w-full border rounded-lg p-3 mt-2"
                        required>

                        <option value="">
                            -- Pilih Guru --
                        </option>

                        @foreach($gurus as $guru)

                            <option
                                value="{{ $guru->id }}"
                                {{ old('guru_id') == $guru->id ? 'selected' : '' }}>

                                {{ $guru->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>

            @endif


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                {{-- MATA PELAJARAN --}}
                <div>

                    <label class="font-semibold text-slate-700">

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

                            <option
                                value="{{ $m->id }}"
                                {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>

                                {{ $m->nama_mapel }}

                            </option>

                        @endforeach

                    </select>


                    @if(auth()->user()->guru_id && $mapel->isEmpty())

                        <p class="text-sm text-red-600 mt-2">

                            ⚠ Belum ada mata pelajaran yang
                            ditugaskan kepada Anda.

                        </p>

                    @endif

                </div>


                {{-- TAHUN AJARAN --}}
                <div>

                    <label class="font-semibold text-slate-700">

                        Tahun Ajaran Aktif

                    </label>

                    <input
                        type="text"
                        readonly
                        class="w-full border rounded-lg p-3 mt-2
                               bg-gray-100 text-gray-700"
                        value="{{ $tahun
                            ? $tahun->tahun_ajaran.' - '.$tahun->semester
                            : '-' }}">

                </div>


                {{-- TINGKAT --}}
                <div>

                    <label class="font-semibold text-slate-700">

                        Tingkat

                    </label>

                    <select
                        id="tingkat"
                        name="tingkat"
                        class="w-full border rounded-lg p-3 mt-2"
                        required>

                        <option value="">
                            -- Pilih Tingkat --
                        </option>

                        @foreach($tingkats as $tingkat)

                            <option
                                value="{{ $tingkat }}"
                                {{ old('tingkat') == $tingkat ? 'selected' : '' }}>

                                Kelas {{ $tingkat }}

                            </option>

                        @endforeach

                    </select>


                    @if(auth()->user()->guru_id && $tingkats->isEmpty())

                        <p class="text-sm text-red-600 mt-2">

                            ⚠ Belum ada kelas yang ditugaskan
                            kepada Anda.

                        </p>

                    @endif

                </div>


                {{-- SEMESTER --}}
                <div>

                    <label class="font-semibold text-slate-700">

                        Semester

                    </label>

                    <input
                        id="semester"
                        type="text"
                        readonly
                        class="w-full border rounded-lg p-3 mt-2
                               bg-gray-100 text-gray-700"
                        value="{{ $tahun->semester ?? '-' }}">

                    <p class="text-xs text-gray-500 mt-1">

                        Semester mengikuti Tahun Ajaran aktif.

                    </p>

                </div>


                {{-- JUDUL --}}
                <div class="md:col-span-2">

                    <label class="font-semibold text-slate-700">

                        Judul Modul

                    </label>

                    <input
                        id="judul"
                        type="text"
                        name="judul"
                        value="{{ old('judul') }}"
                        class="w-full border rounded-lg p-3 mt-2"
                        placeholder="Judul modul akan dibuat otomatis"
                        required>

                    <p class="text-xs text-gray-500 mt-1">

                        Judul dibuat otomatis berdasarkan
                        Mata Pelajaran, Tingkat, dan Semester.
                        Anda tetap dapat menyesuaikannya bila diperlukan.

                    </p>

                </div>


                {{-- KETERANGAN --}}
                <div class="md:col-span-2">

                    <label class="font-semibold text-slate-700">

                        Keterangan

                    </label>

                    <textarea
                        name="keterangan"
                        rows="5"
                        class="w-full border rounded-lg p-3 mt-2"
                        placeholder="Keterangan tambahan modul ajar (opsional)">{{ old('keterangan') }}</textarea>

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="mt-8 flex items-center gap-3">

                <button
                    type="submit"
                    @if(
                        auth()->user()->guru_id &&
                        ($mapel->isEmpty() || $tingkats->isEmpty())
                    )
                        disabled
                    @endif
                    class="bg-blue-600 hover:bg-blue-700
                           disabled:bg-gray-400
                           disabled:cursor-not-allowed
                           text-white px-8 py-3 rounded-lg">

                    💾 Simpan Modul

                </button>


                <a href="{{ route('modul-ajar.index') }}"
                   class="bg-gray-100 hover:bg-gray-200
                          text-gray-700 px-6 py-3 rounded-lg">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const mapel =
        document.getElementById('mapel');

    const tingkat =
        document.getElementById('tingkat');

    const semester =
        document.getElementById('semester');

    const judul =
        document.getElementById('judul');


    function updateJudul() {

        if (!mapel || !tingkat || !semester || !judul) {
            return;
        }


        if (
            !mapel.value ||
            !tingkat.value
        ) {

            /*
            | Jangan menghapus old input
            | setelah validasi gagal.
            */
            if (!judul.value) {
                judul.value = '';
            }

            return;
        }


        const namaMapel =
            mapel.options[
                mapel.selectedIndex
            ].text.trim();


        judul.value =
            namaMapel +
            ' Kelas ' +
            tingkat.value +
            ' Semester ' +
            semester.value;

    }


    if (mapel) {

        mapel.addEventListener(
            'change',
            updateJudul
        );

    }


    if (tingkat) {

        tingkat.addEventListener(
            'change',
            updateJudul
        );

    }


    updateJudul();

});

</script>

@endsection