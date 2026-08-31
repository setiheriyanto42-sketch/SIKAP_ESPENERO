@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h2 class="text-2xl font-bold text-slate-900">
                    📅 Pengaturan Jam Mulai
                </h2>

                <p class="text-gray-700 mt-1">
                    Template:
                    <strong class="text-slate-900">
                        {{ $templateJadwal->nama }}
                    </strong>
                </p>
            </div>

            <a href="{{ route('template-jadwal.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg shadow">

                ← Kembali

            </a>

        </div>


        {{-- CARD --}}
        <div class="bg-white shadow-lg rounded-xl p-6">

            {{-- INFORMASI --}}
            <div class="mb-6 bg-blue-50 border border-blue-300 rounded-lg p-5">

                <h3 class="font-bold text-blue-900 text-lg">
                    🕐 Jam Mulai Pembelajaran Setiap Hari
                </h3>

                <p class="text-blue-800 mt-2 text-sm leading-relaxed">

                    Atur waktu dimulainya JP 1 untuk masing-masing hari.
                    Sistem akan menggunakan waktu ini sebagai dasar
                    perhitungan jam pelajaran berikutnya.

                </p>

            </div>


            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('template-jadwal.update-hari', $templateJadwal) }}">

                @csrf


                <div class="overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead>

                            <tr class="bg-slate-800 text-white">

                                <th class="border border-slate-600 p-3 text-left">
                                    Hari
                                </th>

                                <th class="border border-slate-600 p-3 text-center">
                                    JP 1 Mulai
                                </th>

                                <th class="border border-slate-600 p-3 text-center">
                                    Aktif
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        @foreach($hari as $index => $namaHari)

                            @php

                                $dataHari = $templateJadwal
                                    ->templateHaris
                                    ->firstWhere('hari', $namaHari);

                                $jamMulai = $dataHari
                                    ? substr($dataHari->jam_mulai, 0, 5)
                                    : '07:00';

                                $aktif = $dataHari
                                    ? $dataHari->aktif
                                    : true;

                            @endphp


                            <tr class="hover:bg-blue-50">

                                {{-- HARI --}}
                                <td class="border border-gray-300 p-4">

                                    <input type="hidden"
                                           name="hari[]"
                                           value="{{ $namaHari }}">

                                    <span class="font-bold text-slate-900">
                                        {{ $namaHari }}
                                    </span>

                                </td>


                                {{-- JAM --}}
                                <td class="border border-gray-300 p-4 text-center">

                                    <input
                                        type="time"
                                        name="jam_mulai[]"
                                        value="{{ old('jam_mulai.'.$index, $jamMulai) }}"
                                        class="border-2 border-gray-400
                                               rounded-lg
                                               px-4 py-2
                                               text-slate-900
                                               bg-white
                                               font-semibold
                                               text-center
                                               focus:border-blue-500
                                               focus:ring-2
                                               focus:ring-blue-200"
                                    >

                                </td>


                                {{-- AKTIF --}}
                                <td class="border border-gray-300 p-4 text-center">

                                    <input
                                        type="checkbox"
                                        name="aktif[{{ $index }}]"
                                        value="1"
                                        class="w-5 h-5 accent-blue-600"
                                        {{ $aktif ? 'checked' : '' }}
                                    >

                                    <span class="ml-2 text-slate-800 font-medium">
                                        Aktif
                                    </span>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- TOMBOL --}}
                <div class="mt-8 flex justify-end gap-3">

                    <a href="{{ route('template-jadwal.index') }}"
                       class="bg-gray-600 hover:bg-gray-700
                              text-white
                              px-6 py-3
                              rounded-lg
                              font-semibold
                              shadow">

                        ← Kembali

                    </a>


                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700
                               text-white
                               px-7 py-3
                               rounded-lg
                               font-semibold
                               shadow">

                        💾 Simpan Pengaturan Hari

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection