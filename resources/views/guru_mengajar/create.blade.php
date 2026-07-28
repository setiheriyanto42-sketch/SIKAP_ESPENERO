@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-xl shadow-lg p-6">

            <h2 class="text-2xl font-bold mb-6">

                ➕ Tambah Penugasan Mengajar

            </h2>

            <form method="POST"
                  action="{{ route('guru-mengajar.store') }}">

                @csrf

                {{-- Guru --}}
                <div class="mb-5">

                    <label class="block font-semibold mb-2">

                        Guru

                    </label>

                    <select
                        name="guru_id"
                        class="border rounded-lg w-full p-2">

                        @foreach($gurus as $guru)

                            <option value="{{ $guru->id }}">

                                {{ $guru->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Mata Pelajaran --}}
                <div class="mb-5">

                    <label class="block font-semibold mb-2">

                        Mata Pelajaran

                    </label>

                    <select
                        name="mata_pelajaran_id"
                        class="border rounded-lg w-full p-2">

                        @foreach($mapel as $m)

                            <option value="{{ $m->id }}">

                                {{ $m->nama_mapel }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Jumlah JP --}}
                <div class="mb-5">

                    <label class="block font-semibold mb-2">

                        Jumlah JP per Minggu

                    </label>

                    <input
                        type="number"
                        name="jumlah_jam"
                        min="1"
                        max="20"
                        value="1"
                        class="border rounded-lg w-full p-2"
                        required>

                    <small class="text-gray-500">

                        Contoh:
                        Bahasa Indonesia 5 JP,
                        Matematika 5 JP,
                        Informatika 2 JP.

                    </small>

                </div>

                {{-- Kelas --}}
                <div class="mb-5">

                    <label class="block font-semibold mb-2">

                        Kelas

                    </label>

                    <select
                        name="kelas_id"
                        class="border rounded-lg w-full p-2">

                        @foreach($kelas as $k)

                            <option value="{{ $k->id }}">

                                {{ $k->nama_kelas }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="flex gap-3">

                    <button
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">

                        💾 Simpan

                    </button>

                    <a
                        href="{{ route('guru-mengajar.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection