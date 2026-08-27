@extends('layouts.app')

@section('content')

<div class="w-full">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            📖 Jurnal Mengajar
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Catat pelaksanaan pembelajaran berdasarkan Modul Ajar.
        </p>
    </div>

    {{-- INFORMASI PEMBELAJARAN --}}
    <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-500
                text-white rounded-xl shadow-lg p-6 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

            <div>
                <div class="text-xs opacity-80">Guru</div>
                <div class="font-bold mt-1">
                    {{ $sesi->jadwalMengajar->guruMengajar->guru->nama }}
                </div>
            </div>

            <div>
                <div class="text-xs opacity-80">Mata Pelajaran</div>
                <div class="font-bold mt-1">
                    {{ $sesi->jadwalMengajar->guruMengajar->mataPelajaran->nama_mapel }}
                </div>
            </div>

            <div>
                <div class="text-xs opacity-80">Kelas</div>
                <div class="font-bold mt-1">
                    {{ $sesi->jadwalMengajar->guruMengajar->kelas->nama_kelas }}
                </div>
            </div>

            <div>
                <div class="text-xs opacity-80">Tanggal</div>
                <div class="font-bold mt-1">
                    {{ $sesi->tanggal->format('d-m-Y') }}
                </div>
            </div>

        </div>

    </div>


    {{-- ERROR VALIDASI --}}
    @if ($errors->any())

        <div class="bg-red-50 border border-red-300 text-red-700
                    rounded-lg p-4 mb-6">

            <div class="font-bold mb-2">
                ⚠ Data belum dapat disimpan
            </div>

            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('jurnal-mengajar.store') }}"
        id="formJurnal">

        @csrf

        <input
            type="hidden"
            name="sesi_mengajar_id"
            value="{{ $sesi->id }}">

        <input
            type="hidden"
            name="jumlah_hadir"
            value="{{ $hadir }}">

        <input
            type="hidden"
            name="jumlah_tidak_hadir"
            value="{{ $tidakHadir }}">


        {{-- PILIH RENCANA PEMBELAJARAN --}}
        <div class="bg-white rounded-xl shadow border mb-6">

            <div class="border-b px-6 py-4">

                <h2 class="font-bold text-lg text-gray-800">
                    📚 Rencana Pembelajaran
                </h2>

                <p class="text-sm text-gray-500">
                    Pilih BAB dan pertemuan yang sedang dilaksanakan.
                </p>

            </div>


            <div class="p-6">

                @if($moduls->isEmpty())

                    <div class="bg-yellow-50 border border-yellow-300
                                text-yellow-800 rounded-lg p-5">

                        <div class="font-bold">
                            ⚠ Modul Ajar belum ditemukan
                        </div>

                        <p class="text-sm mt-1">
                            Belum ada Modul Ajar aktif yang sesuai dengan
                            guru, mata pelajaran, dan tingkat kelas ini.
                        </p>

                    </div>

                @else

                    {{-- MODUL --}}
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            Modul Ajar
                        </label>

                        <select
                            id="modul_id"
                            class="w-full rounded-lg border-gray-300">

                            <option value="">
                                -- Pilih Modul Ajar --
                            </option>

                            @foreach($moduls as $modul)

                                <option value="{{ $modul->id }}">
                                    {{ $modul->judul }}
                                    @if($modul->semester)
                                        — Semester {{ $modul->semester }}
                                    @endif
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- BAB --}}
                    <div class="mb-5">

                        <label class="block font-semibold mb-2">
                            BAB / Materi
                        </label>

                        <select
                            id="bab_id"
                            class="w-full rounded-lg border-gray-300"
                            disabled>

                            <option value="">
                                -- Pilih BAB --
                            </option>

                        </select>

                    </div>


                    {{-- PERTEMUAN --}}
                    <div>

                        <label class="block font-semibold mb-2">
                            Pertemuan
                        </label>

                        <select
                            id="pertemuan_id"
                            name="perencanaan_pertemuan_id"
                            class="w-full rounded-lg border-gray-300"
                            required
                            disabled>

                            <option value="">
                                -- Pilih Pertemuan --
                            </option>

                        </select>

                    </div>

                @endif

            </div>

        </div>


        {{-- DETAIL DARI MODUL --}}
        <div
            id="detailPertemuan"
            class="bg-white rounded-xl shadow border mb-6 hidden">

            <div class="border-b px-6 py-4">

                <h2 class="font-bold text-lg">
                    📘 Rencana Pertemuan
                </h2>

                <p class="text-sm text-gray-500">
                    Data berikut diambil otomatis dari Modul Ajar.
                </p>

            </div>


            <div class="p-6">

                <div class="mb-6">

                    <div class="text-sm text-gray-500">
                        Judul Pertemuan
                    </div>

                    <div
                        id="detailJudul"
                        class="font-bold text-xl text-gray-800 mt-1">
                        -
                    </div>

                </div>


                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                    <div class="bg-blue-50 rounded-lg p-5">

                        <div class="font-bold text-blue-800 mb-2">
                            🎯 Tujuan Pembelajaran
                        </div>

                        <div
                            id="detailTujuan"
                            class="text-sm whitespace-pre-line">
                            -
                        </div>

                    </div>


                    <div class="bg-indigo-50 rounded-lg p-5">

                        <div class="font-bold text-indigo-800 mb-2">
                            📚 Materi Rencana
                        </div>

                        <div
                            id="detailMateri"
                            class="text-sm whitespace-pre-line">
                            -
                        </div>

                    </div>


                    <div class="bg-green-50 rounded-lg p-5">

                        <div class="font-bold text-green-800 mb-2">
                            👨‍🏫 Metode
                        </div>

                        <div
                            id="detailMetode"
                            class="text-sm whitespace-pre-line">
                            -
                        </div>

                    </div>


                    <div class="bg-purple-50 rounded-lg p-5">

                        <div class="font-bold text-purple-800 mb-2">
                            🖥️ Media
                        </div>

                        <div
                            id="detailMedia"
                            class="text-sm whitespace-pre-line">
                            -
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- PELAKSANAAN --}}
        <div class="bg-white rounded-xl shadow border">

            <div class="border-b px-6 py-4">

                <h2 class="font-bold text-lg">
                    ✏️ Pelaksanaan Pembelajaran
                </h2>

                <p class="text-sm text-gray-500">
                    Bagian ini diisi guru sesuai kondisi pembelajaran hari ini.
                </p>

            </div>


            <div class="p-6">

                {{-- ABSENSI --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-7">

                    <div class="bg-green-50 border border-green-200
                                rounded-lg p-4 text-center">

                        <div class="text-sm text-green-700">
                            Hadir
                        </div>

                        <div class="text-2xl font-bold text-green-700">
                            {{ $hadir }}
                        </div>

                    </div>

                    <div class="bg-red-50 border border-red-200
                                rounded-lg p-4 text-center">

                        <div class="text-sm text-red-700">
                            Tidak Hadir
                        </div>

                        <div class="text-2xl font-bold text-red-700">
                            {{ $tidakHadir }}
                        </div>

                    </div>

                </div>


                {{-- MATERI TERCAPAI --}}
                <div class="mb-6">

                    <label class="block font-bold mb-2">
                        📌 Materi Hari Ini Sampai Mana?
                    </label>

                    <p class="text-sm text-gray-500 mb-2">
                        Tuliskan batas materi yang benar-benar tercapai
                        pada pembelajaran hari ini.
                    </p>

                    <textarea
                        name="materi_tercapai"
                        rows="4"
                        required
                        class="w-full rounded-lg border-gray-300"
                        placeholder="Contoh: Materi sampai pembahasan struktur teks dan latihan mengidentifikasi bagian-bagiannya.">{{ old('materi_tercapai') }}</textarea>

                </div>


                {{-- CATATAN --}}
                <div class="mb-6">

                    <label class="block font-bold mb-2">
                        📝 Catatan Guru
                    </label>

                    <textarea
                        name="catatan"
                        rows="4"
                        class="w-full rounded-lg border-gray-300"
                        placeholder="Catatan umum selama proses pembelajaran...">{{ old('catatan') }}</textarea>

                </div>


                {{-- REFLEKSI --}}
                <div class="mb-6">

                    <label class="block font-bold mb-2">
                        💡 Refleksi Pembelajaran
                    </label>

                    <textarea
                        name="refleksi"
                        rows="4"
                        class="w-full rounded-lg border-gray-300"
                        placeholder="Contoh: Sebagian besar siswa sudah memahami materi, beberapa siswa masih membutuhkan pendampingan.">{{ old('refleksi') }}</textarea>

                </div>


                <div class="border-t pt-6 flex justify-end">

                    <button
                        type="submit"
                        @if($moduls->isEmpty()) disabled @endif
                        class="bg-green-600 hover:bg-green-700
                               disabled:bg-gray-400
                               text-white font-semibold
                               px-8 py-3 rounded-lg shadow">

                        💾 Simpan Jurnal & Selesaikan Pembelajaran

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- DATA MODUL UNTUK JAVASCRIPT --}}
@php
    $dataModul = $moduls->map(function ($modul) {
        return [
            'id' => $modul->id,

            'babs' => $modul->babs->map(function ($bab) {
                return [
                    'id' => $bab->id,
                    'nama_bab' => $bab->nama_bab,

                    'pertemuans' => $bab->pertemuans->map(function ($pertemuan) {
                        return [
                            'id' => $pertemuan->id,
                            'pertemuan_ke' => $pertemuan->pertemuan_ke,
                            'judul' => $pertemuan->judul,
                            'materi' => $pertemuan->materi,
                            'tujuan' => $pertemuan->tujuan,
                            'metode' => $pertemuan->metode,
                            'media' => $pertemuan->media,
                            'sudah_diajarkan' => $pertemuan->sudah_diajarkan,
                        ];
                    })->values(),
                ];
            })->values(),
        ];
    })->values();
@endphp

<script>

const modulData = @json($dataModul);
console.log(JSON.stringify(modulData, null, 2));
const modulSelect = document.getElementById('modul_id');
const babSelect = document.getElementById('bab_id');
const pertemuanSelect = document.getElementById('pertemuan_id');

const detailBox = document.getElementById('detailPertemuan');


if (modulSelect) {

    modulSelect.addEventListener('change', function () {

        babSelect.innerHTML =
            '<option value="">-- Pilih BAB --</option>';

        pertemuanSelect.innerHTML =
            '<option value="">-- Pilih Pertemuan --</option>';

        pertemuanSelect.disabled = true;

        detailBox.classList.add('hidden');

        if (!this.value) {

            babSelect.disabled = true;

            return;
        }


        const modul = modulData.find(
            item => String(item.id) === String(this.value)
        );


        if (!modul) {
            return;
        }


        modul.babs.forEach(function (bab) {

            const option = document.createElement('option');

            option.value = bab.id;

            option.textContent = bab.nama_bab;

            babSelect.appendChild(option);

        });


        babSelect.disabled = false;

    });


    babSelect.addEventListener('change', function () {

        pertemuanSelect.innerHTML =
            '<option value="">-- Pilih Pertemuan --</option>';

        detailBox.classList.add('hidden');


        const modul = modulData.find(
            item => String(item.id) === String(modulSelect.value)
        );


        if (!modul) {
            return;
        }


        const bab = modul.babs.find(
            item => String(item.id) === String(this.value)
        );


        if (!bab) {

            pertemuanSelect.disabled = true;

            return;
        }


        bab.pertemuans.forEach(function (pertemuan) {

            const option = document.createElement('option');

            option.value = pertemuan.id;

            option.textContent =
                'Pertemuan ' +
                pertemuan.pertemuan_ke +
                ' — ' +
                pertemuan.judul +
                (pertemuan.sudah_diajarkan
                    ? ' (Sudah Dilaksanakan)'
                    : '');

            pertemuanSelect.appendChild(option);

        });


        pertemuanSelect.disabled = false;

    });


    pertemuanSelect.addEventListener('change', function () {

        const modul = modulData.find(
            item => String(item.id) === String(modulSelect.value)
        );


        if (!modul) {
            return;
        }


        const bab = modul.babs.find(
            item => String(item.id) === String(babSelect.value)
        );


        if (!bab) {
            return;
        }


        const pertemuan = bab.pertemuans.find(
            item => String(item.id) === String(this.value)
        );


        if (!pertemuan) {

            detailBox.classList.add('hidden');

            return;
        }


        document.getElementById('detailJudul').textContent =
            pertemuan.judul || '-';

        document.getElementById('detailTujuan').textContent =
            pertemuan.tujuan || '-';

        document.getElementById('detailMateri').textContent =
            pertemuan.materi || '-';

        document.getElementById('detailMetode').textContent =
            pertemuan.metode || '-';

        document.getElementById('detailMedia').textContent =
            pertemuan.media || '-';


        detailBox.classList.remove('hidden');

    });

}

</script>

@endsection