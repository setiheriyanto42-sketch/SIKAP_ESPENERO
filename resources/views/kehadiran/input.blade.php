@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-5xl mx-auto px-4">

        {{-- ========================= --}}
        {{-- NOTIFIKASI --}}
        {{-- ========================= --}}

        @if(session('success'))

            <div class="mb-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                ✅ {{ session('success') }}

            </div>

        @endif


        @if($errors->any())

            <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                <div class="font-bold mb-2">
                    Terjadi kesalahan:
                </div>

                <ul class="list-disc ml-5">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <div class="bg-white shadow rounded-xl p-6">

            {{-- ========================= --}}
            {{-- JUDUL --}}
            {{-- ========================= --}}

            <div class="mb-6">

                <h1 class="text-2xl font-bold text-gray-900">

                    📋 Input Kehadiran Siswa

                </h1>

                <p class="text-gray-500 mt-1">

                    Pilih tanggal, kelas, dan mata pelajaran.

                </p>

            </div>


            {{-- ========================= --}}
            {{-- FILTER --}}
            {{-- ========================= --}}

            <form
                method="GET"
                action="{{ route('kehadiran.input') }}">

                <div class="grid md:grid-cols-3 gap-4">


                    {{-- TANGGAL --}}

                    <div>

                        <label class="block font-semibold mb-2">

                            Tanggal

                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ request('tanggal', date('Y-m-d')) }}"
                            class="border border-gray-300 rounded-lg w-full p-2.5">

                    </div>


                    {{-- KELAS --}}

                    <div>

                        <label class="block font-semibold mb-2">

                            Kelas

                        </label>

                        <select
                            name="kelas_id"
                            class="border border-gray-300 rounded-lg w-full p-2.5">

                            <option value="">

                                -- Pilih Kelas --

                            </option>

                            @foreach($kelas as $k)

                                <option
                                    value="{{ $k->id }}"
                                    {{ (string) request('kelas_id') === (string) $k->id ? 'selected' : '' }}>

                                    {{ $k->nama_kelas }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- MAPEL --}}

                    <div>

                        <label class="block font-semibold mb-2">

                            Mata Pelajaran

                        </label>

                        <select
                            name="mapel_id"
                            class="border border-gray-300 rounded-lg w-full p-2.5">

                            <option value="">

                                -- Pilih Mata Pelajaran --

                            </option>

                            @foreach($mapel as $m)

                                <option
                                    value="{{ $m->id }}"
                                    {{ (string) request('mapel_id') === (string) $m->id ? 'selected' : '' }}>

                                    {{ $m->nama_mapel }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                <div class="mt-4 flex justify-end">

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg">

                        🔍 Tampilkan Siswa

                    </button>

                </div>

            </form>


            <hr class="my-6">


            {{-- ========================= --}}
            {{-- DATA SISWA --}}
            {{-- ========================= --}}

            @if(
                request('kelas_id') &&
                request('mapel_id')
            )


                @if(count($siswas) > 0)


                    {{-- HEADER DAFTAR SISWA --}}

                    <div class="mb-5 flex justify-between items-center">

                        <div>

                            <h2 class="text-lg font-bold">

                                👨‍🎓 Daftar Siswa

                            </h2>

                            <p class="text-sm text-gray-500">

                                {{ count($siswas) }}
                                siswa ditemukan.

                            </p>

                        </div>


                        @if($kehadiranTersimpan->count() > 0)

                            <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">

                                ✏ Data Kehadiran Tersimpan

                            </div>

                        @else

                            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">

                                Default: Hadir

                            </div>

                        @endif

                    </div>


                    {{-- ========================= --}}
                    {{-- FORM KEHADIRAN --}}
                    {{-- ========================= --}}

                    <form
                        method="POST"
                        action="{{ route('kehadiran.simpan') }}">

                        @csrf


                        {{-- FILTER TERSEMBUNYI --}}

                        <input
                            type="hidden"
                            name="tanggal"
                            value="{{ request('tanggal', date('Y-m-d')) }}">

                        <input
                            type="hidden"
                            name="kelas_id"
                            value="{{ request('kelas_id') }}">

                        <input
                            type="hidden"
                            name="mapel_id"
                            value="{{ request('mapel_id') }}">


                        {{-- ========================= --}}
                        {{-- DAFTAR SISWA --}}
                        {{-- ========================= --}}

                        <div class="space-y-3">

                            @foreach($siswas as $siswa)

                                @php

                                    $record =
                                        $kehadiranTersimpan
                                            ->get($siswa->id);

                                    $statusSekarang =
                                        $record
                                            ? $record->status
                                            : 'Hadir';

                                @endphp


                                <div class="border border-gray-200 rounded-xl p-4 hover:bg-gray-50">

                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">


                                        {{-- SISWA --}}

                                        <div class="flex items-center gap-4">

                                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">

                                                {{ $loop->iteration }}

                                            </div>


                                            <div>

                                                <div class="font-bold text-gray-900">

                                                    {{ $siswa->nama }}

                                                </div>

                                                <div class="text-sm text-gray-500">

                                                    NIS:
                                                    {{ $siswa->nis ?: '-' }}

                                                </div>

                                            </div>

                                        </div>


                                        {{-- STATUS --}}

                                        <div class="flex items-center gap-3">

                                            <input
                                                type="hidden"
                                                name="siswa_id[]"
                                                value="{{ $siswa->id }}">


                                            <label class="text-sm font-semibold text-gray-600">

                                                Status

                                            </label>


                                            <select
                                                name="status[]"
                                                class="border border-gray-300 rounded-lg p-2 min-w-[170px]">


                                                <option
                                                    value="Hadir"
                                                    {{ $statusSekarang === 'Hadir' ? 'selected' : '' }}>

                                                    ✅ Hadir

                                                </option>


                                                <option
                                                    value="Izin"
                                                    {{ $statusSekarang === 'Izin' ? 'selected' : '' }}>

                                                    📝 Izin

                                                </option>


                                                <option
                                                    value="Sakit"
                                                    {{ $statusSekarang === 'Sakit' ? 'selected' : '' }}>

                                                    🤒 Sakit

                                                </option>


                                                <option
                                                    value="Alfa"
                                                    {{ $statusSekarang === 'Alfa' ? 'selected' : '' }}>

                                                    ❌ Alfa

                                                </option>


                                                <option
                                                    value="Membolos"
                                                    {{ $statusSekarang === 'Membolos' ? 'selected' : '' }}>

                                                    🚫 Membolos

                                                </option>


                                                <option
                                                    value="Terlambat"
                                                    {{ $statusSekarang === 'Terlambat' ? 'selected' : '' }}>

                                                    ⏰ Terlambat

                                                </option>

                                            </select>


                                            @if($record)

                                                <span
                                                    title="Data sudah tersimpan"
                                                    class="text-green-600 font-bold">

                                                    ✓

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        {{-- ========================= --}}
                        {{-- SIMPAN --}}
                        {{-- ========================= --}}

                        <div class="mt-6 flex justify-end">

                            <button
                                type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-lg shadow">

                                @if($kehadiranTersimpan->count() > 0)

                                    💾 Update Kehadiran

                                @else

                                    💾 Simpan Kehadiran

                                @endif

                            </button>

                        </div>

                    </form>


                @else

                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 p-4 rounded-lg">

                        ⚠️ Tidak ada siswa yang ditemukan pada kelas tersebut.

                    </div>

                @endif


            @else

                <div class="bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded-lg">

                    ℹ️ Pilih
                    <strong>kelas</strong>
                    dan
                    <strong>mata pelajaran</strong>,
                    kemudian klik
                    <strong>Tampilkan Siswa</strong>.

                </div>

            @endif

        </div>

    </div>

</div>

@endsection