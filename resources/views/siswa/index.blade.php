@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">
            👨‍🎓 Master Data Siswa
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-5 rounded-lg border border-green-400 bg-green-100 px-4 py-3 text-green-700 shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg p-6">

                {{-- HEADER --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">

                    <div>

                        <h3 class="text-2xl font-bold text-slate-800">
                            Daftar Siswa
                        </h3>

                        <p class="text-sm text-slate-500">
                            Data seluruh siswa SMP Negeri 2 Jatiroto
                        </p>

                    </div>

                    <div class="flex flex-wrap gap-2">

                        <a href="{{ route('siswa.create') }}"
                           class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-4 py-2 rounded-lg shadow">

                            ➕ Tambah

                        </a>

                        <a href="{{ route('siswa.import.form') }}"
                           class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow">

                            📥 Import Excel

                        </a>

                        <a href="{{ route('siswa.template') }}"
                           class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded-lg shadow">

                            📄 Download Template

                        </a>

                    </div>

                </div>

                {{-- SEARCH --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">

                    <input
                        type="text"
                        placeholder="🔍 Cari NIS / Nama Siswa..."
                        class="border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500">

                    <select
                        class="border border-slate-300 rounded-lg px-4 py-2">

                        <option>Semua Kelas</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>

                    </select>

                    <select
                        class="border border-slate-300 rounded-lg px-4 py-2">

                        <option>Semua Status</option>
                        <option>Aktif</option>
                        <option>Non Aktif</option>

                    </select>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full border border-slate-300">

                        <thead>

                            <tr class="bg-sky-600 text-white">

                                <th class="border px-3 py-3 w-16">
                                    No
                                </th>

                                <th class="border px-3 py-3 text-center">
                                    Foto
                                </th>

                                <th class="border px-3 py-3">
                                    NIS
                                </th>

                                <th class="border px-3 py-3">
                                    NISN
                                </th>

                                <th class="border px-3 py-3">
                                    Nama
                                </th>

                                <th class="border px-3 py-3 w-20">
                                    L/P
                                </th>

                                <th class="border px-3 py-3">
                                    Kelas
                                </th>

                                <th class="border px-3 py-3">
                                    Status
                                </th>

                                <th class="border px-3 py-3 text-center w-52">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($siswas as $siswa)
                            <tr class="hover:bg-sky-50 transition">

                            {{-- NO --}}
                            <td class="border px-3 py-2 text-center">
                                {{ $loop->iteration }}
                            </td>

                            {{-- FOTO --}}
                            <td class="border px-3 py-2 text-center">

                            @if($siswa->foto)

                            <span
                            class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">

                            ADA

                            </span>

                            @else

                            <span
                            class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">

                            BELUM

                            </span>

                            @endif

                            </td>

                            {{-- NIS --}}
                            <td class="border px-3 py-2">
                                {{ $siswa->nis }}
                            </td>

                            {{-- NISN --}}
                            <td class="border px-3 py-2">
                                {{ $siswa->nisn }}
                            </td>

                            {{-- NAMA --}}
                            <td class="border px-3 py-2">

                                <div class="font-semibold text-slate-800">
                                    {{ $siswa->nama }}
                                </div>

                            </td>

                            {{-- JK --}}
                            <td class="border px-3 py-2 text-center">

                                @if($siswa->jenis_kelamin=="L")

                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold">

                                        L

                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-pink-100 text-pink-700 font-bold">

                                        P

                                    </span>

                                @endif

                            </td>

                            {{-- KELAS --}}
                            <td class="border px-3 py-2 text-center">

                                <span
                                    class="bg-slate-100 px-3 py-1 rounded-full">

                                    {{ $siswa->kelas }}{{ $siswa->rombel }}

                                </span>

                            </td>

                            {{-- STATUS --}}
                            <td class="border px-3 py-2 text-center">

                                @if($siswa->aktif)

                                    <span
                                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">

                                        Aktif

                                    </span>

                                @else

                                    <span
                                        class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">

                                        Non Aktif

                                    </span>

                                @endif

                            </td>

                            {{-- AKSI --}}
                            <td class="border px-3 py-2">

                                <div class="flex justify-center gap-2">

                                    <a
                                        href="{{ route('siswa.show',$siswa) }}"
                                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-3 py-2 rounded-lg shadow"
                                        title="Detail">

                                        👁

                                    </a>

                                    <a
                                        href="{{ route('siswa.edit',$siswa) }}"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-lg shadow"
                                        title="Edit">

                                        ✏️

                                    </a>

                                    <form
                                        action="{{ route('siswa.destroy',$siswa) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow"
                                            title="Hapus">

                                            🗑

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="9"
                                class="border py-10 text-center text-slate-500">

                                Belum ada data siswa.

                            </td>

                        </tr>

                        @endforelse
                                                </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-3">

                    <div class="text-sm text-slate-500">
                        Total Data :
                        <span class="font-bold text-sky-600">
                            {{ $siswas->count() }}
                        </span>
                        Siswa
                    </div>

                    {{-- Nanti tinggal aktifkan jika sudah memakai paginate() --}}
                    {{--
                    {{ $siswas->links() }}
                    --}}

                </div>

            </div>

        </div>

    </div>

@endsection
