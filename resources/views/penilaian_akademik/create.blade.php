@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- ====================================================== --}}
    {{-- HEADER --}}
    {{-- ====================================================== --}}

    <div class="bg-gradient-to-r from-blue-700 to-indigo-600
                rounded-2xl shadow-lg overflow-hidden mb-6">

        <div class="p-6 text-white">

            <div class="flex flex-col md:flex-row
                        md:items-center md:justify-between gap-4">

                <div>

                    <div class="text-xs uppercase tracking-wider
                                text-blue-100 mb-1">
                        SIKAP ESPENERO
                    </div>

                    <h1 class="text-2xl font-bold">
                        📝 Penilaian Akademik
                    </h1>

                    <p class="text-blue-100 mt-1">
                        Input nilai siswa berdasarkan kegiatan pembelajaran.
                    </p>

                </div>

                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center justify-center
                          bg-white text-blue-700 font-semibold
                          px-4 py-2 rounded-lg shadow
                          hover:bg-blue-50">

                    ← Kembali

                </a>

            </div>

        </div>

        {{-- INFO PEMBELAJARAN --}}

        <div class="bg-white p-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

                <div>
                    <div class="text-xs text-gray-500 uppercase">
                        Guru
                    </div>

                    <div class="font-bold text-gray-800 mt-1">
                        {{ $guruMengajar->guru->nama ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="text-xs text-gray-500 uppercase">
                        Mata Pelajaran
                    </div>

                    <div class="font-bold text-gray-800 mt-1">
                        {{ $guruMengajar->mataPelajaran->nama_mapel ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="text-xs text-gray-500 uppercase">
                        Kelas
                    </div>

                    <div class="font-bold text-gray-800 mt-1">
                        {{ $kelas->nama_kelas ?? '-' }}
                    </div>
                </div>

                <div>
                    <div class="text-xs text-gray-500 uppercase">
                        Tanggal Mengajar
                    </div>

                    <div class="font-bold text-gray-800 mt-1">
                        {{ $sesiMengajar->tanggal
                            ? \Carbon\Carbon::parse($sesiMengajar->tanggal)
                                ->format('d/m/Y')
                            : '-' }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- ERROR VALIDASI --}}
    {{-- ====================================================== --}}

    @if ($errors->any())

        <div class="bg-red-50 border border-red-200
                    text-red-700 rounded-xl p-4 mb-6">

            <div class="font-bold mb-2">
                ⚠ Data belum dapat disimpan.
            </div>

            <ul class="list-disc ml-5 text-sm">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- FORM --}}
    {{-- ====================================================== --}}

    <form
        action="{{ route('penilaian-akademik.store', $sesiMengajar) }}"
        method="POST">

        @csrf


        {{-- PERTEMUAN --}}

        @if($pertemuan)

            <input
                type="hidden"
                name="perencanaan_pertemuan_id"
                value="{{ $pertemuan->id }}">

        @endif


        {{-- ================================================== --}}
        {{-- IDENTITAS PENILAIAN --}}
        {{-- ================================================== --}}

        <div class="bg-white rounded-2xl shadow-sm
                    border border-gray-200 mb-6">

            <div class="border-b p-5">

                <h2 class="font-bold text-lg text-gray-800">
                    📚 Identitas Penilaian
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Tentukan jenis dan judul penilaian.
                </p>

            </div>

            <div class="p-5">

                @if($pertemuan)

                    <div class="bg-indigo-50 border border-indigo-100
                                rounded-xl p-4 mb-5">

                        <div class="text-xs text-indigo-500 uppercase">
                            Sumber Pertemuan
                        </div>

                        <div class="font-bold text-indigo-800 mt-1">

                            Pertemuan
                            {{ $pertemuan->pertemuan_ke }}

                            —

                            {{ $pertemuan->judul }}

                        </div>

                        @if($pertemuan->bab)

                            <div class="text-sm text-indigo-600 mt-1">

                                BAB {{ $pertemuan->bab->urutan }}
                                •
                                {{ $pertemuan->bab->nama_bab }}

                            </div>

                        @endif

                    </div>

                @endif


                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- JENIS --}}

                    <div>

                        <label class="block font-semibold
                                      text-gray-700 mb-2">

                            Jenis Penilaian
                            <span class="text-red-500">*</span>

                        </label>

                        <select
                            name="jenis"
                            required
                            class="w-full border border-gray-300
                                   rounded-lg p-3
                                   focus:ring-2 focus:ring-blue-500">

                            <option value="">
                                -- Pilih Jenis Penilaian --
                            </option>

                            <option value="Tugas"
                                {{ old('jenis') == 'Tugas' ? 'selected' : '' }}>
                                📝 Tugas
                            </option>

                            <option value="UH"
                                {{ old('jenis') == 'UH' ? 'selected' : '' }}>
                                📋 Ulangan Harian (UH)
                            </option>

                            <option value="Praktik"
                                {{ old('jenis') == 'Praktik' ? 'selected' : '' }}>
                                🧪 Praktik
                            </option>

                            <option value="Proyek"
                                {{ old('jenis') == 'Proyek' ? 'selected' : '' }}>
                                📦 Proyek
                            </option>

                        </select>

                    </div>


                    {{-- TANGGAL --}}

                    <div>

                        <label class="block font-semibold
                                      text-gray-700 mb-2">

                            Tanggal Penilaian

                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ old(
                                'tanggal',
                                $sesiMengajar->tanggal
                                    ? \Carbon\Carbon::parse(
                                        $sesiMengajar->tanggal
                                      )->format('Y-m-d')
                                    : date('Y-m-d')
                            ) }}"
                            class="w-full border border-gray-300
                                   rounded-lg p-3
                                   focus:ring-2 focus:ring-blue-500">

                    </div>


                    {{-- JUDUL --}}

                    <div class="md:col-span-2">

                        <label class="block font-semibold
                                      text-gray-700 mb-2">

                            Judul Penilaian
                            <span class="text-red-500">*</span>

                        </label>

                        <input
                            type="text"
                            name="judul"
                            value="{{ old('judul') }}"
                            required
                            placeholder="Contoh: Tugas 1 - Memahami Struktur Teks"
                            class="w-full border border-gray-300
                                   rounded-lg p-3
                                   focus:ring-2 focus:ring-blue-500">

                    </div>


                    {{-- KETERANGAN --}}

                    <div class="md:col-span-2">

                        <label class="block font-semibold
                                      text-gray-700 mb-2">

                            Keterangan

                        </label>

                        <textarea
                            name="keterangan"
                            rows="2"
                            placeholder="Opsional..."
                            class="w-full border border-gray-300
                                   rounded-lg p-3
                                   focus:ring-2 focus:ring-blue-500">{{ old('keterangan') }}</textarea>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================== --}}
        {{-- DAFTAR SISWA --}}
        {{-- ================================================== --}}

        <div class="bg-white rounded-2xl shadow-sm
                    border border-gray-200 overflow-hidden">

            <div class="p-5 border-b
                        flex flex-col md:flex-row
                        md:justify-between md:items-center gap-3">

                <div>

                    <h2 class="font-bold text-lg text-gray-800">
                        👨‍🎓 Daftar Nilai Siswa
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Masukkan nilai 0 sampai 100.
                    </p>

                </div>

                <div class="bg-blue-50 text-blue-700
                            px-4 py-2 rounded-full text-sm font-semibold">

                    {{ $siswas->count() }} Siswa

                </div>

            </div>


            @if($siswas->count() > 0)

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-800 text-white">

                            <tr>

                                <th class="text-center p-3 w-16">
                                    No
                                </th>

                                <th class="text-left p-3">
                                    Nama Siswa
                                </th>

                                <th class="text-center p-3 w-40">
                                    Nilai
                                </th>

                                <th class="text-left p-3">
                                    Catatan
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y">

                            @foreach($siswas as $index => $siswa)

                                <tr class="hover:bg-gray-50">

                                    <td class="p-3 text-center
                                               text-gray-500">

                                        {{ $index + 1 }}

                                    </td>

                                    <td class="p-3">

                                        <div class="font-semibold
                                                    text-gray-800">

                                            {{ $siswa->nama }}

                                        </div>

                                        <div class="text-xs
                                                    text-gray-400">

                                            NIS:
                                            {{ $siswa->nis ?? '-' }}

                                        </div>

                                    </td>

                                    <td class="p-3">

                                        <input
                                            type="number"
                                            name="nilai[{{ $siswa->id }}]"
                                            value="{{ old(
                                                'nilai.' . $siswa->id
                                            ) }}"
                                            min="0"
                                            max="100"
                                            step="0.01"
                                            placeholder="0 - 100"
                                            class="w-full text-center
                                                   font-bold border
                                                   border-gray-300
                                                   rounded-lg p-2
                                                   focus:ring-2
                                                   focus:ring-blue-500">

                                    </td>

                                    <td class="p-3">

                                        <input
                                            type="text"
                                            name="catatan[{{ $siswa->id }}]"
                                            value="{{ old(
                                                'catatan.' . $siswa->id
                                            ) }}"
                                            placeholder="Opsional"
                                            class="w-full border
                                                   border-gray-300
                                                   rounded-lg p-2
                                                   focus:ring-2
                                                   focus:ring-blue-500">

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- ========================================== --}}
                {{-- SIMPAN --}}
                {{-- ========================================== --}}

                <div class="p-5 bg-gray-50 border-t">

                    <div class="flex flex-col md:flex-row
                                md:justify-between md:items-center gap-4">

                        <div class="text-sm text-gray-500">

                            💡 Nilai yang belum tersedia boleh
                            dikosongkan terlebih dahulu.

                        </div>

                        <button
                            type="submit"
                            class="bg-green-600 hover:bg-green-700
                                   text-white font-bold
                                   px-7 py-3 rounded-xl shadow">

                            💾 Simpan Semua Nilai

                        </button>

                    </div>

                </div>

            @else

                <div class="p-10 text-center">

                    <div class="text-4xl mb-3">
                        👨‍🎓
                    </div>

                    <div class="font-bold text-gray-700">
                        Siswa tidak ditemukan
                    </div>

                    <div class="text-sm text-gray-500 mt-1">
                        Belum ada siswa aktif yang terhubung
                        dengan kelas ini.
                    </div>

                </div>

            @endif

        </div>

    </form>

</div>

@endsection