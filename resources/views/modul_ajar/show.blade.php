@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

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
            {{-- KELAS --}}
            {{-- ========================= --}}

            <div>

                <div class="border rounded-xl p-5">

                    <h2 class="text-xl font-bold mb-4">

                        🏫 Kelas Pengguna Modul

                    </h2>

                    @forelse($modulAjar->kelas as $item)

                        <div class="py-2 border-b">

                            {{ $item->kelas->nama_kelas }}

                        </div>

                    @empty

                        <div class="text-gray-500">

                            Belum ada kelas.

                        </div>

                    @endforelse

                    <form
                        action="{{ route('modul-ajar.generate-kelas',$modulAjar) }}"
                        method="POST">

                        @csrf

                        <button
                            class="mt-5 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">

                            ⚡ Generate Semua Kelas

                        </button>

                    </form>

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
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">

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

                                    <a
                                        href="{{ route('pertemuan.show',$pertemuan) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                                        Buka

                                    </a>

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