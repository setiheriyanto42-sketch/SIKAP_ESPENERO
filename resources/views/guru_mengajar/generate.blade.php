@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-7xl mx-auto">

        <div class="bg-white rounded-xl shadow-lg p-6">

            <div class="flex justify-between items-center mb-6">

                <div>

                    <h1 class="text-3xl font-bold text-slate-800">

                        ⚙ Generate Jadwal Mengajar

                    </h1>

                    <p class="text-gray-500 mt-2">

                        Generate otomatis jadwal mengajar berdasarkan jumlah JP setiap guru.

                    </p>

                </div>

                <a href="{{ route('guru-mengajar.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg shadow">

                    ← Kembali

                </a>

            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">

                <table class="min-w-full border border-gray-200">

                    <thead class="bg-slate-800 text-white">

                        <tr>

                            <th class="border border-gray-300 px-4 py-3 text-center w-16">

                                No

                            </th>

                            <th class="border border-gray-300 px-4 py-3 text-left">

                                Guru

                            </th>

                            <th class="border border-gray-300 px-4 py-3 text-left">

                                Mata Pelajaran

                            </th>

                            <th class="border border-gray-300 px-4 py-3 text-center">

                                Kelas

                            </th>

                            <th class="border border-gray-300 px-4 py-3 text-center w-24">

                                JP

                            </th>

                            <th class="border border-gray-300 px-4 py-3 text-center w-40">

                                Aksi

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($mengajar as $m)

                            <tr class="hover:bg-blue-50 transition duration-200">

                                <td class="border border-gray-200 px-4 py-3 text-center">

                                    {{ $loop->iteration }}

                                </td>

                                <td class="border border-gray-200 px-4 py-3">

                                    {{ $m->guru->nama }}

                                </td>

                                <td class="border border-gray-200 px-4 py-3">

                                    {{ $m->mataPelajaran->nama_mapel }}

                                </td>

                                <td class="border border-gray-200 px-4 py-3 text-center">

                                    {{ $m->kelas->nama_kelas }}

                                </td>

                                <td class="border border-gray-200 px-4 py-3 text-center">

                                    {{ $m->jumlah_jam }} JP

                                </td>

                                <td class="border border-gray-200 px-4 py-3 text-center">

                                    <form method="POST"
                                          action="{{ route('guru-mengajar.generate.store', $m->id) }}">

                                        @csrf

                                        <button
                                            type="submit"
                                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow">

                                            ⚙ Generate

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="border border-gray-200 py-10 text-center text-gray-500">

                                    Belum ada data Penugasan Guru.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection