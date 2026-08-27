@extends('layouts.app')

@section('content')

@php
    use Illuminate\Support\Str;
@endphp

<div class="max-w-6xl mx-auto py-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-300 text-green-700
                    px-5 py-4 rounded-xl mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-300 text-red-700
                    px-5 py-4 rounded-xl mb-6">
            ⚠️ {{ session('error') }}
        </div>
    @endif


    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        {{-- HEADER --}}
        <div class="px-8 py-7 border-b">

            <div class="flex justify-between items-start gap-6">

                <div>

                    <h1 class="text-3xl font-bold text-slate-800">
                        🤖 Hasil Analisis Dokumen RPP
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Sistem telah membaca dokumen.
                        Periksa hasil sebelum dimasukkan ke Modul Ajar.
                    </p>

                </div>

                <span class="bg-green-100 text-green-700
                             px-4 py-2 rounded-full
                             text-sm font-semibold whitespace-nowrap">

                    ✓ Dokumen Terbaca

                </span>

            </div>

        </div>


        {{-- INFORMASI FILE --}}
        <div class="px-8 py-6 border-b bg-slate-50">

            <div class="grid md:grid-cols-3 gap-6">

                <div>

                    <div class="text-xs uppercase text-gray-400 mb-1">
                        Nama Dokumen
                    </div>

                    <div class="font-semibold text-slate-700">
                        {{ $hasil['nama_file'] }}
                    </div>

                </div>


                <div>

                    <div class="text-xs uppercase text-gray-400 mb-1">
                        Jumlah Karakter
                    </div>

                    <div class="font-semibold text-slate-700">
                        {{ number_format($hasil['jumlah_karakter']) }}
                        karakter
                    </div>

                </div>


                <div>

                    <div class="text-xs uppercase text-gray-400 mb-1">
                        Status
                    </div>

                    <div class="font-semibold text-green-600">
                        Siap Dianalisis Struktur RPP
                    </div>

                </div>

            </div>

        </div>


        {{-- STATUS TAHAP --}}
        <div class="px-8 pt-7">

            <div class="bg-blue-50 border border-blue-200
                        rounded-xl p-5">

                <div class="font-bold text-blue-800">
                    🔎 Tahap Pembacaan Berhasil
                </div>

                <p class="text-sm text-blue-700 mt-2">
                    Sistem berhasil mengambil teks dari dokumen.
                    Pada tahap berikutnya teks ini akan dipetakan
                    menjadi struktur Modul Ajar.
                </p>

                <div class="grid md:grid-cols-3 gap-3 mt-4 text-sm">

                    <div class="bg-white rounded-lg p-3">
                        ✓ Mata Pelajaran
                    </div>

                    <div class="bg-white rounded-lg p-3">
                        ✓ Kelas / Fase
                    </div>

                    <div class="bg-white rounded-lg p-3">
                        ✓ BAB / Materi
                    </div>

                    <div class="bg-white rounded-lg p-3">
                        ✓ Tujuan Pembelajaran
                    </div>

                    <div class="bg-white rounded-lg p-3">
                        ✓ Pertemuan
                    </div>

                    <div class="bg-white rounded-lg p-3">
                        ✓ Aktivitas & Asesmen
                    </div>

                </div>

            </div>

        </div>

        @if(!empty($struktur))

        <div class="mx-6 mb-6 border border-indigo-200 rounded-xl overflow-hidden">

            {{-- HEADER --}}
            <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-200">

                <div class="flex justify-between items-center">

                    <div>

                        <h2 class="font-bold text-lg text-slate-800">
                            🤖 Hasil Identifikasi Struktur RPP
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Periksa hasil pembacaan sistem. Data masih dapat dikoreksi sebelum disimpan.
                        </p>

                    </div>

                    <span class="bg-green-100 text-green-700
                                text-sm font-semibold
                                px-4 py-2 rounded-full">

                        ✓ Siap Diperiksa

                    </span>

                </div>

            </div>


            {{-- FORM IDENTITAS --}}
            <div class="p-6 bg-white">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- MAPEL --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Mata Pelajaran
                        </label>

                        <input
                            type="text"
                            value="{{ $struktur['mata_pelajaran'] ?? '' }}"
                            class="w-full border border-gray-300
                                rounded-lg px-4 py-3
                                focus:ring-2 focus:ring-indigo-500
                                focus:border-indigo-500">

                    </div>


                    {{-- KELAS --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kelas
                        </label>

                        <select
                            class="w-full border border-gray-300
                                rounded-lg px-4 py-3
                                focus:ring-2 focus:ring-indigo-500">

                            <option value="">-- Pilih Kelas --</option>

                            <option value="7"
                                @selected(($struktur['kelas'] ?? '') == '7')>
                                Kelas 7
                            </option>

                            <option value="8"
                                @selected(($struktur['kelas'] ?? '') == '8')>
                                Kelas 8
                            </option>

                            <option value="9"
                                @selected(($struktur['kelas'] ?? '') == '9')>
                                Kelas 9
                            </option>

                        </select>

                    </div>


                    {{-- FASE --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Fase
                        </label>

                        <input
                            type="text"
                            value="{{ $struktur['fase'] ?? '' }}"
                            class="w-full border border-gray-300
                                rounded-lg px-4 py-3">

                    </div>


                    {{-- SEMESTER --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Semester
                        </label>

                        <select
                            class="w-full border border-gray-300
                                rounded-lg px-4 py-3">

                            <option value="">
                                -- Pilih Semester --
                            </option>

                            <option value="Ganjil"
                                @selected(($struktur['semester'] ?? '') === 'Ganjil')>

                                Ganjil

                            </option>

                            <option value="Genap"
                                @selected(($struktur['semester'] ?? '') === 'Genap')>

                                Genap

                            </option>

                        </select>

                    </div>


                    {{-- TAHUN AJARAN --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tahun Ajaran
                        </label>

                        <input
                            type="text"
                            value="{{ $struktur['tahun_ajaran'] ?? '' }}"
                            placeholder="Contoh: 2026/2027"
                            class="w-full border border-gray-300
                                rounded-lg px-4 py-3">

                    </div>

                </div>


                {{-- INFORMASI --}}
                <div class="mt-6 bg-amber-50 border border-amber-200
                            rounded-lg p-4">

                    <div class="font-semibold text-amber-800">
                        💡 Periksa sebelum melanjutkan
                    </div>

                    <div class="text-sm text-amber-700 mt-1">
                        Hasil di atas diperoleh otomatis dari dokumen.
                        Guru dapat memperbaiki data apabila hasil pembacaan sistem belum tepat.
                    </div>

                </div>

            </div>

        </div>

        @endif

        @if(!empty($struktur['bab']))

        <div class="mt-6 border border-indigo-200 rounded-xl overflow-hidden">

            <div class="bg-indigo-50 px-6 py-4 border-b">

                <h2 class="font-bold text-lg text-indigo-800">
                    📚 BAB yang Ditemukan
                </h2>

                <p class="text-sm text-indigo-600">
                    AI berhasil mengenali struktur BAB pada dokumen.
                </p>

            </div>

            <div class="p-6 space-y-5">

                @foreach($struktur['bab'] as $bab)

                    <div class="border rounded-lg p-4">

                        <div class="font-bold text-indigo-700">

                            📘 BAB {{ $bab['nomor'] }}

                        </div>

                        <div class="text-gray-700 mt-1">

                            {{ $bab['judul'] }}

                        </div>

                        

                        @if(!empty($bab['section']))

                            @foreach($bab['section'] as $section)

                                <div class="mt-2 border rounded-lg p-3 bg-gray-50">

                                    <div class="font-semibold text-indigo-700">
                                        {{ strtoupper($section['nama']) }}
                                    </div>

                                    @if(!empty($section['isi']))

                                        <div class="text-sm text-gray-700 mt-1">

                                            {{ Str::limit($section['isi'],150) }}

                                        </div>

                                    @endif

                                </div>

                            @endforeach

                        @endif

                    </div>

                @endforeach

            </div>

        </div>

        @endif

        {{-- TEKS HASIL PARSER --}}
        <div class="px-8 py-7">

            <div class="flex justify-between items-center mb-4">

                <div>

                    <h2 class="text-xl font-bold text-slate-800">
                        📄 Teks yang Berhasil Dibaca
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Ini belum disimpan ke database Modul Ajar.
                    </p>

                </div>

            </div>


            <div class="border rounded-xl bg-gray-50
                        p-5 max-h-[500px] overflow-y-auto">

                <pre class="whitespace-pre-wrap
                            font-sans text-sm
                            leading-7 text-gray-700">{{ $hasil['teks'] }}</pre>

            </div>

        </div>


        {{-- PERINGATAN --}}
        <div class="px-8 pb-7">

            <div class="bg-amber-50 border border-amber-200
                        rounded-xl p-5">

                <div class="font-bold text-amber-800">
                    ⚠️ Belum Disimpan
                </div>

                <p class="text-sm text-amber-700 mt-2">
                    Dokumen ini masih berada pada tahap analisis.
                    Belum ada Modul, BAB, maupun Pertemuan yang dibuat
                    di database.
                </p>

            </div>

        </div>


        {{-- ACTION --}}
        <div class="px-8 py-6 border-t bg-gray-50
                    flex flex-col sm:flex-row
                    justify-between items-center gap-4">

            {{-- TOMBOL KEMBALI --}}
            <a
                href="{{ route('modul-ajar.upload.preview') }}"
                class="inline-flex items-center justify-center gap-2
                    bg-gray-600 hover:bg-gray-700
                    text-white font-semibold
                    px-6 py-3 rounded-lg
                    shadow-md transition">

                <span>←</span>

                <span>
                    Kembali
                </span>

            </a>


            {{-- TOMBOL SUSUN STRUKTUR RPP --}}
            
            <form
            action="{{ route('modul-ajar.upload.structure') }}"
            method="POST">

            @csrf

            <button
                type="submit"
                style="
                    background: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);
                    color: #ffffff;
                    border: none;
                    min-width: 280px;
                    padding: 14px 22px;
                    border-radius: 10px;
                    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.30);
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 12px;
                    font-family: inherit;
                "
                onmouseover="
                    this.style.transform='translateY(-1px)';
                    this.style.boxShadow='0 7px 18px rgba(37,99,235,0.38)';
                "
                onmouseout="
                    this.style.transform='translateY(0)';
                    this.style.boxShadow='0 4px 12px rgba(37,99,235,0.30)';
                ">

                <span style="font-size:22px;">
                    🤖
                </span>

                <span
                    style="
                        display:block;
                        text-align:left;
                        line-height:1.25;
                    ">

                    <span
                        style="
                            display:block;
                            font-size:14px;
                            font-weight:700;
                            color:#ffffff;
                        ">
                        💾 Simpan ke Database
                    </span>

                    <span
                        style="
                            display:block;
                            margin-top:3px;
                            font-size:11px;
                            font-weight:400;
                            color:#dbeafe;
                        ">
                        Simpan hasil analisis ke database
                    </span>

                </span>

                <span
                    style="
                        color:#ffffff;
                        font-size:18px;
                        margin-left:4px;
                    ">
                    →
                </span>

            </button>

        </form>

        </div>

    </div>

</div>

@endsection