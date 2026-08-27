@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col md:flex-row
                md:items-center md:justify-between
                gap-4 mb-6">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                📚 Detail Modul Ajar
            </h1>

            <p class="text-gray-500 mt-1">
                Hasil analisis RPP / Modul Ajar
            </p>

        </div>

        <a
            href="{{ route('modul-ajar.index') }}"
            class="inline-flex items-center justify-center
                   bg-gray-600 hover:bg-gray-700
                   text-white font-semibold
                   px-5 py-3 rounded-lg
                   shadow-sm">

            ← Kembali

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- IDENTITAS MODUL --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-xl shadow
                overflow-hidden mb-6">

        <div class="bg-gradient-to-r
                    from-blue-600 to-indigo-600
                    text-white px-6 py-5">

            <h2 class="text-xl font-bold">
                📋 Identitas Modul
            </h2>

            <p class="text-blue-100 text-sm mt-1">
                Informasi utama Modul Ajar
            </p>

        </div>


        <div class="p-6">

            <div class="grid grid-cols-1
                        md:grid-cols-2
                        lg:grid-cols-3
                        gap-5">


                {{-- MATA PELAJARAN --}}
                <div class="border rounded-lg p-4">

                    <div class="text-sm text-gray-500 mb-1">
                        Mata Pelajaran
                    </div>

                    <div class="font-bold text-gray-800">
                        {{ $modulAjar->mata_pelajaran ?? '-' }}
                    </div>

                </div>


                {{-- KELAS --}}
                <div class="border rounded-lg p-4">

                    <div class="text-sm text-gray-500 mb-1">
                        Kelas
                    </div>

                    <div class="font-bold text-gray-800">
                        Kelas {{ $modulAjar->kelas ?? '-' }}
                    </div>

                </div>


                {{-- FASE --}}
                <div class="border rounded-lg p-4">

                    <div class="text-sm text-gray-500 mb-1">
                        Fase
                    </div>

                    <div class="font-bold text-gray-800">
                        {{ $modulAjar->fase ?? '-' }}
                    </div>

                </div>


                {{-- SEMESTER --}}
                <div class="border rounded-lg p-4">

                    <div class="text-sm text-gray-500 mb-1">
                        Semester
                    </div>

                    <div class="font-bold text-gray-800">
                        {{ $modulAjar->semester ?? '-' }}
                    </div>

                </div>


                {{-- TAHUN AJARAN --}}
                <div class="border rounded-lg p-4">

                    <div class="text-sm text-gray-500 mb-1">
                        Tahun Ajaran
                    </div>

                    <div class="font-bold text-gray-800">
                        {{ $modulAjar->tahun_ajaran ?? '-' }}
                    </div>

                </div>


                {{-- ALOKASI WAKTU --}}
                <div class="border rounded-lg p-4">

                    <div class="text-sm text-gray-500 mb-1">
                        Alokasi Waktu
                    </div>

                    @php

                        $alokasi =
                            $modulAjar->alokasi_waktu ?? [];

                    @endphp


                    @if(is_array($alokasi))

                        <div class="font-bold text-gray-800">

                            {{ $alokasi['jp'] ?? '-' }} JP

                        </div>

                        <div class="text-sm text-gray-500">

                            {{ $alokasi['total_menit'] ?? '-' }}
                            menit

                        </div>

                    @else

                        <div class="font-bold text-gray-800">
                            -
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- FILE ASLI --}}
    {{-- ========================================================= --}}

    @if($modulAjar->nama_file)

        <div class="bg-blue-50
                    border border-blue-200
                    rounded-xl p-4 mb-6">

            <div class="text-sm text-blue-600 font-semibold">
                📄 Dokumen sumber
            </div>

            <div class="text-blue-900 font-medium mt-1">

                {{ $modulAjar->nama_file }}

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- DAFTAR BAB --}}
    {{-- ========================================================= --}}

    <div class="mb-4">

        <h2 class="text-2xl font-bold text-gray-800">
            📖 Struktur BAB
        </h2>

        <p class="text-gray-500">
            BAB dan pertemuan yang berhasil dibaca dari dokumen.
        </p>

    </div>


    @forelse($modulAjar->bab as $bab)

        <div class="bg-white rounded-xl shadow
                    overflow-hidden mb-6">


            {{-- HEADER BAB --}}
            <div class="bg-gradient-to-r
                        from-indigo-600 to-purple-600
                        text-white px-6 py-5">

                <div class="text-sm text-indigo-100">
                    BAB {{ $bab->nomor }}
                </div>

                <h3 class="text-xl font-bold mt-1">

                    {{ $bab->judul }}

                </h3>

            </div>


            {{-- ISI BAB --}}
            <div class="p-6">

                @if($bab->isi)

                    <div class="mb-6">

                        <h4 class="font-bold
                                   text-gray-700 mb-2">

                            📄 Isi BAB

                        </h4>

                        <div class="bg-gray-50
                                    border rounded-lg
                                    p-4
                                    text-gray-700
                                    whitespace-pre-line">

                            {{ $bab->isi }}

                        </div>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- PERTEMUAN --}}
                {{-- ================================================= --}}

                <h4 class="text-lg font-bold
                           text-gray-800 mb-4">

                    📅 Pertemuan

                </h4>

                <a
                    href="{{ route('modul-ajar.pertemuan.create', $bab) }}"
                    class="inline-flex items-center px-4 py-2 mt-4 rounded-lg
                        bg-red-600 text-white font-semibold
                        hover:bg-red-700 transition"
                >
                    🚨 Tambah Pertemuan
                </a>


                @forelse($bab->pertemuans as $pertemuan)

                    <div class="border
                                border-gray-200
                                rounded-xl
                                p-5 mb-4">


                        <div class="flex items-center
                                    justify-between
                                    mb-5">

                            <h5 class="font-bold
                                       text-lg
                                       text-indigo-700">

                                Pertemuan
                                {{ $pertemuan->nomor }}

                            </h5>

                        </div>


                        <div class="grid grid-cols-1
                                    md:grid-cols-2
                                    gap-5">


                            {{-- TUJUAN --}}
                            <div>

                                <div class="font-semibold
                                            text-gray-700 mb-2">

                                    🎯 Tujuan

                                </div>

                                <div class="bg-gray-50
                                            rounded-lg
                                            p-4
                                            text-gray-600
                                            whitespace-pre-line">

                                    {{ $pertemuan->tujuan ?? '-' }}

                                </div>

                            </div>


                            {{-- MATERI --}}
                            <div>

                                <div class="font-semibold
                                            text-gray-700 mb-2">

                                    📚 Materi

                                </div>

                                <div class="bg-gray-50
                                            rounded-lg
                                            p-4
                                            text-gray-600
                                            whitespace-pre-line">

                                    {{ $pertemuan->materi ?? '-' }}

                                </div>

                            </div>


                            {{-- AKTIVITAS --}}
                            <div>

                                <div class="font-semibold
                                            text-gray-700 mb-2">

                                    📝 Aktivitas

                                </div>

                                <div class="bg-gray-50
                                            rounded-lg
                                            p-4
                                            text-gray-600
                                            whitespace-pre-line">

                                    {{ $pertemuan->aktivitas ?? '-' }}

                                </div>

                            </div>


                            {{-- ASESMEN --}}
                            <div>

                                <div class="font-semibold
                                            text-gray-700 mb-2">

                                    ✅ Asesmen

                                </div>

                                <div class="bg-gray-50
                                            rounded-lg
                                            p-4
                                            text-gray-600
                                            whitespace-pre-line">

                                    {{ $pertemuan->asesmen ?? '-' }}

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="bg-yellow-50
                                border border-yellow-200
                                rounded-lg
                                p-4
                                text-yellow-700">

                        ⚠️ Belum ada data pertemuan
                        untuk BAB ini.

                    </div>

                @endforelse

            </div>

        </div>

    @empty

        <div class="bg-white rounded-xl shadow
                    p-10 text-center">

            <div class="text-5xl mb-4">
                📭
            </div>

            <div class="font-bold
                        text-gray-700">

                Belum ada BAB

            </div>

            <div class="text-gray-500 mt-1">

                Struktur BAB belum tersedia
                pada Modul Ajar ini.

            </div>

        </div>

    @endforelse

</div>

@endsection