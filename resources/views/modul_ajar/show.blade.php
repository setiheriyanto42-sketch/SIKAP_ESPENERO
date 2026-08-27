@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

{{-- =============================== --}}
{{-- FLASH MESSAGE --}}
{{-- =============================== --}}

@if(session('success'))

    <div class="mb-6 bg-green-50 border border-green-300
                text-green-700 px-5 py-4 rounded-xl">

        <div class="font-semibold">
            ✅ {{ session('success') }}
        </div>

    </div>

@endif


@if(session('error'))

    <div class="mb-6 bg-red-50 border border-red-300
                text-red-700 px-5 py-4 rounded-xl">

        <div class="font-semibold">
            ⚠️ {{ session('error') }}
        </div>

    </div>

@endif

    <div class="bg-white rounded-xl shadow-lg p-8">

        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-3xl font-bold">

                    📚 {{ $modulAjar->judul }}

                </h1>

                <p class="text-gray-500">

                    {{ $modulAjar->mataPelajaran->nama_mapel }}

                    •

                    Kelas {{ $modulAjar->tingkat }}

                    •

                    Semester {{ $modulAjar->semester }}

                </p>

            </div>

            <a
                href="{{ route('modul-ajar.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg">

                ← Kembali

            </a>

        </div>


        <div class="grid grid-cols-2 gap-8">

            {{-- ========================= --}}
            {{-- KELAS PENGGUNA MODUL --}}
            {{-- ========================= --}}

            <div>

                <div class="border rounded-xl p-5">

                    <div class="flex items-center justify-between mb-4">

                        <div>

                            <h2 class="text-xl font-bold">
                                🏫 Kelas Pengguna Modul
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Kelas disesuaikan dengan penugasan mengajar guru.
                            </p>

                        </div>

                        <span class="bg-blue-100 text-blue-700
                                    px-3 py-1 rounded-full text-sm font-semibold">

                            {{ $modulAjar->kelas->count() }} Kelas

                        </span>

                    </div>


                    @forelse($modulAjar->kelas as $item)

                        <div class="flex items-center justify-between
                                    py-3 border-b last:border-b-0">

                            <div class="flex items-center gap-3">

                                <div class="w-9 h-9 rounded-lg
                                            bg-blue-100 text-blue-700
                                            flex items-center justify-center">

                                    🏫

                                </div>

                                <div>

                                    <div class="font-semibold text-gray-800">

                                        {{ $item->kelas->nama_kelas
                                            ?? (($item->kelas->tingkat ?? '') . ($item->kelas->rombel ?? '')) }}

                                    </div>

                                    <div class="text-xs text-gray-500">

                                        Kelas yang diampu

                                    </div>

                                </div>

                            </div>

                            <span class="bg-green-100 text-green-700
                                        px-3 py-1 rounded-full text-xs font-semibold">

                                ✓ Aktif

                            </span>

                        </div>

                    @empty

                        <div class="bg-yellow-50 border border-yellow-200
                                    rounded-lg p-4 text-sm text-yellow-700">

                            ⚠ Belum ada kelas yang terhubung dengan modul ini.

                        </div>

                    @endforelse


                    <form
                        action="{{ route('modul-ajar.generate-kelas', $modulAjar) }}"
                        method="POST"
                        class="mt-5">

                        @csrf

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700
                                text-white px-5 py-3 rounded-lg
                                shadow transition">

                            🔄 Sinkronkan Kelas Diampu

                        </button>

                    </form>


                    <div class="mt-3 text-xs text-gray-500">

                        💡 Sistem hanya akan mengambil kelas yang sesuai dengan
                        penugasan mengajar Anda untuk mata pelajaran ini.

                    </div>

                </div>

            </div>


            {{-- ========================= --}}
            {{-- BAB --}}
            {{-- ========================= --}}

            <div>

                <div class="border rounded-xl p-5">

                    <div class="flex justify-between items-center mb-5">

                        <h2 class="text-xl font-bold">

                            📖 BAB

                        </h2>

                        <a
                            href="{{ route('modul-bab.create',['modul'=>$modulAjar->id]) }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">

                            ➕ Tambah BAB

                        </a>

                    </div>

                    @forelse($modulAjar->babs as $bab)

                        <div class="border rounded-xl p-5 mb-5 shadow-sm">

                            <div class="flex justify-between items-start">

                                <div>

                                    <h3 class="text-lg font-bold">

                                        📘 BAB {{ $bab->urutan }}

                                    </h3>

                                    <h4 class="text-blue-700 font-semibold mt-1">

                                        {{ $bab->nama_bab }}

                                    </h4>

                                    <p class="text-gray-500 mt-2">

                                        🎯 {{ $bab->tujuan ?: 'Belum ada tujuan pembelajaran.' }}

                                    </p>

                                    <p class="text-sm text-gray-500 mt-2">

                                        📅 {{ $bab->jumlah_pertemuan }} Pertemuan

                                    </p>

                                </div>

                                <div>

                                    @if($bab->pertemuans->count()==0)

                                        <form
                                            action="{{ route('bab.generate-pertemuan',$bab) }}"
                                            method="POST">

                                            @csrf

                                            <button
                                                class="bg-indigo-600 hover:bg-indigo-700 text-grey px-4 py-2 rounded-lg shadow">

                                                ⚡ Generate Pertemuan

                                            </button>

                                        </form>

                                    @else

                                        <span
                                            class="bg-green-100 text-green-700 px-4 py-2 rounded-full">

                                            ✔ {{ $bab->pertemuans->count() }} Pertemuan

                                        </span>

                                    @endif

                                </div>

                            </div>

                            @if($bab->pertemuans->count() > 0)

                                <hr class="my-5">

                                <h4 class="font-bold text-gray-700 mb-3">
                                    📅 Daftar Pertemuan
                                </h4>

                                <div class="space-y-3">

                                @foreach($bab->pertemuans as $pertemuan)

                                <div class="flex justify-between items-center border rounded-lg p-3 hover:bg-gray-50">

                                    <div>

                                        <div class="font-semibold">
                                            Pertemuan {{ $pertemuan->pertemuan_ke }}
                                        </div>

                                        <div class="text-sm text-gray-500">
                                            {{ $pertemuan->judul }}
                                        </div>

                                    </div>

                                    <div class="flex items-center gap-2">

                                        {{-- BUKA PERTEMUAN --}}
                                        <a
                                            href="{{ route('pertemuan.show', $pertemuan) }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                                            📖 Buka

                                        </a>


                                        {{-- HAPUS PERTEMUAN --}}
                                        @if(!$pertemuan->sudah_diajarkan)

                                            <form
                                                action="{{ route('pertemuan.destroy', $pertemuan) }}"
                                                method="POST"
                                                onsubmit="return confirm(
                                                    'Yakin ingin menghapus Pertemuan {{ $pertemuan->pertemuan_ke }}?'
                                                )">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">

                                                    🗑 Hapus

                                                </button>

                                            </form>

                                        @else

                                            <span
                                                class="bg-gray-100 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed"
                                                title="Pertemuan sudah digunakan dalam pembelajaran">

                                                🔒 Digunakan

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                @endforeach

                                </div>

                                @endif

                            {{-- Tombol --}}
                            <div class="flex gap-3 mt-5">

                                <a
                                    href="{{ route('modul-bab.edit',$bab) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">

                                    ✏ Edit

                                </a>

                                <form
                                    action="{{ route('modul-bab.destroy',$bab) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin menghapus BAB ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">

                                        🗑 Hapus

                                    </button>

                                </form>

                                

                            </div>

                        </div>

                    @empty

                        <div class="text-gray-500">

                            Belum ada BAB.

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection