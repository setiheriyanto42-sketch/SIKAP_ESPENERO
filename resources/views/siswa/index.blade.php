@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Data Siswa
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Master data siswa SMP Negeri 2 Jatiroto
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            <a href="{{ route('siswa.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg
                      hover:bg-blue-700 transition font-semibold text-sm">
                + Tambah Siswa
            </a>

            <a href="{{ route('siswa.import') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-sm inline-flex items-center gap-1">
                📥 Import Excel
            </a>

            <a href="{{ route('siswa.template') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-sm inline-flex items-center gap-1">
                📄 Template
            </a>

        </div>

    </div>


    {{-- NOTIFIKASI --}}
    @if(session('success'))

        <div class="mb-5 p-4 rounded-lg bg-green-50 border border-green-200
                    text-green-700">

            <div class="font-semibold">
                ✓ {{ session('success') }}
            </div>

        </div>

    @endif


    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-xl shadow-sm border p-5">
            <div class="text-sm text-gray-500">
                Total Siswa
            </div>

            <div class="text-3xl font-bold text-gray-800 mt-2">
                {{ \App\Models\Siswa::count() }}
            </div>
        </div>


        <div class="bg-white rounded-xl shadow-sm border p-5">
            <div class="text-sm text-gray-500">
                Siswa Aktif
            </div>

            <div class="text-3xl font-bold text-green-600 mt-2">
                {{ \App\Models\Siswa::where('aktif', true)->count() }}
            </div>
        </div>


        <div class="bg-white rounded-xl shadow-sm border p-5">
            <div class="text-sm text-gray-500">
                Laki-laki
            </div>

            <div class="text-3xl font-bold text-blue-600 mt-2">
                {{ \App\Models\Siswa::where('jenis_kelamin', 'L')->count() }}
            </div>
        </div>


        <div class="bg-white rounded-xl shadow-sm border p-5">
            <div class="text-sm text-gray-500">
                Perempuan
            </div>

            <div class="text-3xl font-bold text-pink-600 mt-2">
                {{ \App\Models\Siswa::where('jenis_kelamin', 'P')->count() }}
            </div>
        </div>

    </div>


    {{-- FILTER --}}
    <div class="bg-white rounded-xl shadow-sm border p-5 mb-6">

        <form method="GET"
              action="{{ route('siswa.index') }}">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- SEARCH --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Pencarian
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nama / NIS / NISN..."
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>


                {{-- KELAS --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kelas
                    </label>

                    <select
                        name="kelas"
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            Semua Kelas
                        </option>

                        @foreach($kelas as $item)

                            <option
                                value="{{ $item }}"
                                {{ request('kelas') == $item ? 'selected' : '' }}>

                                {{ $item }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- ROMBEL --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Rombel
                    </label>

                    <select
                        name="rombel"
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            Semua Rombel
                        </option>

                        @foreach($rombels as $item)

                            <option
                                value="{{ $item }}"
                                {{ request('rombel') == $item ? 'selected' : '' }}>

                                {{ $item }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Status
                    </label>

                    <select
                        name="aktif"
                        class="w-full rounded-lg border-gray-300
                               focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="1"
                            {{ request('aktif') === '1' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0"
                            {{ request('aktif') === '0' ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>

                    </select>

                </div>

            </div>


            <div class="flex gap-2 mt-4">

                <button
                    type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg
                           hover:bg-blue-700 font-semibold">

                    🔎 Cari

                </button>


                <a
                    href="{{ route('siswa.index') }}"
                    class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg
                           hover:bg-gray-300 font-semibold">

                    Reset

                </a>

            </div>

        </form>

    </div>


    {{-- TABEL SISWA --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <div class="px-5 py-4 border-b flex items-center justify-between">

            <div>

                <h2 class="font-bold text-gray-800">
                    Daftar Siswa
                </h2>

                <p class="text-xs text-gray-500 mt-1">

                    Menampilkan
                    {{ $siswas->firstItem() ?? 0 }}
                    -
                    {{ $siswas->lastItem() ?? 0 }}
                    dari
                    {{ $siswas->total() }}
                    siswa

                </p>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-4 py-3 text-left">
                            No
                        </th>

                        <th class="px-4 py-3 text-left">
                            Nama
                        </th>

                        <th class="px-4 py-3 text-left">
                            NIS
                        </th>

                        <th class="px-4 py-3 text-left">
                            NISN
                        </th>

                        <th class="px-4 py-3 text-left">
                            Kelas
                        </th>

                        <th class="px-4 py-3 text-left">
                            JK
                        </th>

                        <th class="px-4 py-3 text-left">
                            Status
                        </th>

                        <th class="px-4 py-3 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($siswas as $index => $siswa)

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3">

                                {{ $siswas->firstItem() + $index }}

                            </td>


                            <td class="px-4 py-3">

                                <div class="font-semibold text-gray-800">
                                    {{ $siswa->nama }}
                                </div>

                            </td>


                            <td class="px-4 py-3 text-gray-600">

                                {{ $siswa->nis ?? '-' }}

                            </td>


                            <td class="px-4 py-3 text-gray-600">

                                {{ $siswa->nisn ?? '-' }}

                            </td>


                            <td class="px-4 py-3">

                                <span class="font-semibold">

                                    {{ $siswa->kelas ?? '-' }}

                                    @if($siswa->rombel)
                                        {{ $siswa->rombel }}
                                    @endif

                                </span>

                            </td>


                            <td class="px-4 py-3">

                                @if($siswa->jenis_kelamin === 'L')

                                    <span class="px-2 py-1 rounded-md
                                                 bg-blue-50 text-blue-700 text-xs
                                                 font-semibold">
                                        L
                                    </span>

                                @elseif($siswa->jenis_kelamin === 'P')

                                    <span class="px-2 py-1 rounded-md
                                                 bg-pink-50 text-pink-700 text-xs
                                                 font-semibold">
                                        P
                                    </span>

                                @else

                                    -

                                @endif

                            </td>


                            <td class="px-4 py-3">

                                @if($siswa->aktif)

                                    <span class="px-2 py-1 rounded-full
                                                 bg-green-100 text-green-700
                                                 text-xs font-semibold">
                                        Aktif
                                    </span>

                                @else

                                    <span class="px-2 py-1 rounded-full
                                                 bg-gray-100 text-gray-600
                                                 text-xs font-semibold">
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>


                            <td class="px-4 py-3">

                                <div class="flex justify-center gap-2">

                                    <a
                                        href="{{ route('siswa.show', $siswa) }}"
                                        class="px-3 py-1.5 rounded-lg
                                               bg-gray-100 text-gray-700
                                               hover:bg-gray-200 text-xs
                                               font-semibold">

                                        Detail

                                    </a>


                                    <a
                                        href="{{ route('siswa.edit', $siswa) }}"
                                        class="px-3 py-1.5 rounded-lg
                                               bg-yellow-100 text-yellow-700
                                               hover:bg-yellow-200 text-xs
                                               font-semibold">

                                        Edit

                                    </a>


                                    <form
                                        action="{{ route('siswa.destroy', $siswa) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-1.5 rounded-lg
                                                   bg-red-100 text-red-700
                                                   hover:bg-red-200 text-xs
                                                   font-semibold">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="px-6 py-12 text-center">

                                <div class="text-gray-400 text-4xl mb-3">
                                    👨‍🎓
                                </div>

                                <div class="font-semibold text-gray-600">
                                    Belum ada data siswa
                                </div>

                                <div class="text-sm text-gray-400 mt-1">
                                    Silakan tambah siswa atau import data dari Excel.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($siswas->hasPages())

            <div class="px-5 py-4 border-t">

                {{ $siswas->links() }}

            </div>

        @endif

    </div>

</div>

@endsection