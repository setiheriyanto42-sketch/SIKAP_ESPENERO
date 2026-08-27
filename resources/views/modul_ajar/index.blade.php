@extends('layouts.app')

@section('content')

{{-- ========================================================= --}}
{{-- FLASH MESSAGE --}}
{{-- ========================================================= --}}

@if(session('success'))
    <div class="bg-green-100 border border-green-300
                text-green-700 rounded-lg p-4 mb-6">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-300
                text-red-700 rounded-lg p-4 mb-6">
        ⚠️ {{ session('error') }}
    </div>
@endif


{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="flex flex-col md:flex-row
            md:justify-between md:items-center
            gap-4 mb-6">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            📚 Modul Ajar
        </h1>

        <p class="text-gray-500">
            Kelola modul ajar dan perencanaan pembelajaran.
        </p>
    </div>


    <div class="flex items-center gap-3">

        {{-- SUSUN MANUAL --}}
        <a
            href="{{ route('modul-ajar.create') }}"
            class="inline-flex items-center justify-center gap-2
                   bg-blue-600 hover:bg-blue-700
                   text-white font-semibold
                   px-5 py-3 rounded-lg
                   shadow-sm transition">

            ✏️
            <span>Susun Manual</span>

        </a>


        {{-- UPLOAD RPP --}}
        <a
            href="{{ route('modul-ajar.upload') }}"
            style="background-color:#4f46e5;color:white;"
            class="inline-flex items-center justify-center gap-2
                   font-semibold
                   px-5 py-3 rounded-lg
                   shadow-sm transition">

            📤
            <span>Upload RPP</span>

        </a>

    </div>

</div>


{{-- ========================================================= --}}
{{-- TABLE MODUL AJAR BARU --}}
{{-- ========================================================= --}}

<div class="bg-white rounded-xl shadow overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">
                        Modul Ajar
                    </th>

                    <th class="p-4 text-center">
                        Kelas
                    </th>

                    <th class="p-4 text-center">
                        Semester
                    </th>

                    <th class="p-4 text-center">
                        BAB
                    </th>

                    <th class="p-4 text-center">
                        Alokasi
                    </th>

                    <th class="p-4 text-center">
                        Status
                    </th>

                    <th class="p-4 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

            @forelse($data as $modul)

                <tr class="border-t hover:bg-gray-50">


                    {{-- ================================================= --}}
                    {{-- MODUL --}}
                    {{-- ================================================= --}}

                    <td class="p-4">

                        <div class="font-semibold text-gray-800">

                            {{ $modul->mata_pelajaran ?? 'Mata Pelajaran belum diisi' }}

                        </div>


                        <div class="text-sm text-gray-600 mt-1">

                            Kelas {{ $modul->kelas ?? '-' }}

                            @if($modul->fase)
                                · Fase {{ $modul->fase }}
                            @endif

                        </div>


                        @if($modul->nama_file)

                            <div class="text-xs text-gray-400 mt-1">

                                📄 {{ $modul->nama_file }}

                            </div>

                        @endif


                        @if($modul->tahun_ajaran)

                            <div class="text-xs text-gray-500 mt-1">

                                Tahun Ajaran:
                                {{ $modul->tahun_ajaran }}

                            </div>

                        @endif

                    </td>


                    {{-- ================================================= --}}
                    {{-- KELAS --}}
                    {{-- ================================================= --}}

                    <td class="p-4 text-center">

                        <span
                            class="inline-flex items-center justify-center
                                   bg-blue-50 text-blue-700
                                   px-3 py-1 rounded-full
                                   text-sm font-semibold">

                            {{ $modul->kelas ?? '-' }}

                        </span>

                    </td>


                    {{-- ================================================= --}}
                    {{-- SEMESTER --}}
                    {{-- ================================================= --}}

                    <td class="p-4 text-center">

                        @if($modul->semester)

                            <span
                                class="inline-flex items-center justify-center
                                       bg-indigo-50 text-indigo-700
                                       px-3 py-1 rounded-full
                                       text-sm font-semibold">

                                {{ $modul->semester }}

                            </span>

                        @else

                            <span class="text-gray-400">
                                -
                            </span>

                        @endif

                    </td>


                    {{-- ================================================= --}}
                    {{-- BAB --}}
                    {{-- ================================================= --}}

                    <td class="p-4 text-center">

                        <span
                            class="inline-flex items-center justify-center
                                   bg-purple-50 text-purple-700
                                   px-3 py-1 rounded-full
                                   text-sm font-semibold">

                            {{ $modul->bab_count }}

                        </span>

                    </td>


                    {{-- ================================================= --}}
                    {{-- ALOKASI WAKTU --}}
                    {{-- ================================================= --}}

                    <td class="p-4 text-center">

                        @php
                            $alokasi = $modul->alokasi_waktu ?? [];
                        @endphp


                        @if(is_array($alokasi) && !empty($alokasi))

                            <div class="text-sm font-semibold text-gray-700">

                                {{ $alokasi['jp'] ?? '-' }} JP

                            </div>

                            <div class="text-xs text-gray-500">

                                {{ $alokasi['total_menit'] ?? '-' }} menit

                            </div>

                        @else

                            <span class="text-gray-400">
                                -
                            </span>

                        @endif

                    </td>


                    {{-- ================================================= --}}
                    {{-- STATUS --}}
                    {{-- ================================================= --}}

                    <td class="p-4 text-center">

                        <span
                            class="bg-green-100 text-green-700
                                   px-3 py-1 rounded-full
                                   text-sm font-semibold">

                            ✓ Aktif

                        </span>

                    </td>


                    {{-- ================================================= --}}
                    {{-- AKSI --}}
                    {{-- ================================================= --}}

                    <td class="p-4">

                        <div class="flex items-center gap-2">

                            {{-- DETAIL --}}
                            <a
                                href="{{ route('modul-ajar.show', $modul) }}"
                                class="inline-flex items-center px-3 py-2 rounded-lg
                                    bg-blue-600 text-white text-sm font-semibold
                                    hover:bg-blue-700"
                            >
                                👁 Detail
                            </a>

                            {{-- EDIT --}}
                            <a
                                href="{{ route('modul-ajar.edit', $modul) }}"
                                class="inline-flex items-center px-3 py-2 rounded-lg
                                    bg-amber-500 text-white text-sm font-semibold
                                    hover:bg-amber-600"
                            >
                                ✏️ Edit
                            </a>

                            {{-- HAPUS --}}
                            <form
                                action="{{ route('modul-ajar.destroy', $modul) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus Modul Ajar ini? Semua BAB dan Pertemuan di dalamnya juga akan dihapus.')"
                                class="inline"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex items-center px-3 py-2 rounded-lg
                                        bg-red-600 text-white text-sm font-semibold
                                        hover:bg-red-700"
                                >
                                    🗑 Hapus
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>


            @empty

                <tr>

                    <td
                        colspan="7"
                        class="text-center py-12 text-gray-500">

                        <div class="text-4xl mb-3">
                            📭
                        </div>

                        <div class="font-semibold">
                            Belum ada Modul Ajar
                        </div>

                        <div class="text-sm mt-1">
                            Silakan upload RPP atau susun Modul Ajar secara manual.
                        </div>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- ========================================================= --}}
{{-- PAGINATION --}}
{{-- ========================================================= --}}

<div class="mt-6">

    {{ $data->links() }}

</div>

@endsection