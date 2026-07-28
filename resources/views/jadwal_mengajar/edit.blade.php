@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            Edit Jadwal Mengajar
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto">

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 p-4 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">

                <form method="POST"
                      action="{{ route('jadwal-mengajar.update',$jadwalMengajar) }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">

                        <label class="block font-semibold mb-2">
                            Penugasan Guru
                        </label>

                        <select
                            name="guru_mengajar_id"
                            class="border rounded w-full p-2">

                            @foreach($mengajar as $m)

                                <option
                                    value="{{ $m->id }}"
                                    {{ $jadwalMengajar->guru_mengajar_id==$m->id ? 'selected':'' }}>

                                    {{ $m->guru->nama }}
                                    -
                                    {{ $m->mataPelajaran->nama_mapel }}
                                    -
                                    {{ $m->kelas->nama_kelas }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold mb-2">
                            Hari
                        </label>

                        <select
                            name="hari"
                            class="border rounded w-full p-2">

                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)

                                <option
                                    value="{{ $hari }}"
                                    {{ $jadwalMengajar->hari==$hari ? 'selected':'' }}>

                                    {{ $hari }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="grid grid-cols-3 gap-4">

                        <div>

                            <label class="block font-semibold mb-2">
                                Jam Ke
                            </label>

                            <input
                                type="number"
                                name="jam_ke"
                                value="{{ $jadwalMengajar->jam_ke }}"
                                class="border rounded w-full p-2">

                        </div>

                        <div>

                            <label class="block font-semibold mb-2">
                                Jam Mulai
                            </label>

                            <input
                                type="time"
                                name="jam_mulai"
                                value="{{ $jadwalMengajar->jam_mulai }}"
                                class="border rounded w-full p-2">

                        </div>

                        <div>

                            <label class="block font-semibold mb-2">
                                Jam Selesai
                            </label>

                            <input
                                type="time"
                                name="jam_selesai"
                                value="{{ $jadwalMengajar->jam_selesai }}"
                                class="border rounded w-full p-2">

                        </div>

                    </div>

                    <div class="mt-6 flex gap-2">

                        <button
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">

                            💾 Update

                        </button>

                        <a
                            href="{{ route('jadwal-mengajar.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
