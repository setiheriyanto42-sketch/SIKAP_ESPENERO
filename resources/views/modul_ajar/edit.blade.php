@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-6">

    <div class="bg-white rounded-xl shadow-lg p-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-start mb-8">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">
                    ✏ Edit Modul Ajar
                </h1>

                <p class="text-gray-500 mt-1">
                    Perbaiki judul atau keterangan Modul Ajar.
                </p>

            </div>

            <a
                href="{{ route('modul-ajar.index') }}"
                class="bg-gray-500 hover:bg-gray-600
                       text-white px-5 py-3 rounded-lg">

                ← Kembali

            </a>

        </div>


        {{-- ERROR --}}
        @if($errors->any())

            <div class="bg-red-50 border border-red-200
                        text-red-700 rounded-lg p-4 mb-6">

                <div class="font-semibold mb-2">
                    ⚠ Data belum dapat disimpan.
                </div>

                <ul class="list-disc ml-5 text-sm">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- INFORMASI MODUL --}}
        <div class="bg-blue-50 border border-blue-200
                    rounded-xl p-5 mb-7">

            <div class="text-xs font-bold text-blue-700 uppercase mb-3">
                Informasi Modul
            </div>

            <div class="grid md:grid-cols-4 gap-5">

                <div>

                    <div class="text-xs text-gray-500">
                        Guru
                    </div>

                    <div class="font-semibold">
                        {{ $modulAjar->guru->nama ?? '-' }}
                    </div>

                </div>


                <div>

                    <div class="text-xs text-gray-500">
                        Mata Pelajaran
                    </div>

                    <div class="font-semibold">
                        {{ $modulAjar->mataPelajaran->nama_mapel ?? '-' }}
                    </div>

                </div>


                <div>

                    <div class="text-xs text-gray-500">
                        Tingkat
                    </div>

                    <div class="font-semibold">
                        Kelas {{ $modulAjar->tingkat }}
                    </div>

                </div>


                <div>

                    <div class="text-xs text-gray-500">
                        Semester
                    </div>

                    <div class="font-semibold">
                        {{ $modulAjar->semester }}
                    </div>

                </div>

            </div>

            <div class="text-xs text-blue-600 mt-4">

                🔒 Guru, Mata Pelajaran, Tingkat dan Semester
                dikunci untuk menjaga konsistensi BAB dan Pertemuan.

            </div>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('modul-ajar.update', $modulAjar) }}"
            method="POST">

            @csrf
            @method('PUT')


            {{-- JUDUL --}}
            <div class="mb-6">

                <label class="block font-semibold text-gray-700 mb-2">

                    Judul Modul

                </label>

                <input
                    type="text"
                    name="judul"
                    value="{{ old('judul', $modulAjar->judul) }}"
                    required
                    class="w-full border border-gray-300
                           rounded-lg p-3
                           focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500">

                <div class="text-xs text-gray-500 mt-2">

                    Anda dapat memperbaiki judul tanpa mengubah BAB
                    dan Pertemuan yang sudah dibuat.

                </div>

            </div>


            {{-- KETERANGAN --}}
            <div class="mb-8">

                <label class="block font-semibold text-gray-700 mb-2">

                    Keterangan

                </label>

                <textarea
                    name="keterangan"
                    rows="6"
                    class="w-full border border-gray-300
                           rounded-lg p-3
                           focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500"
                    placeholder="Keterangan tambahan Modul Ajar (opsional)">{{ old('keterangan', $modulAjar->keterangan) }}</textarea>

            </div>


            {{-- BUTTON --}}
            <div class="flex gap-3">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700
                           text-white px-7 py-3 rounded-lg
                           shadow-sm">

                    💾 Simpan Perubahan

                </button>


                <a
                    href="{{ route('modul-ajar.show', $modulAjar) }}"
                    class="bg-gray-100 hover:bg-gray-200
                           text-gray-700 px-7 py-3 rounded-lg">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

@endsection