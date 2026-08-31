@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-7xl mx-auto">

        @if(session('success'))

            <div class="mb-5 rounded-lg bg-green-100 border border-green-300 text-green-700 p-4">

                {{ session('success') }}

            </div>

        @endif

        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">

            <div class="flex justify-between items-center">

                <div>

                    <h1 class="text-3xl font-bold text-slate-800">

                        📅 Template Jadwal

                    </h1>

                    <p class="text-gray-500 mt-2">

                        Kelola Template Jam Pelajaran untuk proses Generate Jadwal.

                    </p>

                </div>

                <a href="{{ route('template-jadwal.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow">

                    ➕ Tambah Template

                </a>

            </div>

        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-800 text-white">

                        <tr>

                            <th class="px-4 py-3 text-center w-16">

                                No

                            </th>

                            <th class="px-4 py-3">

                                Nama Template

                            </th>

                            <th class="px-4 py-3 text-center">

                                Durasi

                            </th>

                            <th class="px-4 py-3 text-center">

                                Jam Masuk

                            </th>

                            <th class="px-4 py-3 text-center">

                                Jumlah JP

                            </th>

                            <th class="px-4 py-3 text-center">

                                Status

                            </th>

                            <th class="px-4 py-3 text-center">

                                Aksi

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($templates as $item)

                        <tr class="border-b hover:bg-blue-50">

                            <td class="px-4 py-4 text-center">

                                {{ $loop->iteration }}

                            </td>

                            <td class="px-4 py-4 font-semibold">

                                {{ $item->nama }}

                            </td>

                            <td class="px-4 py-4 text-center">

                                {{ $item->durasi_jp }} Menit

                            </td>

                            <td class="px-4 py-4 text-center">

                                {{ $item->jam_masuk }}

                            </td>

                            <td class="px-4 py-4 text-center">

                                {{ $item->jumlah_jp }}

                            </td>

                            <td class="px-4 py-4 text-center">

                                @if($item->aktif)

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                        Aktif

                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                                        Non Aktif

                                    </span>

                                @endif

                            </td>

                            <td class="px-4 py-4">

                            <div class="flex justify-center gap-2 flex-wrap">

                                <a href="{{ route('template-jadwal.hari', $item) }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-Grey px-3 py-2 rounded">

                                    📅 Setting Hari

                                </a>

                                <a href="{{ route('template-jadwal.show', $item) }}"
                                class="bg-sky-500 hover:bg-sky-600 text-Grey px-3 py-2 rounded">

                                    👁 Detail

                                </a>

                                <form action="{{ route('template-jadwal.generate', $item) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf

                                    <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded">

                                        ⚙ Generate

                                    </button>

                                </form>

                                <a href="{{ route('template-jadwal.edit', $item) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded">

                                    ✏ Edit

                                </a>

                                <form action="{{ route('template-jadwal.destroy', $item) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus template ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded">

                                        🗑 Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="py-10 text-center text-gray-500">

                                Belum ada Template Jadwal.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 mt-6">

            <div class="flex justify-between items-center">

                <div>

                    <h3 class="text-xl font-bold text-slate-800">

                        🚀 Generate Jadwal Sekolah

                    </h3>

                    <p class="text-gray-500 mt-2">

                        Setelah Template dan Penugasan Guru selesai dibuat,
                        sistem akan menyusun seluruh jadwal secara otomatis.

                    </p>

                </div>

                <form action="{{ route('guru-mengajar.generate-semua') }}"
                    method="POST">

                    @csrf

                    <button
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg shadow">

                        ⚙ Generate Semua

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection