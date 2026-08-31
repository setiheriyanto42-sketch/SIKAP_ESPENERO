@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header">

            <h4>Tambah Template Jadwal</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('template-jadwal.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Nama Template</label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Durasi JP (Menit)</label>

                        <input
                            type="number"
                            name="durasi_jp"
                            value="40"
                            class="form-control">

                    </div>

                    <div class="mt-8">

                        <h3 class="text-lg font-bold text-slate-800 mb-2">
                            🕐 Pengaturan Jam Awal Pembelajaran
                        </h3>

                        <p class="text-sm text-gray-500 mb-5">
                            Atur waktu dimulainya JP 1 untuk masing-masing hari.
                            Waktu ini digunakan sistem untuk menghitung JP berikutnya.
                        </p>

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

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                            @foreach($hari as $h)

                                <div class="bg-slate-50 border rounded-xl p-4">

                                    <label class="block font-semibold text-slate-700 mb-2">
                                        {{ $h }}
                                    </label>

                                    <input
                                        type="time"
                                        name="hari[{{ $h }}][jam_mulai]"
                                        value="{{ old('hari.'.$h.'.jam_mulai', '07:00') }}"
                                        class="w-full border rounded-lg px-3 py-2"
                                        required
                                    >

                                </div>

                            @endforeach

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Jumlah JP</label>

                        <input
                            type="number"
                            name="jumlah_jp"
                            value="10"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Istirahat setelah JP</label>

                        <input
                            type="number"
                            name="istirahat_setelah"
                            value="3"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Durasi Istirahat</label>

                        <input
                            type="number"
                            name="durasi_istirahat"
                            value="20"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Ishoma setelah JP</label>

                        <input
                            type="number"
                            name="ishoma_setelah"
                            value="6"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Durasi Ishoma</label>

                        <input
                            type="number"
                            name="durasi_ishoma"
                            value="40"
                            class="form-control">

                    </div>

                </div>

                <button
                    class="btn btn-primary">

                    Simpan

                </button>

                <a href="{{ route('template-jadwal.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection