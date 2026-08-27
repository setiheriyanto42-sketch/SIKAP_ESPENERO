@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="mb-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">

                    📖 Jurnal Mengajar

                </h1>

                <p class="text-gray-500 mt-1">

                    Riwayat kegiatan pembelajaran guru.

                </p>

            </div>

            <div class="bg-blue-50 text-blue-700 px-5 py-3 rounded-xl">

                Total Jurnal:

                <span class="font-bold">
                    {{ $jurnals->total() }}
                </span>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- NOTIFIKASI --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-xl">

            ✅ {{ session('success') }}

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- CARD --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">

        <div class="p-6 border-b">

            <h2 class="text-xl font-bold text-gray-800">

                📚 Daftar Jurnal Pembelajaran

            </h2>

            <p class="text-sm text-gray-500 mt-1">

                Jurnal terbentuk setelah guru menyelesaikan proses pembelajaran.

            </p>

        </div>


        {{-- ===================================================== --}}
        {{-- JIKA BELUM ADA JURNAL --}}
        {{-- ===================================================== --}}

        @if($jurnals->count() == 0)

            <div class="py-16 px-6 text-center">

                <div class="text-6xl mb-5">

                    📖

                </div>

                <h3 class="text-xl font-bold text-gray-700">

                    Belum Ada Jurnal Mengajar

                </h3>

                <p class="text-gray-500 mt-2 max-w-xl mx-auto">

                    Jurnal akan muncul di halaman ini setelah guru
                    melaksanakan pembelajaran dan menyimpan jurnal mengajar.

                </p>

                <a
                    href="{{ route('jadwal-mengajar.index') }}"
                    class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow">

                    🗓 Lihat Jadwal Mengajar

                </a>

            </div>


        @else


            {{-- ================================================= --}}
            {{-- TABLE --}}
            {{-- ================================================= --}}

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50 border-b">

                        <tr class="text-left text-sm text-gray-600">

                            <th class="px-5 py-4">
                                No
                            </th>

                            <th class="px-5 py-4">
                                Tanggal
                            </th>

                            <th class="px-5 py-4">
                                Guru
                            </th>

                            <th class="px-5 py-4">
                                Kelas
                            </th>

                            <th class="px-5 py-4">
                                Mata Pelajaran
                            </th>

                            <th class="px-5 py-4">
                                Materi
                            </th>

                            <th class="px-5 py-4 text-center">
                                Kehadiran
                            </th>

                            <th class="px-5 py-4 text-center">
                                Status
                            </th>

                            <th class="px-5 py-4 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @foreach($jurnals as $jurnal)

                            @php

                                $sesi = $jurnal->sesiMengajar;

                                $jadwal = $sesi?->jadwalMengajar;

                                $penugasan = $jadwal?->guruMengajar;

                                $guru = $penugasan?->guru;

                                $kelas = $penugasan?->kelas;

                                $mapel = $penugasan?->mataPelajaran;

                            @endphp


                            <tr class="hover:bg-gray-50">

                                {{-- NOMOR --}}

                                <td class="px-5 py-4 text-gray-500">

                                    {{ $jurnals->firstItem() + $loop->index }}

                                </td>


                                {{-- TANGGAL --}}

                                <td class="px-5 py-4 whitespace-nowrap">

                                    <div class="font-semibold text-gray-800">

                                        {{ $sesi?->tanggal
                                            ? \Carbon\Carbon::parse($sesi->tanggal)->format('d/m/Y')
                                            : '-' }}

                                    </div>

                                    @if($sesi?->jam_mulai)

                                        <div class="text-xs text-gray-500 mt-1">

                                            🕐
                                            {{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }}

                                            @if($sesi->jam_selesai)

                                                -
                                                {{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }}

                                            @endif

                                        </div>

                                    @endif

                                </td>


                                {{-- GURU --}}

                                <td class="px-5 py-4">

                                    <div class="font-semibold text-gray-800">

                                        {{ $guru->nama ?? '-' }}

                                    </div>

                                </td>


                                {{-- KELAS --}}

                                <td class="px-5 py-4">

                                    <span class="inline-flex bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold text-sm">

                                        {{ $kelas->nama_kelas ?? '-' }}

                                    </span>

                                </td>


                                {{-- MAPEL --}}

                                <td class="px-5 py-4">

                                    <div class="font-semibold">

                                        {{ $mapel->nama_mapel ?? '-' }}

                                    </div>

                                </td>


                                {{-- MATERI --}}

                                <td class="px-5 py-4">

                                    <div
                                        class="max-w-xs text-gray-700"
                                        title="{{ $jurnal->materi }}">

                                        {{ \Illuminate\Support\Str::limit(
                                            $jurnal->materi,
                                            70
                                        ) }}

                                    </div>

                                    @if($jurnal->tujuan)

                                        <div class="text-xs text-gray-400 mt-1">

                                            🎯 Ada tujuan pembelajaran

                                        </div>

                                    @endif

                                </td>


                                {{-- KEHADIRAN --}}

                                <td class="px-5 py-4">

                                    <div class="flex justify-center gap-2">

                                        <span
                                            title="Hadir"
                                            class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">

                                            ✓ {{ $jurnal->jumlah_hadir ?? 0 }}

                                        </span>

                                        <span
                                            title="Tidak Hadir"
                                            class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">

                                            ✕ {{ $jurnal->jumlah_tidak_hadir ?? 0 }}

                                        </span>

                                    </div>

                                </td>


                                {{-- STATUS --}}

                                <td class="px-5 py-4 text-center">

                                    @if($sesi?->status == 'Selesai')

                                        <span class="inline-flex bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">

                                            ✓ Selesai

                                        </span>

                                    @else

                                        <span class="inline-flex bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">

                                            ⏳ {{ $sesi->status ?? 'Proses' }}

                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}

                                <td class="px-5 py-4 text-center">

                                    <a
                                        href="{{ route(
                                            'jurnal-mengajar.edit',
                                            $jurnal
                                        ) }}"
                                        class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm shadow">

                                        ✏ Edit

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- ================================================= --}}
            {{-- PAGINATION --}}
            {{-- ================================================= --}}

            @if($jurnals->hasPages())

                <div class="p-5 border-t">

                    {{ $jurnals->links() }}

                </div>

            @endif


        @endif

    </div>

</div>

@endsection