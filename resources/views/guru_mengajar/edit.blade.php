@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="text-2xl font-bold">
            Edit Penugasan Mengajar
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto">

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg mb-5">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg border p-6">

                <form method="POST"
                    action="{{ route('guru-mengajar.update', $guruMengajar) }}">

                    @csrf
                    @method('PUT')

                    {{-- GURU --}}
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            Guru
                        </label>

                        <select
                            name="guru_id"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>

                            <option value="">
                                -- Pilih Guru --
                            </option>

                            @foreach($gurus as $guru)

                                <option
                                    value="{{ $guru->id }}"
                                    {{ $guruMengajar->guru_id == $guru->id ? 'selected' : '' }}>

                                    {{ $guru->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- MATA PELAJARAN --}}
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            Mata Pelajaran
                        </label>

                        <select
                            name="mata_pelajaran_id"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>

                            <option value="">
                                -- Pilih Mata Pelajaran --
                            </option>

                            @foreach($mapel as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ $guruMengajar->mata_pelajaran_id == $item->id ? 'selected' : '' }}>

                                    {{ $item->nama_mapel }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- KELAS --}}
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            Kelas
                        </label>

                        <select
                            name="kelas_id"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>

                            <option value="">
                                -- Pilih Kelas --
                            </option>

                            @foreach($kelas as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ $guruMengajar->kelas_id == $item->id ? 'selected' : '' }}>

                                    {{ $item->nama_kelas }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- JUMLAH JAM --}}
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            Jumlah Jam Pelajaran (JP)
                        </label>

                        <input
                            type="number"
                            name="jumlah_jam"
                            min="1"
                            max="20"
                            value="{{ old('jumlah_jam', $guruMengajar->jumlah_jam) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>

                    </div>


                    {{-- STATUS --}}
                    <div class="mb-6">

                        <label class="flex items-center gap-2">

                            <input
                                type="checkbox"
                                name="aktif"
                                value="1"
                                {{ $guruMengajar->aktif ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            <span class="font-semibold">
                                Penugasan Aktif
                            </span>

                        </label>

                    </div>


                    {{-- BUTTON --}}
                    <div class="flex justify-end gap-3">

                        <a
                            href="{{ route('guru-mengajar.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                            Batal

                        </a>

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">

                            💾 Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection