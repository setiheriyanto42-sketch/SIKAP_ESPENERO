@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="text-2xl font-bold">
            Penugasan Mengajar
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto">

            @if(session('success'))

                <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-5">

                    {{ session('success') }}

                </div>

            @endif

            <div class="flex justify-end gap-3 mb-5">

                <a href="{{ route('guru-mengajar.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">

                    ➕ Tambah Penugasan

                </a>

                <form method="POST"
                    action="{{ route('guru-mengajar.generate-semua') }}">

                    @csrf

                    <button
                        class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg shadow">

                        ⚙ Generate Semua

                    </button>

                </form>

            </div>

            <div class="overflow-x-auto rounded-xl shadow-lg border">

                <table class="min-w-full border border-gray-200">

                <thead class="bg-slate-800 text-white">

                    <tr>

                        <th class="border px-4 py-3 w-16 text-center">
                            No
                        </th>

                        <th class="border px-4 py-3">
                            Guru
                        </th>

                        <th class="border px-4 py-3">
                            Mata Pelajaran
                        </th>

                        <th class="border px-4 py-3 text-center w-24">
                            Kelas
                        </th>

                        <th class="border px-4 py-3 text-center w-20">
                            JP
                        </th>

                        <th class="border px-4 py-3 text-center w-28">
                            Status
                        </th>

                        <th class="border px-4 py-3 text-center w-48">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($mengajar as $item)

                        <tr class="hover:bg-blue-50">

                            <td class="border px-4 py-3 text-center">

                                {{ $loop->iteration }}

                            </td>

                            <td class="border px-4 py-3">

                                {{ $item->guru->nama }}

                            </td>

                            <td class="border px-4 py-3">

                                {{ $item->mataPelajaran->nama_mapel }}

                            </td>

                            <td class="border px-4 py-3 text-center">

                                {{ $item->kelas->nama_kelas }}

                            </td>

                            <td class="border px-4 py-3 text-center font-semibold">

                                {{ $item->jumlah_jam }}

                            </td>

                            <td class="border px-4 py-3 text-center">

                                @if($item->aktif)

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                        Aktif

                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                                        Nonaktif

                                    </span>

                                @endif

                            </td>

                            <td class="border px-4 py-3 text-center">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('guru-mengajar.edit', $item) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">

                                        Edit

                                    </a>

                                    <form method="POST"
                                        action="{{ route('guru-mengajar.destroy',$item) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Hapus data?')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center p-6">

                                Belum ada data.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
