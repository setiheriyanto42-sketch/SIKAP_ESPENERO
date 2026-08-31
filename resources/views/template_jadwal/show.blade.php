@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>

                    <h1 class="text-3xl font-bold text-slate-800">
                        📅 {{ $templateJadwal->nama }}
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Detail susunan jam pelajaran berdasarkan hari.
                    </p>

                </div>

                <div class="flex gap-2">

                    <a href="{{ route('template-jadwal.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                        ← Kembali

                    </a>

                    <a href="{{ route('template-jadwal.edit', $templateJadwal) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg">

                        ✏ Edit

                    </a>

                </div>

            </div>

        </div>


        {{-- INFORMASI TEMPLATE --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">

            <h2 class="text-xl font-bold text-slate-800 mb-4">
                ⚙ Informasi Template
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

                <div class="bg-slate-50 border rounded-lg p-4">

                    <div class="text-sm text-gray-500">
                        Durasi JP
                    </div>

                    <div class="text-lg font-bold text-slate-800">
                        {{ $templateJadwal->durasi_jp }} Menit
                    </div>

                </div>


                <div class="bg-slate-50 border rounded-lg p-4">

                    <div class="text-sm text-gray-500">
                        Jumlah JP
                    </div>

                    <div class="text-lg font-bold text-slate-800">
                        {{ $templateJadwal->jumlah_jp }}
                    </div>

                </div>


                <div class="bg-slate-50 border rounded-lg p-4">

                    <div class="text-sm text-gray-500">
                        Istirahat
                    </div>

                    <div class="text-lg font-bold text-slate-800">

                        Setelah JP
                        {{ $templateJadwal->istirahat_setelah }}

                    </div>

                </div>


                <div class="bg-slate-50 border rounded-lg p-4">

                    <div class="text-sm text-gray-500">
                        Durasi Istirahat
                    </div>

                    <div class="text-lg font-bold text-slate-800">

                        {{ $templateJadwal->durasi_istirahat }} Menit

                    </div>

                </div>


                <div class="bg-slate-50 border rounded-lg p-4">

                    <div class="text-sm text-gray-500">
                        Ishoma
                    </div>

                    <div class="text-lg font-bold text-slate-800">

                        Setelah JP
                        {{ $templateJadwal->ishoma_setelah }}

                    </div>

                </div>

            </div>

        </div>


        {{-- JADWAL PER HARI --}}
        @php

            $urutanHari = [
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
            ];

        @endphp


        @foreach($urutanHari as $namaHari)

            @php

                $hari = $templateJadwal->hariMulai
                    ->firstWhere('hari', $namaHari);

            @endphp


            @if($hari && $hari->aktif)

                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">

                    {{-- HEADER HARI --}}
                    <div class="bg-slate-800 text-white px-6 py-4">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">

                            <div>

                                <h2 class="text-2xl font-bold">

                                    📅 {{ $namaHari }}

                                </h2>

                                <p class="text-slate-300 text-sm mt-1">

                                    Jam mulai:
                                    <strong>
                                        {{ substr($hari->jam_mulai, 0, 5) }}
                                    </strong>

                                </p>

                            </div>


                            <div>

                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">

                                    Aktif

                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- TABEL JP --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            <thead class="bg-slate-100">

                                <tr>

                                    <th class="px-4 py-3 text-center w-16">
                                        No
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Jenis
                                    </th>

                                    <th class="px-4 py-3 text-center">
                                        JP
                                    </th>

                                    <th class="px-4 py-3 text-center">
                                        Jam Mulai
                                    </th>

                                    <th class="px-4 py-3 text-center">
                                        Jam Selesai
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($hari->jamPelajaran->sortBy('jam_mulai') as $jam)

                                    <tr class="border-b hover:bg-blue-50">

                                        <td class="px-4 py-3 text-center">

                                            {{ $loop->iteration }}

                                        </td>


                                        <td class="px-4 py-3">

                                        @php
                                            $jenis = strtoupper(trim($jam->jenis ?? ''));
                                        @endphp

                                        @if($jenis === 'BELAJAR')

                                            <span class="inline-flex items-center
                                                        bg-blue-100 text-blue-700
                                                        px-3 py-1 rounded-full
                                                        text-sm font-semibold">

                                                📚 BELAJAR

                                            </span>

                                        @elseif(str_starts_with($jenis, 'ISTIRAHAT'))

                                            <span class="inline-flex items-center
                                                        bg-orange-100 text-orange-700
                                                        px-3 py-1 rounded-full
                                                        text-sm font-semibold">

                                                ☕ ISTIRAHAT

                                            </span>

                                        @elseif(str_starts_with($jenis, 'ISHOMA'))

                                            <span class="inline-flex items-center
                                                        bg-purple-100 text-purple-700
                                                        px-3 py-1 rounded-full
                                                        text-sm font-semibold">

                                                🕌 ISHOMA

                                            </span>

                                        @else

                                            <span class="inline-flex items-center
                                                        bg-gray-100 text-gray-700
                                                        px-3 py-1 rounded-full
                                                        text-sm font-semibold">

                                                {{ $jam->jenis }}

                                            </span>

                                        @endif

                                    </td>


                                        <td class="px-4 py-3 text-center font-semibold">

                                            @if($jenis === 'BELAJAR')

                                                {{ $jam->nomor_jp ?? $loop->iteration }}

                                            @else

                                                —

                                            @endif

                                        </td>


                                        <td class="px-4 py-3 text-center font-mono">

                                            {{ substr($jam->jam_mulai, 0, 5) }}

                                        </td>


                                        <td class="px-4 py-3 text-center font-mono font-semibold">

                                            {{ substr($jam->jam_selesai, 0, 5) }}

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="5"
                                            class="px-4 py-8 text-center text-gray-500">

                                            Belum ada jam pelajaran untuk hari ini.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            @endif

        @endforeach


        {{-- FOOTER --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-6">

            <div class="flex gap-3">

                <div class="text-2xl">
                    💡
                </div>

                <div>

                    <h3 class="font-bold text-blue-800">
                        Informasi
                    </h3>

                    <p class="text-sm text-blue-700 mt-1">

                        Jadwal di atas merupakan hasil Generate dari Template
                        <strong>{{ $templateJadwal->nama }}</strong>.
                        Pengaturan jam awal setiap hari dapat diubah melalui
                        menu <strong>Setting Hari</strong>, kemudian lakukan
                        Generate kembali.

                    </p>

                </div>

            </div>

        </div>


    </div>

</div>

@endsection