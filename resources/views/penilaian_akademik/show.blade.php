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
                    📊 Detail Penilaian Akademik
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Detail hasil penilaian pembelajaran siswa.
                </p>

            </div>


            <div class="flex gap-2">

                <a
                    href="{{ route('penilaian-akademik.index') }}"
                    class="inline-flex items-center
                           bg-gray-100 hover:bg-gray-200
                           text-gray-700 font-semibold
                           px-4 py-2 rounded-lg">

                    ← Kembali

                </a>


                <a
                    href="{{ route('penilaian-akademik.edit', $penilaian) }}"
                    class="inline-flex items-center
                           bg-amber-500 hover:bg-amber-600
                           text-white font-semibold
                           px-4 py-2 rounded-lg shadow-sm">

                    ✏ Edit Nilai

                </a>

            </div>

        </div>

    </div>


    {{-- FLASH SUCCESS --}}
    @if(session('success'))

        <div class="mb-5 px-4 py-3
                    bg-green-50 border border-green-200
                    text-green-700 rounded-xl text-sm">

            ✅ {{ session('success') }}

        </div>

    @endif


    {{-- INFORMASI PENILAIAN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6">

        <div class="px-6 py-5 border-b border-gray-200">

            <h2 class="font-bold text-gray-800">
                📚 Informasi Penilaian
            </h2>

        </div>


        <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">


                {{-- GURU --}}
                <div class="bg-gray-50 rounded-xl p-4">

                    <div class="text-xs text-gray-500 mb-1">
                        Guru
                    </div>

                    <div class="font-bold text-gray-800">
                        {{ $guru->nama ?? '-' }}
                    </div>

                </div>


                {{-- MAPEL --}}
                <div class="bg-blue-50 rounded-xl p-4">

                    <div class="text-xs text-blue-600 mb-1">
                        Mata Pelajaran
                    </div>

                    <div class="font-bold text-blue-800">

                        {{ $mapel->nama
                            ?? $mapel->nama_mapel
                            ?? '-' }}

                    </div>

                </div>


                {{-- KELAS --}}
                <div class="bg-indigo-50 rounded-xl p-4">

                    <div class="text-xs text-indigo-600 mb-1">
                        Kelas
                    </div>

                    <div class="font-bold text-indigo-800">

                        {{ $kelas->nama_kelas
                            ?? (($kelas->tingkat ?? '') . ($kelas->rombel ?? ''))
                            ?: '-' }}

                    </div>

                </div>


                {{-- TANGGAL --}}
                <div class="bg-green-50 rounded-xl p-4">

                    <div class="text-xs text-green-600 mb-1">
                        Tanggal
                    </div>

                    <div class="font-bold text-green-800">

                        {{ $penilaian->tanggal
                            ? \Carbon\Carbon::parse($penilaian->tanggal)->format('d/m/Y')
                            : '-' }}

                    </div>

                </div>

            </div>


            {{-- DETAIL PENILAIAN --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">


                {{-- JENIS --}}
                <div>

                    <div class="text-sm text-gray-500 mb-2">
                        Jenis Penilaian
                    </div>

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

                    <span class="inline-flex px-4 py-2
                                 rounded-full text-sm font-bold
                                 {{ $badge }}">

                        {{ $penilaian->jenis }}

                    </span>

                </div>


                {{-- JUDUL --}}
                <div>

                    <div class="text-sm text-gray-500 mb-2">
                        Judul Penilaian
                    </div>

                    <div class="font-bold text-gray-800">
                        {{ $penilaian->judul }}
                    </div>

                </div>


                {{-- PERTEMUAN --}}
                <div>

                    <div class="text-sm text-gray-500 mb-2">
                        Pertemuan
                    </div>

                    <div class="font-bold text-gray-800">

                        @if($penilaian->pertemuan)

                            Pertemuan
                            {{ $penilaian->pertemuan->pertemuan_ke }}

                        @else

                            -

                        @endif

                    </div>

                </div>

            </div>


            @if($penilaian->keterangan)

                <div class="mt-5 bg-yellow-50
                            border border-yellow-100
                            rounded-xl p-4">

                    <div class="text-xs text-yellow-700 mb-1">
                        Keterangan
                    </div>

                    <div class="text-sm text-gray-700">
                        {{ $penilaian->keterangan }}
                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- DAFTAR NILAI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-200">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="font-bold text-gray-800">
                        👨‍🎓 Daftar Nilai Siswa
                    </h2>

                    <p class="text-xs text-gray-500 mt-1">
                        Nilai yang sudah tersimpan pada penilaian ini.
                    </p>

                </div>


                <div class="bg-green-50 text-green-700
                            px-4 py-2 rounded-lg
                            text-sm font-bold">

                    {{ $penilaian->details->count() }} Siswa

                </div>

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

                        <th class="px-5 py-3 text-center">
                            Nilai
                        </th>

                        <th class="px-5 py-3 text-left">
                            Catatan
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse(
                        $penilaian->details->sortBy(
                            fn($detail) => $detail->siswa?->nama
                        )
                        as $index => $detail
                    )

                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-4 text-gray-500">

                                {{ $loop->iteration }}

                            </td>


                            <td class="px-5 py-4">

                                <div class="font-semibold text-gray-800">

                                    {{ $detail->siswa->nama ?? '-' }}

                                </div>

                            </td>


                            <td class="px-5 py-4 text-center">

                                @php

                                    $nilai = (float) $detail->nilai;

                                    $nilaiClass =
                                        $nilai >= 75
                                        ? 'bg-green-50 text-green-700'
                                        : 'bg-red-50 text-red-700';

                                @endphp

                                <span class="inline-flex
                                             min-w-[60px]
                                             justify-center
                                             px-3 py-2
                                             rounded-lg
                                             font-bold
                                             {{ $nilaiClass }}">

                                    {{ number_format($nilai, 0) }}

                                </span>

                            </td>


                            <td class="px-5 py-4 text-gray-600">

                                {{ $detail->catatan ?: '-' }}

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="px-6 py-12 text-center text-gray-500">

                                Belum ada nilai siswa tersimpan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection