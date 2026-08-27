@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-7xl mx-auto">

        {{-- ALERT --}}
        @if(session('success'))

            <div class="mb-5 rounded-lg border border-green-300 bg-green-100 p-4 text-green-700">

                {{ session('success') }}

            </div>

        @endif


        {{-- HEADER --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">

            <div class="flex justify-between items-start">

                <div>

                    <h1 class="text-3xl font-bold text-slate-800">

                        📅 Jadwal Mengajar

                    </h1>

                    <p class="text-gray-500 mt-2">

                        Kelola seluruh jadwal guru berdasarkan Template Jam Pelajaran.

                    </p>

                </div>

                <div class="text-right">

                    <div class="text-sm text-gray-400">

                        Total Jadwal

                    </div>

                    <div class="text-3xl font-bold text-blue-600">

                        {{ $jadwal->count() }}

                    </div>

                </div>

            </div>


            {{-- TAB MENU --}}

            <div class="mt-6 border-b">

                <div class="flex gap-3 pb-4">

                    <button
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow">

                        📋 Semua

                    </button>

                    <button
                        class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg">

                        👨‍🏫 Guru

                    </button>

                    <button
                        class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg">

                        🏫 Kelas

                    </button>

                    <button
                        class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg">

                        📅 Mingguan

                    </button>

                </div>

            </div>

        </div>


        {{-- FILTER --}}

        <div class="bg-white rounded-xl shadow-lg p-5 mb-6">

            <form method="GET">

                <div class="grid lg:grid-cols-5 md:grid-cols-2 gap-4">

                    <select
                        name="guru"
                        class="border rounded-lg p-2">

                        <option value="">Semua Guru</option>

                        @foreach($gurus as $g)

                            <option
                                value="{{ $g->id }}"
                                @selected(request('guru')==$g->id)>

                                {{ $g->nama }}

                            </option>

                        @endforeach

                    </select>


                    <select
                        name="kelas"
                        class="border rounded-lg p-2">

                        <option value="">Semua Kelas</option>

                        @foreach($kelas as $k)

                            <option
                                value="{{ $k->id }}"
                                @selected(request('kelas')==$k->id)>

                                {{ $k->nama_kelas }}

                            </option>

                        @endforeach

                    </select>


                    <select
                        name="hari"
                        class="border rounded-lg p-2">

                        <option value="">Semua Hari</option>

                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)

                            <option
                                value="{{ $h }}"
                                @selected(request('hari')==$h)>

                                {{ $h }}

                            </option>

                        @endforeach

                    </select>


                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Guru / Mapel..."
                        class="border rounded-lg p-2">


                    <div class="flex gap-2">

                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-lg">

                            🔍 Filter

                        </button>

                        <a
                            href="{{ route('jadwal-mengajar.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 rounded-lg flex items-center">

                            Reset

                        </a>

                    </div>

                </div>

            </form>


            <div class="flex justify-end gap-3 mt-5">

                <a
                    href="{{ route('jadwal-mengajar.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">

                    ➕ Tambah Jadwal

                </a>

                <a
                    href="#"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow">

                    📄 Export PDF

                </a>

            </div>

        </div>


        {{-- TABEL --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">

            <table class="min-w-full">

                <thead class="bg-slate-800 text-white">

                    <tr>

                        <th class="p-3 text-left">Hari</th>

                        <th class="p-3 text-center">JP</th>

                        <th class="p-3 text-left">Jam</th>

                        <th class="p-3 text-left">Guru</th>

                        <th class="p-3 text-left">Mata Pelajaran</th>

                        <th class="p-3 text-left">Kelas</th>

                        <th class="p-3 text-center">Status</th>

                        <th class="p-3 text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($jadwal as $item)

                    <tr class="border-b hover:bg-slate-50 transition">

                {{-- HARI --}}

<td class="p-3">

    @php

        $warnaHari = [
            'Senin'  => 'bg-blue-100 text-blue-700',
            'Selasa' => 'bg-green-100 text-green-700',
            'Rabu'   => 'bg-yellow-100 text-yellow-700',
            'Kamis'  => 'bg-purple-100 text-purple-700',
            'Jumat'  => 'bg-red-100 text-red-700',
            'Sabtu'  => 'bg-indigo-100 text-indigo-700',
        ];

    @endphp

    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $warnaHari[$item->hari] ?? 'bg-gray-100 text-gray-700' }}">

        {{ $item->hari }}

    </span>

</td>


{{-- JP --}}

<td class="p-3 text-center font-bold">

    {{ $item->jam_ke }}

</td>


{{-- JAM --}}

<td class="p-3 whitespace-nowrap">

    {{ substr($item->jam_mulai,0,5) }}

    -

    {{ substr($item->jam_selesai,0,5) }}

</td>


{{-- GURU --}}

<td class="p-3">

    <div class="font-semibold text-slate-700">

        {{ $item->guruMengajar->guru->nama }}

    </div>

</td>


{{-- MAPEL --}}

<td class="p-3">

    <span class="font-medium">

        {{ $item->guruMengajar->mataPelajaran->nama_mapel }}

    </span>

</td>


{{-- KELAS --}}

<td class="p-3">

    <span class="bg-slate-100 px-3 py-1 rounded-lg">

        {{ $item->guruMengajar->kelas->nama_kelas }}

    </span>

</td>


{{-- STATUS --}}

<td class="p-3 text-center">

    @if($item->aktif)

        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">

            ✅ Aktif

        </span>

    @else

        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full font-semibold">

            ❌ Non Aktif

        </span>

    @endif

</td>


{{-- AKSI --}}

<td class="p-3">

    <div class="flex flex-wrap justify-center gap-2">

        <a href="{{ route('sesi.mulai', $item) }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-grey px-3 py-1 rounded">

            🚀 Mulai

        </a>

        <a
            href="{{ route('jadwal-mengajar.edit',$item) }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg shadow">

            ✏ Edit

        </a>

        <form
            action="{{ route('jadwal-mengajar.destroy',$item) }}"
            method="POST">

            @csrf
            @method('DELETE')

            <button
                onclick="return confirm('Yakin ingin menghapus jadwal ini?')"
                class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow">

                🗑 Hapus

            </button>

        </form>

    </div>

</td>

</tr>

                    @empty

                    <tr>

                        <td colspan="8">

                            <div class="flex flex-col items-center justify-center py-12">

                                <div class="text-6xl mb-4">

                                    📅

                                </div>

                                <h3 class="text-2xl font-bold text-slate-700">

                                    Belum Ada Jadwal Mengajar

                                </h3>

                                <p class="text-gray-500 mt-2">

                                    Silakan tambahkan jadwal mengajar terlebih dahulu.

                                </p>

                                <a
                                    href="{{ route('jadwal-mengajar.create') }}"
                                    class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow">

                                    ➕ Tambah Jadwal Pertama

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- FOOTER INFO --}}

        <div class="mt-6 bg-white rounded-xl shadow p-4">

            <div class="flex flex-col md:flex-row justify-between items-center gap-3">

                <div class="text-gray-600">

                    📊 Total Jadwal :

                    <strong>

                        {{ $jadwal->count() }}

                    </strong>

                </div>

                <div class="text-sm text-gray-400">

                    SIKAP ESPENERO • Modul Jadwal Mengajar v1.0

                </div>

            </div>

        </div>

    </div>

</div>

@endsection