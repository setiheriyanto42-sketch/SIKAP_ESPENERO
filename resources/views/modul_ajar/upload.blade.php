@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-6">

    <div class="bg-white rounded-xl shadow-lg p-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-8">

            <div>
                <h1 class="text-3xl font-bold text-slate-800">
                    📤 Upload RPP / Modul Ajar
                </h1>

                <p class="text-gray-500 mt-1">
                    Unggah dokumen pembelajaran yang sudah Anda miliki.
                </p>
            </div>

            <a href="{{ route('modul-ajar.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg">

                ← Kembali

            </a>

        </div>


        {{-- ERROR --}}
        @if(session('error'))

            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-6">
                ⚠️ {{ session('error') }}
            </div>

        @endif


        @if($errors->any())

            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-6">

                <div class="font-bold mb-2">
                    ⚠️ Dokumen belum dapat diunggah
                </div>

                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach

            </div>

        @endif


        {{-- INFO --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-8">

            <div class="font-bold text-blue-800 mb-2">
                🤖 Persiapan Analisis Dokumen
            </div>

            <p class="text-sm text-blue-700">
                Dokumen akan diunggah terlebih dahulu dan tidak langsung
                dimasukkan ke database Modul Ajar.
            </p>

            <p class="text-sm text-blue-700 mt-2">
                Setelah dokumen berhasil dibaca, Anda akan memeriksa hasilnya
                sebelum BAB dan Pertemuan disimpan.
            </p>

        </div>


        {{-- FORM UPLOAD --}}
        <form
            action="{{ route('modul-ajar.upload.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="border-2 border-dashed border-gray-300 rounded-xl p-10 text-center">

                <div class="text-5xl mb-4">
                    📄
                </div>

                <h2 class="text-xl font-bold text-gray-800">
                    Pilih Dokumen RPP / Modul Ajar
                </h2>

                <p class="text-gray-500 mt-2 mb-6">
                    Format yang didukung: PDF, DOC, DOCX
                </p>

                <input
                    type="file"
                    name="dokumen"
                    id="dokumen"
                    accept=".pdf,.doc,.docx"
                    required
                    class="block mx-auto border rounded-lg p-3 bg-gray-50">

                <p class="text-xs text-gray-400 mt-3">
                    Ukuran maksimal dokumen 10 MB
                </p>

            </div>


            <div class="flex justify-between items-center mt-8">

                <a
                    href="{{ route('modul-ajar.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg">

                    Batal

                </a>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-7 py-3 rounded-lg font-semibold">

                    📤 Upload & Periksa Dokumen

                </button>

            </div>

        </form>

    </div>

</div>

@endsection