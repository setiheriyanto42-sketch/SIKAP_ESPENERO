@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-6">

    {{-- ========================================================= --}}
    {{-- FLASH MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div class="bg-green-50 border border-green-300 text-green-700 p-4 rounded-lg mb-6">
            ✅ {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="bg-red-50 border border-red-300 text-red-700 p-4 rounded-lg mb-6">
            ⚠️ {{ session('error') }}
        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- CARD UTAMA --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-xl shadow-lg p-8">

        {{-- HEADER --}}

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-slate-800">
                🔎 Dokumen Berhasil Diunggah
            </h1>

            <p class="text-gray-500 mt-1">
                Periksa informasi dokumen sebelum dilanjutkan
                ke proses pembacaan dan analisis RPP.
            </p>

        </div>


        {{-- ===================================================== --}}
        {{-- INFORMASI DOKUMEN --}}
        {{-- ===================================================== --}}

        <div class="border rounded-xl overflow-hidden mb-8">

            <div class="bg-gray-50 px-6 py-4 border-b font-bold text-slate-700">
                📄 Informasi Dokumen
            </div>

            <div class="p-6 space-y-4">

                {{-- NAMA FILE --}}

                <div>

                    <div class="text-xs uppercase text-gray-400 font-semibold">
                        Nama File
                    </div>

                    <div class="font-semibold text-slate-800 mt-1">
                        {{ $dokumen['nama_asli'] }}
                    </div>

                </div>


                {{-- TIPE FILE --}}

                <div>

                    <div class="text-xs uppercase text-gray-400 font-semibold">
                        Tipe Dokumen
                    </div>

                    <div class="text-slate-700 mt-1">
                        {{ $dokumen['mime'] }}
                    </div>

                </div>


                {{-- UKURAN --}}

                <div>

                    <div class="text-xs uppercase text-gray-400 font-semibold">
                        Ukuran
                    </div>

                    <div class="text-slate-700 mt-1">
                        {{ number_format($dokumen['ukuran'] / 1024, 2) }} KB
                    </div>

                </div>


                {{-- STATUS --}}

                <div>

                    <div class="text-xs uppercase text-gray-400 font-semibold">
                        Status
                    </div>

                    <span
                        class="inline-flex items-center mt-2
                               bg-green-100 text-green-700
                               px-3 py-1 rounded-full
                               text-sm font-semibold">

                        ✓ Upload Berhasil

                    </span>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- INFORMASI ANALISIS --}}
        {{-- ===================================================== --}}

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">

            <div class="flex items-start gap-3">

                <div class="text-2xl">
                    🔍
                </div>

                <div class="flex-1">

                    <div class="font-bold text-blue-900 text-lg">
                        Dokumen Siap Diperiksa
                    </div>

                    <p class="text-sm text-blue-700 mt-2">

                        File berhasil diunggah tetapi
                        <strong>belum dimasukkan ke Modul Ajar.</strong>

                    </p>

                    <p class="text-sm text-blue-700 mt-2">

                        Klik tombol
                        <strong>Periksa & Analisis Dokumen</strong>
                        untuk membaca isi RPP dan mengenali struktur
                        pembelajaran di dalam dokumen.

                    </p>


                    {{-- DATA YANG AKAN DIBACA --}}

                    <div class="mt-5">

                        <div class="text-sm font-semibold text-blue-900">
                            Sistem akan mencoba mengenali:
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3 text-sm text-blue-800">

                            <div class="flex items-center gap-2">
                                <span>✓</span>
                                <span>Mata Pelajaran</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <span>✓</span>
                                <span>Kelas / Fase</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <span>✓</span>
                                <span>BAB / Materi</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <span>✓</span>
                                <span>Tujuan Pembelajaran</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <span>✓</span>
                                <span>Jumlah Pertemuan</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <span>✓</span>
                                <span>Aktivitas & Asesmen</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- PERINGATAN --}}
        {{-- ===================================================== --}}

        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8">

            <div class="flex gap-3">

                <div>
                    💡
                </div>

                <div>

                    <div class="font-semibold text-amber-800">
                        Dokumen belum disimpan ke Modul Ajar
                    </div>

                    <div class="text-sm text-amber-700 mt-1">

                        Hasil pembacaan dokumen akan ditampilkan terlebih
                        dahulu agar dapat diperiksa dan dikoreksi oleh guru
                        sebelum disimpan.

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- TOMBOL AKSI --}}
        {{-- ===================================================== --}}

        <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">

            {{-- BATALKAN UPLOAD --}}

            <form
                action="{{ route('modul-ajar.upload.cancel') }}"
                method="POST"
                onsubmit="return confirm('Batalkan upload dokumen ini?')">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    style="
                        background-color:#dc2626;
                        color:#ffffff;
                    "
                    class="w-full md:w-auto
                           inline-flex items-center justify-center gap-2
                           font-semibold
                           px-6 py-3
                           rounded-lg
                           shadow-sm
                           hover:shadow-md
                           transition">

                    <span>
                        🗑
                    </span>

                    <span>
                        Batalkan Upload
                    </span>

                </button>

            </form>


            {{-- PERIKSA DAN ANALISIS --}}

            <form
                action="{{ route('modul-ajar.upload.analyze') }}"
                method="POST">

                @csrf

                <button
                    type="submit"
                    style="
                        background-color:#4f46e5;
                        color:#ffffff;
                        min-width:310px;
                    "
                    class="w-full md:w-auto
                           inline-flex items-center justify-center
                           gap-3
                           font-semibold
                           px-7 py-3
                           rounded-lg
                           shadow-md
                           hover:shadow-lg
                           transition">

                    <span style="font-size:20px;">
                        🔍
                    </span>

                    <span class="text-left">

                        <span
                            style="
                                display:block;
                                color:#ffffff;
                                font-weight:700;
                            ">

                            Periksa & Analisis Dokumen

                        </span>

                        <span
                            style="
                                display:block;
                                color:#e0e7ff;
                                font-size:12px;
                                font-weight:400;
                                margin-top:2px;
                            ">

                            Lanjutkan ke pembacaan isi RPP

                        </span>

                    </span>

                    <span style="font-size:18px;">
                        →
                    </span>

                </button>

            </form>

        </div>

    </div>

</div>

@endsection