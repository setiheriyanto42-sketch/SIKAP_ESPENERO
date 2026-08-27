@extends('layouts.app')

@section('content')

<div class="w-full">

    <form
        method="POST"
        action="{{ route('mengajar.store', $jadwalMengajar) }}"
        id="formAbsensi">

        @csrf

        <input
            type="hidden"
            name="sesi_id"
            value="{{ $sesi->id }}">

        {{-- ========================================================= --}}
        {{-- HEADER MENGAJAR --}}
        {{-- ========================================================= --}}
        <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600
                    rounded-2xl p-6 text-white mb-6 shadow-xl">

            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-5">

                <div>

                    <h1 class="text-2xl md:text-3xl font-bold">
                        📚 {{ $jadwalMengajar->guruMengajar->mataPelajaran->nama_mapel }}
                    </h1>

                    <div class="mt-3 space-y-1 text-blue-100">

                        <p>
                            👨‍🏫
                            {{ auth()->user()->guru?->nama ?? auth()->user()->name }}
                        </p>

                        <p>
                            🏫 {{ $kelas->nama_kelas }}
                        </p>

                        <p>
                            🗓️ {{ now()->translatedFormat('l, d F Y') }}
                        </p>

                        <p>
                            🕐
                            {{ $jadwalMengajar->jam_mulai }}
                            -
                            {{ $jadwalMengajar->jam_selesai }}
                        </p>

                    </div>

                </div>

                <div class="bg-white/15 rounded-xl px-6 py-4 text-center">

                    <div class="text-sm text-blue-100">
                        Status Pembelajaran
                    </div>

                    <div class="text-xl font-bold mt-1">
                        🟢 Sedang Mengajar
                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- AREA UTAMA --}}
        {{-- ========================================================= --}}
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">

            {{-- ===================================================== --}}
            {{-- DAFTAR SISWA --}}
            {{-- ===================================================== --}}
            <div class="xl:col-span-3">

                <div class="bg-white border shadow-sm rounded-2xl p-5 md:p-6">

                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-5">

                        <div>

                            <h2 class="text-xl font-bold text-gray-800">
                                👨‍🎓 Daftar Siswa
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Pilih status kehadiran setiap siswa.
                            </p>

                        </div>

                        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">

                            Default: Semua Hadir

                        </div>

                    </div>


                    {{-- PENCARIAN --}}
                    <div class="mb-6">

                        <input
                            id="cariSiswa"
                            type="text"
                            placeholder="🔍 Cari nama atau NIS siswa..."
                            class="w-full border-2 border-blue-200 rounded-xl
                                   px-4 py-3
                                   focus:ring-2 focus:ring-blue-300
                                   focus:border-blue-500">

                    </div>


                    {{-- TOMBOL MASSAL --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">

                        <button
                            type="button"
                            id="btnSemuaHadir"
                            class="bg-green-600 hover:bg-green-700 text-white
                                   px-4 py-3 rounded-xl font-semibold">

                            🟢 Semua Hadir

                        </button>

                        <button
                            type="button"
                            id="btnSemuaIzin"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white
                                   px-4 py-3 rounded-xl font-semibold">

                            🟡 Semua Izin

                        </button>

                        <button
                            type="button"
                            id="btnSemuaSakit"
                            class="bg-blue-500 hover:bg-blue-600 text-white
                                   px-4 py-3 rounded-xl font-semibold">

                            🔵 Semua Sakit

                        </button>

                        <button
                            type="button"
                            id="btnSemuaAlfa"
                            class="bg-red-600 hover:bg-red-700 text-white
                                   px-4 py-3 rounded-xl font-semibold">

                            🔴 Semua Alfa

                        </button>

                    </div>


                    {{-- SISWA --}}
                    <div class="space-y-4">

                        @forelse($siswas as $i => $siswa)

                            <div
                                class="card-siswa bg-green-50 border border-gray-200
                                       rounded-2xl p-4 shadow-sm
                                       transition-all duration-200">

                                <input
                                    type="hidden"
                                    name="siswa_id[]"
                                    value="{{ $siswa->id }}">

                                <div class="flex justify-between items-start gap-3 mb-4">

                                    <div>

                                        <h3 class="text-lg font-bold text-gray-800">

                                            👨‍🎓 {{ $siswa->nama }}

                                        </h3>

                                        <p class="text-sm text-gray-500">

                                            NIS : {{ $siswa->nis }}

                                        </p>

                                    </div>

                                    <div class="bg-blue-100 text-blue-700
                                                px-3 py-1 rounded-full text-sm">

                                        No {{ $loop->iteration }}

                                    </div>

                                </div>


                                @php
                                    $statusList = [
                                        ['Hadir', '🟢'],
                                        ['Izin', '🟡'],
                                        ['Sakit', '🔵'],
                                        ['Alfa', '🔴'],
                                        ['Terlambat', '🟠'],
                                        ['Membolos', '⚫'],
                                    ];
                                @endphp


                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

                                    @foreach($statusList as $status)

                                        <label
                                            class="status-item border bg-white
                                                   rounded-xl p-3 cursor-pointer
                                                   hover:bg-blue-50 transition">

                                            <input
                                                class="hidden status-radio"
                                                type="radio"
                                                name="status[{{ $i }}]"
                                                value="{{ $status[0] }}"
                                                {{ $status[0] === 'Hadir' ? 'checked' : '' }}>

                                            <span class="block">
                                                {{ $status[1] }}
                                                {{ $status[0] }}
                                            </span>

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        @empty

                            <div class="bg-yellow-50 border border-yellow-200
                                        text-yellow-800 rounded-xl p-5">

                                Tidak ada siswa pada kelas ini.

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- RINGKASAN --}}
            {{-- ===================================================== --}}
            <div class="xl:col-span-1">

                <div class="xl:sticky xl:top-6">

                    <div class="bg-white rounded-2xl shadow-lg border p-5">

                        <h2 class="text-xl font-bold mb-5">

                            📊 Ringkasan Absensi

                        </h2>


                        {{-- PROGRESS --}}
                        <div class="mb-6">

                            <div class="flex justify-between text-sm">

                                <span>
                                    Progress
                                </span>

                                <span
                                    id="progressPersen"
                                    class="font-semibold">

                                    100%

                                </span>

                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-3 mt-2">

                                <div
                                    id="progressBar"
                                    class="bg-green-600 h-3 rounded-full transition-all"
                                    style="width:100%">

                                </div>

                            </div>

                        </div>


                        {{-- JUMLAH --}}
                        <div class="space-y-3">

                            <div class="flex justify-between bg-green-50 rounded-lg p-3">

                                <span>🟢 Hadir</span>

                                <strong id="jmlHadir">
                                    {{ count($siswas) }}
                                </strong>

                            </div>

                            <div class="flex justify-between bg-yellow-50 rounded-lg p-3">

                                <span>🟡 Izin</span>

                                <strong id="jmlIzin">
                                    0
                                </strong>

                            </div>

                            <div class="flex justify-between bg-blue-50 rounded-lg p-3">

                                <span>🔵 Sakit</span>

                                <strong id="jmlSakit">
                                    0
                                </strong>

                            </div>

                            <div class="flex justify-between bg-red-50 rounded-lg p-3">

                                <span>🔴 Alfa</span>

                                <strong id="jmlAlfa">
                                    0
                                </strong>

                            </div>

                            <div class="flex justify-between bg-orange-50 rounded-lg p-3">

                                <span>🟠 Terlambat</span>

                                <strong id="jmlTerlambat">
                                    0
                                </strong>

                            </div>

                            <div class="flex justify-between bg-gray-100 rounded-lg p-3">

                                <span>⚫ Membolos</span>

                                <strong id="jmlMembolos">
                                    0
                                </strong>

                            </div>

                        </div>


                        <hr class="my-6">


                        {{-- SATU-SATUNYA TOMBOL SIMPAN --}}
                        <button
                            type="submit"
                            id="btnSimpanAbsensi"
                            class="w-full bg-green-600 hover:bg-green-700
                                   text-white py-4 px-4 rounded-xl
                                   font-bold shadow transition">

                            💾 SIMPAN ABSENSI & LANJUT JURNAL

                        </button>

                        <p class="text-xs text-gray-500 text-center mt-3">

                            Setelah disimpan, Anda akan masuk ke Jurnal Mengajar.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>


<style>

    .status-item {
        user-select: none;
    }

    .status-item:has(input:checked) {
        border-color: rgb(37 99 235);
        box-shadow: 0 0 0 1px rgb(37 99 235);
    }

    .status-item input:checked + span {
        font-weight: 700;
    }

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const totalSiswa = {{ count($siswas) }};

    const form = document.getElementById('formAbsensi');

    const btnSimpan = document.getElementById('btnSimpanAbsensi');

    const cari = document.getElementById('cariSiswa');


    /*
    |--------------------------------------------------------------------------
    | HITUNG ABSENSI
    |--------------------------------------------------------------------------
    */

    function hitung() {

        let hadir = 0;
        let izin = 0;
        let sakit = 0;
        let alfa = 0;
        let terlambat = 0;
        let membolos = 0;

        document
            .querySelectorAll('.status-radio:checked')
            .forEach(function (radio) {

                switch (radio.value) {

                    case 'Hadir':
                        hadir++;
                        break;

                    case 'Izin':
                        izin++;
                        break;

                    case 'Sakit':
                        sakit++;
                        break;

                    case 'Alfa':
                        alfa++;
                        break;

                    case 'Terlambat':
                        terlambat++;
                        break;

                    case 'Membolos':
                        membolos++;
                        break;
                }

            });


        document.getElementById('jmlHadir').textContent = hadir;

        document.getElementById('jmlIzin').textContent = izin;

        document.getElementById('jmlSakit').textContent = sakit;

        document.getElementById('jmlAlfa').textContent = alfa;

        document.getElementById('jmlTerlambat').textContent = terlambat;

        document.getElementById('jmlMembolos').textContent = membolos;


        const terisi =
            hadir +
            izin +
            sakit +
            alfa +
            terlambat +
            membolos;


        const persen = totalSiswa > 0
            ? Math.round((terisi / totalSiswa) * 100)
            : 0;


        document.getElementById('progressPersen').textContent =
            persen + '%';

        document.getElementById('progressBar').style.width =
            persen + '%';
    }


    /*
    |--------------------------------------------------------------------------
    | WARNA CARD SISWA
    |--------------------------------------------------------------------------
    */

    function ubahWarnaCard(radio) {

        const card = radio.closest('.card-siswa');

        if (!card) {
            return;
        }

        card.classList.remove(
            'bg-green-50',
            'bg-yellow-50',
            'bg-blue-50',
            'bg-red-50',
            'bg-orange-50',
            'bg-gray-100'
        );


        switch (radio.value) {

            case 'Hadir':
                card.classList.add('bg-green-50');
                break;

            case 'Izin':
                card.classList.add('bg-yellow-50');
                break;

            case 'Sakit':
                card.classList.add('bg-blue-50');
                break;

            case 'Alfa':
                card.classList.add('bg-red-50');
                break;

            case 'Terlambat':
                card.classList.add('bg-orange-50');
                break;

            case 'Membolos':
                card.classList.add('bg-gray-100');
                break;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | EVENT STATUS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.status-radio')
        .forEach(function (radio) {

            radio.addEventListener('change', function () {

                ubahWarnaCard(this);

                hitung();

            });

        });


    /*
    |--------------------------------------------------------------------------
    | PILIH SEMUA
    |--------------------------------------------------------------------------
    */

    function pilihSemua(status) {

        document
            .querySelectorAll(
                '.status-radio[value="' + status + '"]'
            )
            .forEach(function (radio) {

                radio.checked = true;

                ubahWarnaCard(radio);

            });

        hitung();
    }


    document.getElementById('btnSemuaHadir')
        .addEventListener('click', function () {

            pilihSemua('Hadir');

        });


    document.getElementById('btnSemuaIzin')
        .addEventListener('click', function () {

            pilihSemua('Izin');

        });


    document.getElementById('btnSemuaSakit')
        .addEventListener('click', function () {

            pilihSemua('Sakit');

        });


    document.getElementById('btnSemuaAlfa')
        .addEventListener('click', function () {

            pilihSemua('Alfa');

        });


    /*
    |--------------------------------------------------------------------------
    | PENCARIAN SISWA
    |--------------------------------------------------------------------------
    */

    cari.addEventListener('input', function () {

        const keyword = this.value.toLowerCase().trim();

        document
            .querySelectorAll('.card-siswa')
            .forEach(function (card) {

                const teks = card.innerText.toLowerCase();

                card.style.display =
                    teks.includes(keyword)
                        ? ''
                        : 'none';

            });

    });


    /*
    |--------------------------------------------------------------------------
    | CEGAH DOUBLE SUBMIT
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function () {

        btnSimpan.disabled = true;

        btnSimpan.innerHTML =
            '⏳ MENYIMPAN ABSENSI...';

        btnSimpan.classList.add(
            'opacity-60',
            'cursor-not-allowed'
        );

    });


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.status-radio:checked')
        .forEach(function (radio) {

            ubahWarnaCard(radio);

        });

    hitung();

});

</script>

@endsection