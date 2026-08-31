@extends('layouts.app')

@section('content')

<div class="container">

    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-xl shadow p-6">

            <div class="mb-6">

                <h2 class="text-2xl font-bold text-slate-800">
                    ✏️ Edit Template Jadwal
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Ubah durasi JP, jeda, dan jam awal pembelajaran
                    setiap hari.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('template-jadwal.update', $templateJadwal) }}"
            >

                @csrf
                @method('PUT')


                {{-- NAMA --}}

                <div class="mb-4">

                    <label class="block font-semibold mb-2">
                        Nama Template
                    </label>

                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', $templateJadwal->nama) }}"
                        class="w-full border rounded-lg px-3 py-2"
                        required
                    >

                </div>


                {{-- DURASI --}}

                <div class="grid md:grid-cols-2 gap-4">

                    <div>

                        <label class="block font-semibold mb-2">
                            Durasi JP (Menit)
                        </label>

                        <input
                            type="number"
                            name="durasi_jp"
                            value="{{ old('durasi_jp', $templateJadwal->durasi_jp) }}"
                            min="1"
                            class="w-full border rounded-lg px-3 py-2"
                            required
                        >

                    </div>


                    <div>

                        <label class="block font-semibold mb-2">
                            Jumlah JP
                        </label>

                        <input
                            type="number"
                            name="jumlah_jp"
                            value="{{ old('jumlah_jp', $templateJadwal->jumlah_jp) }}"
                            min="1"
                            class="w-full border rounded-lg px-3 py-2"
                            required
                        >

                    </div>

                </div>


                {{-- ISTIRAHAT --}}

                <div class="grid md:grid-cols-2 gap-4 mt-4">

                    <div>

                        <label class="block font-semibold mb-2">
                            Istirahat Setelah JP
                        </label>

                        <input
                            type="number"
                            name="istirahat_setelah"
                            value="{{ old('istirahat_setelah', $templateJadwal->istirahat_setelah) }}"
                            min="1"
                            class="w-full border rounded-lg px-3 py-2"
                        >

                    </div>


                    <div>

                        <label class="block font-semibold mb-2">
                            Durasi Istirahat
                        </label>

                        <input
                            type="number"
                            name="durasi_istirahat"
                            value="{{ old('durasi_istirahat', $templateJadwal->durasi_istirahat) }}"
                            min="1"
                            class="w-full border rounded-lg px-3 py-2"
                        >

                    </div>

                </div>


                {{-- ISHOMA --}}

                <div class="grid md:grid-cols-2 gap-4 mt-4">

                    <div>

                        <label class="block font-semibold mb-2">
                            Ishoma Setelah JP
                        </label>

                        <input
                            type="number"
                            name="ishoma_setelah"
                            value="{{ old('ishoma_setelah', $templateJadwal->ishoma_setelah) }}"
                            min="1"
                            class="w-full border rounded-lg px-3 py-2"
                        >

                    </div>


                    <div>

                        <label class="block font-semibold mb-2">
                            Durasi Ishoma
                        </label>

                        <input
                            type="number"
                            name="durasi_ishoma"
                            value="{{ old('durasi_ishoma', $templateJadwal->durasi_ishoma) }}"
                            min="1"
                            class="w-full border rounded-lg px-3 py-2"
                        >

                    </div>

                </div>


                {{-- HARI --}}

                <div class="mt-8">

                    <h3 class="text-lg font-bold mb-4">
                        🕐 Jam Awal Pembelajaran Setiap Hari
                    </h3>

                    @php

                        $hari = [
                            'Senin',
                            'Selasa',
                            'Rabu',
                            'Kamis',
                            'Jumat',
                            'Sabtu',
                        ];

                    @endphp


                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">

                        @foreach($hari as $h)

                            @php

                                $setting = $templateJadwal
                                    ->hariMulai
                                    ->firstWhere('hari', $h);

                                $jam = $setting
                                    ? substr($setting->jam_mulai, 0, 5)
                                    : '07:00';

                            @endphp


                            <div class="border rounded-xl p-4 bg-slate-50">

                                <label class="block font-semibold mb-2">
                                    {{ $h }}
                                </label>

                                <input
                                    type="time"
                                    name="hari[{{ $h }}][jam_mulai]"
                                    value="{{ old('hari.'.$h.'.jam_mulai', $jam) }}"
                                    class="w-full border rounded-lg px-3 py-2"
                                    required
                                >

                            </div>

                        @endforeach

                    </div>

                </div>


                {{-- AKTIF --}}

                <div class="mt-6">

                    <label class="inline-flex items-center gap-2">

                        <input
                            type="checkbox"
                            name="aktif"
                            value="1"
                            @checked(old('aktif', $templateJadwal->aktif))
                        >

                        <span>
                            Template Aktif
                        </span>

                    </label>

                </div>


                {{-- BUTTON --}}

                <div class="flex justify-between mt-8">

                    <a
                        href="{{ route('template-jadwal.index') }}"
                        class="bg-gray-500 text-white px-5 py-2 rounded-lg"
                    >
                        ← Kembali
                    </a>

                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg"
                    >
                        💾 Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection