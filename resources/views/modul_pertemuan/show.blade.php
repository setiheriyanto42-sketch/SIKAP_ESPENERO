@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="bg-white rounded-xl shadow-lg p-8">

        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-3xl font-bold">

                    📘 {{ $pertemuan->judul }}

                </h1>

                <p class="text-gray-500 mt-2">

                    {{ $pertemuan->bab->modul->judul }}

                </p>

                <p class="text-sm text-gray-400">

                    BAB :
                    {{ $pertemuan->bab->nama_bab }}

                </p>

            </div>

            <a
                href="{{ route('modul-ajar.show',$pertemuan->bab->modul->id) }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-3 rounded-lg">

                ← Kembali

            </a>

        </div>


        <div class="grid grid-cols-2 gap-6">

            <div class="border rounded-xl p-5">

                <h2 class="font-bold text-lg mb-4">

                    📋 Informasi Pertemuan

                </h2>

                <table class="w-full">

                    <tr>

                        <td class="py-2 font-semibold">

                            Pertemuan

                        </td>

                        <td>

                            {{ $pertemuan->pertemuan_ke }}

                        </td>

                    </tr>

                    <tr>

                        <td class="py-2 font-semibold">

                            Judul

                        </td>

                        <td>

                            {{ $pertemuan->judul }}

                        </td>

                    </tr>

                    <tr>

                        <td class="py-2 font-semibold">

                            Status

                        </td>

                        <td>

                            @if($pertemuan->sudah_diajarkan)

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                    ✅ Sudah Mengajar

                                </span>

                            @else

                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                                    ⏳ Belum Mengajar

                                </span>

                            @endif

                        </td>

                    </tr>

                </table>

            </div>

            <div class="border rounded-xl p-5">

                <h2 class="font-bold text-lg mb-4">

                    📚 Materi

                </h2>

                <div class="border rounded-lg p-4 min-h-[170px]">

                    {!! nl2br(e($pertemuan->materi ?: 'Belum ada materi.')) !!}

                </div>

            </div>

        </div>


        <div class="grid grid-cols-4 gap-5 mt-8">

            <a
                href="#"
                class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl p-6 text-center shadow">

                📖

                <br><br>

                Materi

            </a>

            <a
                href="#"
                class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-6 text-center shadow">

                📝

                <br><br>

                LKPD

            </a>

            <a
                href="#"
                class="bg-orange-600 hover:bg-orange-700 text-white rounded-xl p-6 text-center shadow">

                ✔️

                <br><br>

                Penilaian

            </a>

            <a
                href="#"
                class="bg-purple-600 hover:bg-purple-700 text-white rounded-xl p-6 text-center shadow">

                🤖

                <br><br>

                ESPAI

            </a>

        </div>


        <div class="mt-10 flex gap-4">

            @if(!$pertemuan->sudah_diajarkan)

            <button
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg shadow">

                ▶ Mulai Mengajar

            </button>

            @else

            <button
                class="bg-green-600 text-white px-8 py-3 rounded-lg shadow">

                ✔ Pertemuan Selesai

            </button>

            @endif

        </div>

    </div>

</div>

@endsection