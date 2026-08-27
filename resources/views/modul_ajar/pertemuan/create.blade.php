@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                🚨 Tambah Pertemuan
            </h1>

            <p class="text-gray-500 mt-1">
                Tambahkan pertemuan baru yang tetap terintegrasi
                dengan Modul Ajar / RPP.
            </p>
        </div>

        <a
            href="{{ route('modul-ajar.show', $bab->modul_ajar_id) }}"
            class="px-4 py-2 rounded-lg bg-gray-500 text-white"
        >
            ← Kembali
        </a>

    </div>


    {{-- INFORMASI BAB --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-6">

        <div class="text-sm text-blue-600">
            Modul Ajar
        </div>

        <div class="font-bold text-lg text-gray-800">
            {{ $bab->modulAjar->judul ?? 'Modul Ajar' }}
        </div>

        <div class="mt-3 text-sm text-gray-600">

            BAB {{ $bab->nomor }}

            @if($bab->judul)
                — {{ $bab->judul }}
            @endif

        </div>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('modul-ajar.pertemuan.store', $bab) }}"
        class="bg-white rounded-xl shadow p-6"
    >

        @csrf


        {{-- NOMOR --}}
        <div class="mb-5">

            <label class="block font-semibold mb-2">
                Pertemuan Ke-
            </label>

            <input
                type="text"
                value="{{ $nomorBerikutnya }}"
                readonly
                class="w-full rounded-lg border-gray-300 bg-gray-100"
            >

            <p class="text-sm text-gray-500 mt-1">
                Nomor dibuat otomatis oleh sistem.
            </p>

        </div>


        {{-- JENIS --}}
        <div class="mb-5">

            <label class="block font-semibold mb-2">
                Jenis Pertemuan
            </label>

            <select
                name="jenis"
                class="w-full rounded-lg border-gray-300"
                required
            >

                <option value="tambahan">
                    🚨 Pertemuan Tambahan / Darurat
                </option>

                <option value="normal">
                    Pertemuan Normal
                </option>

                <option value="pengayaan">
                    Pengayaan
                </option>

                <option value="remedial">
                    Remedial
                </option>

            </select>

        </div>


        {{-- TANGGAL --}}
        <div class="mb-5">

            <label class="block font-semibold mb-2">
                Tanggal
            </label>

            <input
                type="date"
                name="tanggal"
                value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                class="w-full rounded-lg border-gray-300"
            >

        </div>


        {{-- TUJUAN --}}
        <div class="mb-5">

            <label class="block font-semibold mb-2">
                Tujuan Pembelajaran
            </label>

            <textarea
                name="tujuan"
                rows="4"
                class="w-full rounded-lg border-gray-300"
                placeholder="Tuliskan tujuan pembelajaran..."
            >{{ old('tujuan') }}</textarea>

        </div>


        {{-- MATERI --}}
        <div class="mb-5">

            <label class="block font-semibold mb-2">
                Materi
            </label>

            <textarea
                name="materi"
                rows="4"
                class="w-full rounded-lg border-gray-300"
                placeholder="Materi yang akan disampaikan..."
            >{{ old('materi') }}</textarea>

        </div>


        {{-- AKTIVITAS --}}
        <div class="mb-5">

            <label class="block font-semibold mb-2">
                Aktivitas Pembelajaran
            </label>

            <textarea
                name="aktivitas"
                rows="5"
                class="w-full rounded-lg border-gray-300"
                placeholder="Kegiatan pembelajaran..."
            >{{ old('aktivitas') }}</textarea>

        </div>


        {{-- ASESMEN --}}
        <div class="mb-5">

            <label class="block font-semibold mb-2">
                Asesmen / Penilaian
            </label>

            <textarea
                name="asesmen"
                rows="4"
                class="w-full rounded-lg border-gray-300"
                placeholder="Tugas, kuis, ulangan harian, penilaian..."
            >{{ old('asesmen') }}</textarea>

        </div>


        {{-- CATATAN --}}
        <div class="mb-6">

            <label class="block font-semibold mb-2">
                Catatan Guru
            </label>

            <textarea
                name="catatan"
                rows="4"
                class="w-full rounded-lg border-gray-300"
                placeholder="Catatan pembelajaran..."
            >{{ old('catatan') }}</textarea>

        </div>


        {{-- TOMBOL --}}
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('modul-ajar.show', $bab->modul_ajar_id) }}"
                class="px-5 py-2 rounded-lg bg-gray-500 text-white"
            >
                Batal
            </a>

            <button
                type="submit"
                class="px-5 py-2 rounded-lg bg-blue-600 text-white font-semibold"
            >
                💾 Simpan Pertemuan
            </button>

        </div>

    </form>

</div>

@endsection