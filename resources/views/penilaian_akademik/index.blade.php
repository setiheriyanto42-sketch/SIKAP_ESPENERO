@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    📊 Penilaian Akademik
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Daftar penilaian hasil pembelajaran siswa.
                </p>
            </div>

            <div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg text-sm font-semibold">
                Total Penilaian: {{ $penilaians->count() }}
            </div>

        </div>
    </div>


    {{-- FLASH SUCCESS --}}
    @if(session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200
                    text-green-700 rounded-xl text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif


    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        {{-- CARD HEADER --}}
        <div class="px-6 py-5 border-b border-gray-200">

            <h2 class="font-bold text-gray-800">
                📚 Daftar Nilai Pembelajaran
            </h2>

            <p class="text-xs text-gray-500 mt-1">
                Riwayat penilaian Tugas, Ulangan Harian, Praktik, dan Proyek.
            </p>

        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-50 text-gray-600">

                    <tr>

                        <th class="px-5 py-3 text-left font-semibold">
                            No
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Tanggal
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Guru
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Kelas
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Mata Pelajaran
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Jenis
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Judul Penilaian
                        </th>

                        <th class="px-5 py-3 text-center font-semibold">
                            Siswa Dinilai
                        </th>

                        <th class="px-5 py-3 text-center font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                @forelse($penilaians as $index => $penilaian)

                    @php

                        $guruMengajar =
                            $penilaian
                                ->sesiMengajar
                                ?->jadwalMengajar
                                ?->guruMengajar;

                        $guru =
                            $guruMengajar
                                ?->guru;

                        $kelas =
                            $guruMengajar
                                ?->kelas;

                        $mapel =
                            $guruMengajar
                                ?->mataPelajaran;

                    @endphp


                    <tr class="hover:bg-gray-50 transition">

                        {{-- NO --}}
                        <td class="px-5 py-4 text-gray-600">

                            {{ $index + 1 }}

                        </td>


                        {{-- TANGGAL --}}
                        <td class="px-5 py-4 whitespace-nowrap">

                            <div class="font-semibold text-gray-700">

                                {{ $penilaian->tanggal
                                    ? \Carbon\Carbon::parse($penilaian->tanggal)->format('d/m/Y')
                                    : '-' }}

                            </div>

                        </td>


                        {{-- GURU --}}
                        <td class="px-5 py-4">

                            <div class="font-semibold text-gray-800">

                                {{ $guru->nama ?? '-' }}

                            </div>

                        </td>


                        {{-- KELAS --}}
                        <td class="px-5 py-4">

                            <span class="inline-flex px-3 py-1 rounded-full
                                         bg-blue-50 text-blue-700
                                         text-xs font-semibold">

                                {{ $kelas->nama_kelas
                                    ?? (($kelas->tingkat ?? '') . ($kelas->rombel ?? ''))
                                    ?: '-' }}

                            </span>

                        </td>


                        {{-- MAPEL --}}
                        <td class="px-5 py-4">

                            <span class="font-medium text-gray-800">

                                {{ $mapel->nama ?? $mapel->nama_mapel ?? '-' }}

                            </span>

                        </td>


                        {{-- JENIS --}}
                        <td class="px-5 py-4">

                            @php

                                $badge = match($penilaian->jenis) {

                                    'UH' =>
                                        'bg-red-50 text-red-700',

                                    'Tugas' =>
                                        'bg-blue-50 text-blue-700',

                                    'Praktik' =>
                                        'bg-purple-50 text-purple-700',

                                    'Proyek' =>
                                        'bg-amber-50 text-amber-700',

                                    default =>
                                        'bg-gray-100 text-gray-700',

                                };

                            @endphp

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs font-bold
                                         {{ $badge }}">

                                {{ $penilaian->jenis }}

                            </span>

                        </td>


                        {{-- JUDUL --}}
                        <td class="px-5 py-4">

                            <div class="font-semibold text-gray-800">

                                {{ $penilaian->judul }}

                            </div>

                            @if($penilaian->keterangan)

                                <div class="text-xs text-gray-500 mt-1">

                                    {{ $penilaian->keterangan }}

                                </div>

                            @endif

                        </td>


                        {{-- JUMLAH SISWA --}}
                        <td class="px-5 py-4 text-center">

                            <span class="inline-flex items-center justify-center
                                         min-w-[36px] px-3 py-1
                                         rounded-full
                                         bg-green-50 text-green-700
                                         font-bold text-xs">

                                {{ $penilaian->details_count ?? 0 }}

                            </span>

                        </td>


                        {{-- AKSI --}}
                        <td class="px-5 py-4 text-center">

                            <div class="flex items-center justify-center gap-2">

                                <a
                                    href="{{ route('penilaian-akademik.show', $penilaian) }}"
                                    class="inline-flex items-center justify-center
                                        bg-blue-600 hover:bg-blue-700
                                        text-white px-3 py-2
                                        rounded-lg text-xs font-semibold
                                        transition">

                                    👁 Lihat

                                </a>

                                <a
                                    href="{{ route('penilaian-akademik.edit', $penilaian) }}"
                                    class="inline-flex items-center justify-center
                                        bg-amber-500 hover:bg-amber-600
                                        text-white px-3 py-2
                                        rounded-lg text-xs font-semibold
                                        transition">

                                    ✏ Edit

                                </a>

                            </div>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td colspan="9"
                            class="px-6 py-16 text-center">

                            <div class="text-4xl mb-3">
                                📭
                            </div>

                            <div class="font-bold text-gray-700">
                                Belum Ada Penilaian
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                Penilaian akan muncul setelah guru
                                menyimpan nilai siswa.
                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection