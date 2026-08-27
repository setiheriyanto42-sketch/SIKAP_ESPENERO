@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    @php

        $guruMengajar = $penilaian
            ->sesiMengajar
            ?->jadwalMengajar
            ?->guruMengajar;

        $guru = $guruMengajar?->guru;

        $kelas = $guruMengajar?->kelas;

        $mapel = $guruMengajar?->mataPelajaran;

    @endphp


    {{-- HEADER --}}
    <div class="mb-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h1 class="text-2xl font-bold text-gray-800">
                    ✏ Edit Penilaian Akademik
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Perbarui identitas penilaian dan nilai siswa.
                </p>

            </div>

            <a
                href="{{ route('penilaian-akademik.show', $penilaian) }}"
                class="inline-flex items-center
                       bg-gray-100 hover:bg-gray-200
                       text-gray-700 font-semibold
                       px-4 py-2 rounded-lg">

                ← Kembali

            </a>

        </div>

    </div>


    {{-- ERROR VALIDASI --}}
    @if($errors->any())

        <div class="mb-6 bg-red-50 border border-red-200
                    text-red-700 rounded-xl p-4">

            <div class="font-bold mb-2">
                ⚠ Data belum dapat disimpan
            </div>

            <ul class="list-disc pl-5 text-sm space-y-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- INFORMASI PEMBELAJARAN --}}
    <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-500
                text-white rounded-2xl shadow-lg p-6 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

            <div>

                <div class="text-xs text-blue-100 uppercase">
                    Guru
                </div>

                <div class="font-bold mt-1">
                    {{ $guru->nama ?? '-' }}
                </div>

            </div>


            <div>

                <div class="text-xs text-blue-100 uppercase">
                    Mata Pelajaran
                </div>

                <div class="font-bold mt-1">

                    {{ $mapel->nama
                        ?? $mapel->nama_mapel
                        ?? '-' }}

                </div>

            </div>


            <div>

                <div class="text-xs text-blue-100 uppercase">
                    Kelas
                </div>

                <div class="font-bold mt-1">

                    {{ $kelas->nama_kelas
                        ?? (($kelas->tingkat ?? '') . ($kelas->rombel ?? ''))
                        ?: '-' }}

                </div>

            </div>


            <div>

                <div class="text-xs text-blue-100 uppercase">
                    Jumlah Siswa
                </div>

                <div class="font-bold mt-1">
                    {{ $siswas->count() }} Siswa
                </div>

            </div>

        </div>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('penilaian-akademik.update', $penilaian) }}">

        @csrf
        @method('PUT')


        {{-- IDENTITAS PENILAIAN --}}
        <div class="bg-white rounded-2xl shadow-sm
                    border border-gray-200 mb-6">

            <div class="px-6 py-5 border-b border-gray-200">

                <h2 class="font-bold text-gray-800">
                    📚 Identitas Penilaian
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Jenis dan informasi kegiatan penilaian.
                </p>

            </div>


            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                    {{-- JENIS --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Penilaian *
                        </label>

                        <select
                            name="jenis"
                            required
                            class="w-full rounded-lg border-gray-300
                                   focus:border-blue-500 focus:ring-blue-500">

                            <option value="">
                                -- Pilih Jenis --
                            </option>

                            <option
                                value="Tugas"
                                {{ old('jenis', $penilaian->jenis) === 'Tugas' ? 'selected' : '' }}>
                                📝 Tugas
                            </option>

                            <option
                                value="UH"
                                {{ old('jenis', $penilaian->jenis) === 'UH' ? 'selected' : '' }}>
                                📋 Ulangan Harian (UH)
                            </option>

                            <option
                                value="Praktik"
                                {{ old('jenis', $penilaian->jenis) === 'Praktik' ? 'selected' : '' }}>
                                🧪 Praktik
                            </option>

                            <option
                                value="Proyek"
                                {{ old('jenis', $penilaian->jenis) === 'Proyek' ? 'selected' : '' }}>
                                🚀 Proyek
                            </option>

                        </select>

                    </div>


                    {{-- TANGGAL --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Penilaian *
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            required
                            value="{{ old(
                                'tanggal',
                                $penilaian->tanggal
                                    ? $penilaian->tanggal->format('Y-m-d')
                                    : ''
                            ) }}"
                            class="w-full rounded-lg border-gray-300
                                   focus:border-blue-500 focus:ring-blue-500">

                    </div>


                    {{-- JUDUL --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Judul Penilaian *
                        </label>

                        <input
                            type="text"
                            name="judul"
                            required
                            value="{{ old('judul', $penilaian->judul) }}"
                            class="w-full rounded-lg border-gray-300
                                   focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: Ulangan Harian Bilangan">

                    </div>


                    {{-- KETERANGAN --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            rows="2"
                            class="w-full rounded-lg border-gray-300
                                   focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Opsional...">{{ old('keterangan', $penilaian->keterangan) }}</textarea>

                    </div>

                </div>

            </div>

        </div>


        {{-- NILAI SISWA --}}
        <div class="bg-white rounded-2xl shadow-sm
                    border border-gray-200 overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-200">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="font-bold text-gray-800">
                            👨‍🎓 Daftar Nilai Siswa
                        </h2>

                        <p class="text-xs text-gray-500 mt-1">
                            Ubah nilai 0–100 dan catatan bila diperlukan.
                        </p>

                    </div>

                    <span class="bg-blue-50 text-blue-700
                                 px-4 py-2 rounded-full
                                 text-xs font-bold">

                        {{ $siswas->count() }} Siswa

                    </span>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-50 text-gray-600">

                        <tr>

                            <th class="px-5 py-3 text-left">
                                No
                            </th>

                            <th class="px-5 py-3 text-left">
                                Nama Siswa
                            </th>

                            <th class="px-5 py-3 text-center w-40">
                                Nilai
                            </th>

                            <th class="px-5 py-3 text-left">
                                Catatan
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                    @forelse($siswas as $siswa)

                        @php

                            $detail =
                                $details->get($siswa->id);

                        @endphp


                        <tr class="hover:bg-gray-50">

                            {{-- NOMOR --}}
                            <td class="px-5 py-4 text-gray-500">

                                {{ $loop->iteration }}

                            </td>


                            {{-- SISWA --}}
                            <td class="px-5 py-4">

                                <div class="font-semibold text-gray-800">

                                    {{ $siswa->nama }}

                                </div>

                                @if($siswa->nis)

                                    <div class="text-xs text-gray-500 mt-1">

                                        NIS {{ $siswa->nis }}

                                    </div>

                                @endif

                            </td>


                            {{-- NILAI --}}
                            <td class="px-5 py-4">

                                <input
                                    type="number"
                                    name="nilai[{{ $siswa->id }}]"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    value="{{ old(
                                        'nilai.' . $siswa->id,
                                        $detail?->nilai
                                    ) }}"
                                    class="w-full text-center font-bold
                                           rounded-lg border-gray-300
                                           focus:border-blue-500
                                           focus:ring-blue-500"
                                    placeholder="0-100">

                            </td>


                            {{-- CATATAN --}}
                            <td class="px-5 py-4">

                                <input
                                    type="text"
                                    name="catatan[{{ $siswa->id }}]"
                                    value="{{ old(
                                        'catatan.' . $siswa->id,
                                        $detail?->catatan
                                    ) }}"
                                    class="w-full rounded-lg border-gray-300
                                           focus:border-blue-500
                                           focus:ring-blue-500"
                                    placeholder="Catatan opsional">

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="px-6 py-14 text-center">

                                <div class="text-4xl mb-3">
                                    👨‍🎓
                                </div>

                                <div class="font-bold text-gray-700">
                                    Siswa tidak ditemukan
                                </div>

                                <div class="text-sm text-gray-500 mt-1">
                                    Belum ada siswa aktif pada kelas ini.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- FOOTER FORM --}}
            <div class="px-6 py-5 bg-gray-50
                        border-t border-gray-200">

                <div class="flex flex-col sm:flex-row
                            justify-end gap-3">

                    <a
                        href="{{ route('penilaian-akademik.show', $penilaian) }}"
                        class="inline-flex items-center justify-center
                               px-5 py-3
                               bg-white border border-gray-300
                               text-gray-700 font-semibold
                               rounded-xl hover:bg-gray-100">

                        Batal

                    </a>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center
                               px-6 py-3
                               bg-blue-600 hover:bg-blue-700
                               text-white font-bold
                               rounded-xl shadow-sm transition">

                        💾 Simpan Perubahan

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection