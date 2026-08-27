@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    ✏️ Edit Jurnal Mengajar
                </h1>

                <p class="text-gray-500 mt-1">
                    Perbarui catatan pelaksanaan pembelajaran.
                </p>
            </div>

            <a
                href="{{ route('jurnal-mengajar.index') }}"
                class="inline-flex items-center justify-center
                       bg-gray-100 hover:bg-gray-200
                       text-gray-700 px-5 py-3 rounded-lg">

                ← Kembali

            </a>

        </div>

    </div>


    {{-- ERROR VALIDASI --}}
    @if ($errors->any())

        <div class="mb-6 bg-red-50 border border-red-300
                    text-red-700 rounded-xl p-5">

            <div class="font-bold mb-2">
                ⚠ Data belum dapat disimpan
            </div>

            <ul class="list-disc ml-5 text-sm">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- INFORMASI PEMBELAJARAN --}}
    <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-500
                text-white rounded-xl shadow-lg p-6 mb-6">

        @php

            $sesi = $jurnal->sesiMengajar;

            $jadwal = $sesi?->jadwalMengajar;

            $penugasan = $jadwal?->guruMengajar;

            $guru = $penugasan?->guru;

            $kelas = $penugasan?->kelas;

            $mapel = $penugasan?->mataPelajaran;

        @endphp


        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

            <div>

                <div class="text-xs opacity-80">
                    Guru
                </div>

                <div class="font-bold mt-1">
                    {{ $guru->nama ?? '-' }}
                </div>

            </div>


            <div>

                <div class="text-xs opacity-80">
                    Mata Pelajaran
                </div>

                <div class="font-bold mt-1">
                    {{ $mapel->nama_mapel ?? '-' }}
                </div>

            </div>


            <div>

                <div class="text-xs opacity-80">
                    Kelas
                </div>

                <div class="font-bold mt-1">
                    {{ $kelas->nama_kelas ?? '-' }}
                </div>

            </div>


            <div>

                <div class="text-xs opacity-80">
                    Tanggal
                </div>

                <div class="font-bold mt-1">

                    {{ $sesi?->tanggal
                        ? \Carbon\Carbon::parse($sesi->tanggal)->format('d/m/Y')
                        : '-' }}

                </div>

            </div>

        </div>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('jurnal-mengajar.update', $jurnal) }}">

        @csrf
        @method('PUT')


        {{-- RENCANA PEMBELAJARAN --}}
        <div class="bg-white rounded-xl shadow border mb-6">

            <div class="border-b px-6 py-4">

                <h2 class="font-bold text-lg text-gray-800">
                    📚 Rencana Pembelajaran
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Rencana pembelajaran yang digunakan pada jurnal ini.
                </p>

            </div>


            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- TUJUAN --}}
                    <div class="bg-blue-50 border border-blue-100
                                rounded-xl p-5">

                        <div class="font-bold text-blue-800 mb-2">
                            🎯 Tujuan Pembelajaran
                        </div>

                        <div class="text-sm text-gray-700 whitespace-pre-line">

                            {{ $jurnal->tujuan ?: '-' }}

                        </div>

                    </div>


                    {{-- MATERI --}}
                    <div class="bg-indigo-50 border border-indigo-100
                                rounded-xl p-5">

                        <div class="font-bold text-indigo-800 mb-2">
                            📘 Materi Rencana
                        </div>

                        <div class="text-sm text-gray-700 whitespace-pre-line">

                            {{ $jurnal->materi ?: '-' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- PELAKSANAAN PEMBELAJARAN --}}
        <div class="bg-white rounded-xl shadow border mb-6">

            <div class="border-b px-6 py-4">

                <h2 class="font-bold text-lg text-gray-800">
                    ✏️ Pelaksanaan Pembelajaran
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Perbarui hasil pelaksanaan pembelajaran.
                </p>

            </div>


            <div class="p-6">


                {{-- KEHADIRAN --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-7">

                    <div class="bg-green-50 border border-green-200
                                rounded-xl p-5 text-center">

                        <div class="text-sm text-green-700">
                            Hadir
                        </div>

                        <div class="text-3xl font-bold text-green-700 mt-1">
                            {{ $jurnal->jumlah_hadir ?? 0 }}
                        </div>

                    </div>


                    <div class="bg-red-50 border border-red-200
                                rounded-xl p-5 text-center">

                        <div class="text-sm text-red-700">
                            Tidak Hadir
                        </div>

                        <div class="text-3xl font-bold text-red-700 mt-1">
                            {{ $jurnal->jumlah_tidak_hadir ?? 0 }}
                        </div>

                    </div>

                </div>


                {{-- MATERI TERCAPAI --}}
                <div class="mb-6">

                    <label class="block font-bold text-gray-800 mb-2">

                        📌 Materi Hari Ini Sampai Mana?

                    </label>

                    <p class="text-sm text-gray-500 mb-2">

                        Tuliskan materi yang benar-benar berhasil
                        disampaikan pada pertemuan ini.

                    </p>

                    <textarea
                        name="materi_tercapai"
                        rows="5"
                        required
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Materi yang telah tercapai...">{{ old('materi_tercapai', $jurnal->materi_tercapai ?? $jurnal->materi) }}</textarea>

                </div>


                {{-- CATATAN --}}
                <div class="mb-6">

                    <label class="block font-bold text-gray-800 mb-2">

                        📝 Catatan Guru

                    </label>

                    <p class="text-sm text-gray-500 mb-2">

                        Catatan kondisi pembelajaran atau hal penting
                        selama proses belajar.

                    </p>

                    <textarea
                        name="catatan"
                        rows="4"
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Catatan guru...">{{ old('catatan', $jurnal->catatan) }}</textarea>

                </div>


                {{-- REFLEKSI --}}
                <div class="mb-2">

                    <label class="block font-bold text-gray-800 mb-2">

                        💡 Refleksi Pembelajaran

                    </label>

                    <p class="text-sm text-gray-500 mb-2">

                        Catat hasil refleksi setelah pembelajaran selesai.

                    </p>

                    <textarea
                        name="refleksi"
                        rows="4"
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Refleksi pembelajaran...">{{ old('refleksi', $jurnal->refleksi) }}</textarea>

                </div>

            </div>

        </div>


        {{-- TOMBOL --}}
        <div class="bg-white rounded-xl shadow border p-6">

            <div class="flex flex-col md:flex-row
                        md:items-center md:justify-between gap-4">

                <a
                    href="{{ route('jurnal-mengajar.index') }}"
                    class="inline-flex justify-center
                           bg-gray-100 hover:bg-gray-200
                           text-gray-700 font-semibold
                           px-6 py-3 rounded-lg">

                    ← Batal

                </a>


                <button
                    type="submit"
                    class="inline-flex justify-center
                           bg-green-600 hover:bg-green-700
                           text-white font-semibold
                           px-8 py-3 rounded-lg shadow">

                    💾 Simpan Perubahan Jurnal

                </button>

            </div>

        </div>

    </form>

</div>

@endsection