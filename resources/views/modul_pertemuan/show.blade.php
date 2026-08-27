@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4">

    {{-- ========================================================= --}}
    {{-- NOTIFIKASI --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-xl">

            ✅ {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-xl">

            <div class="font-bold mb-2">

                Data belum dapat disimpan:

            </div>

            <ul class="list-disc ml-6">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('pertemuan.update', $pertemuan) }}"
        method="POST">

        @csrf
        @method('PUT')


        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">


            {{-- ================================================= --}}
            {{-- HEADER --}}
            {{-- ================================================= --}}

            <div class="bg-gradient-to-r from-indigo-600 to-blue-700 text-white p-6 md:p-8">

                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-5">

                    <div>

                        <div class="text-sm opacity-80 mb-2">

                            MODUL AJAR

                        </div>

                        <h1 class="text-2xl md:text-3xl font-bold">

                            📘 Editor Pertemuan
                            {{ $pertemuan->pertemuan_ke }}

                        </h1>


                        <div class="mt-3 text-lg font-semibold">

                            {{ $pertemuan->bab->modul->judul }}

                        </div>


                        <div class="text-sm opacity-90 mt-1">

                            BAB {{ $pertemuan->bab->urutan }}

                            •

                            {{ $pertemuan->bab->nama_bab }}

                        </div>

                    </div>


                    <a
                        href="{{ route('modul-ajar.show',$pertemuan->bab->modul->id) }}"
                        class="inline-flex items-center self-start md:self-auto bg-white text-indigo-700 px-5 py-2 rounded-lg font-semibold hover:bg-gray-100 whitespace-nowrap">
                        ← Kembali ke Modul
                    </a>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- INFORMASI MODUL --}}
            {{-- ================================================= --}}

            <div class="bg-gray-50 border-b p-6">

                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">


                    <div>

                        <div class="text-xs text-gray-500 uppercase">

                            Mata Pelajaran

                        </div>

                        <div class="font-bold mt-1">

                            {{ $pertemuan->bab->modul->mataPelajaran->nama_mapel ?? '-' }}

                        </div>

                    </div>


                    <div>

                        <div class="text-xs text-gray-500 uppercase">

                            Kelas

                        </div>

                        <div class="font-bold mt-1">

                            {{ $pertemuan->bab->modul->tingkat ?? '-' }}

                        </div>

                    </div>


                    <div>

                        <div class="text-xs text-gray-500 uppercase">

                            Semester

                        </div>

                        <div class="font-bold mt-1">

                            {{ $pertemuan->bab->modul->semester ?? '-' }}

                        </div>

                    </div>


                    <div>

                        <div class="text-xs text-gray-500 uppercase">

                            Guru

                        </div>

                        <div class="font-bold mt-1">

                            {{ $pertemuan->bab->modul->guru->nama ?? '-' }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- FORM --}}
            {{-- ================================================= --}}

            <div class="p-6 md:p-8">


                {{-- JUDUL + TANGGAL --}}

                <div class="grid md:grid-cols-2 gap-6">

                    <div>

                        <label class="font-bold text-gray-700">

                            Judul Pertemuan

                        </label>

                        <input
                            type="text"
                            name="judul"
                            value="{{ old(
                                'judul',
                                $pertemuan->judul
                            ) }}"
                            required
                            class="w-full mt-2 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                    </div>


                    <div>

                        <label class="font-bold text-gray-700">

                            📅 Tanggal Pelaksanaan

                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ old(
                                'tanggal',
                                optional($pertemuan->tanggal)->format('Y-m-d')
                            ) }}"
                            class="w-full mt-2 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- TUJUAN --}}
                {{-- ================================================= --}}

                <div class="mt-8">

                    <label class="font-bold text-lg text-gray-800">

                        🎯 Tujuan Pembelajaran

                    </label>

                    <p class="text-sm text-gray-500 mt-1">

                        Kompetensi atau kemampuan yang diharapkan
                        dikuasai siswa pada pertemuan ini.

                    </p>

                    <textarea
                        name="tujuan"
                        rows="5"
                        placeholder="Tuliskan tujuan pembelajaran..."
                        class="w-full mt-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('tujuan', $pertemuan->tujuan) }}</textarea>

                </div>


                {{-- ================================================= --}}
                {{-- MATERI --}}
                {{-- ================================================= --}}

                <div class="mt-8">

                    <label class="font-bold text-lg text-gray-800">

                        📚 Materi Pembelajaran

                    </label>

                    <p class="text-sm text-gray-500 mt-1">

                        Materi utama yang akan disampaikan kepada siswa.

                    </p>

                    <textarea
                        name="materi"
                        rows="8"
                        placeholder="Tuliskan materi pembelajaran..."
                        class="w-full mt-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('materi', $pertemuan->materi) }}</textarea>

                </div>


                {{-- ================================================= --}}
                {{-- METODE + MEDIA --}}
                {{-- ================================================= --}}

                <div class="grid md:grid-cols-2 gap-6 mt-8">


                    <div>

                        <label class="font-bold text-lg text-gray-800">

                            👨‍🏫 Metode Pembelajaran

                        </label>

                        <p class="text-sm text-gray-500 mt-1">

                            Contoh: diskusi, demonstrasi, proyek,
                            problem based learning.

                        </p>

                        <textarea
                            name="metode"
                            rows="6"
                            placeholder="Tuliskan metode pembelajaran..."
                            class="w-full mt-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('metode', $pertemuan->metode) }}</textarea>

                    </div>


                    <div>

                        <label class="font-bold text-lg text-gray-800">

                            🖥️ Media Pembelajaran

                        </label>

                        <p class="text-sm text-gray-500 mt-1">

                            Perangkat, aplikasi, bahan, atau media yang digunakan.

                        </p>

                        <textarea
                            name="media"
                            rows="6"
                            placeholder="Tuliskan media pembelajaran..."
                            class="w-full mt-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('media', $pertemuan->media) }}</textarea>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- LKPD + ASESMEN --}}
                {{-- ================================================= --}}

                <div class="grid md:grid-cols-2 gap-6 mt-8">


                    <div class="border rounded-xl p-5 bg-green-50">

                        <label class="font-bold text-lg text-gray-800">

                            📝 LKPD / Aktivitas Siswa

                        </label>

                        <p class="text-sm text-gray-500 mt-1">

                            Tugas atau aktivitas yang dikerjakan siswa.

                        </p>

                        <textarea
                            name="lkpd"
                            rows="8"
                            placeholder="Tuliskan LKPD atau aktivitas siswa..."
                            class="w-full mt-3 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">{{ old('lkpd', $pertemuan->lkpd) }}</textarea>

                    </div>


                    <div class="border rounded-xl p-5 bg-orange-50">

                        <label class="font-bold text-lg text-gray-800">

                            📊 Asesmen / Penilaian

                        </label>

                        <p class="text-sm text-gray-500 mt-1">

                            Bentuk asesmen yang digunakan pada pertemuan ini.

                        </p>

                        <textarea
                            name="asesmen"
                            rows="8"
                            placeholder="Tuliskan asesmen atau penilaian..."
                            class="w-full mt-3 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">{{ old('asesmen', $pertemuan->asesmen) }}</textarea>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- CATATAN + REFLEKSI --}}
                {{-- ================================================= --}}

                <div class="grid md:grid-cols-2 gap-6 mt-8">


                    <div>

                        <label class="font-bold text-lg text-gray-800">

                            📝 Catatan Guru

                        </label>

                        <textarea
                            name="catatan"
                            rows="6"
                            placeholder="Catatan selama atau setelah pembelajaran..."
                            class="w-full mt-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('catatan', $pertemuan->catatan) }}</textarea>

                    </div>


                    <div>

                        <label class="font-bold text-lg text-gray-800">

                            💡 Refleksi

                        </label>

                        <textarea
                            name="refleksi"
                            rows="6"
                            placeholder="Tuliskan refleksi hasil pembelajaran..."
                            class="w-full mt-3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('refleksi', $pertemuan->refleksi) }}</textarea>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- STATUS --}}
                {{-- ================================================= --}}

                <div class="mt-8 border rounded-xl p-6 bg-gray-50">

                    <h3 class="font-bold text-lg mb-5">

                        ⚙️ Status Pertemuan

                    </h3>


                    <div class="grid md:grid-cols-2 gap-5">


                        <label class="flex items-center gap-4 bg-white border rounded-xl p-4 cursor-pointer">

                            <input
                                type="checkbox"
                                name="sudah_diajarkan"
                                value="1"
                                {{ old(
                                    'sudah_diajarkan',
                                    $pertemuan->sudah_diajarkan
                                ) ? 'checked' : '' }}
                                class="rounded">

                            <div>

                                <div class="font-bold">

                                    ✅ Sudah Dilaksanakan

                                </div>

                                <div class="text-sm text-gray-500">

                                    Tandai setelah pertemuan selesai dilaksanakan.

                                </div>

                            </div>

                        </label>


                        <label class="flex items-center gap-4 bg-white border rounded-xl p-4 cursor-pointer">

                            <input
                                type="checkbox"
                                name="ada_penilaian"
                                value="1"
                                {{ old(
                                    'ada_penilaian',
                                    $pertemuan->ada_penilaian
                                ) ? 'checked' : '' }}
                                class="rounded">

                            <div>

                                <div class="font-bold">

                                    📊 Ada Penilaian

                                </div>

                                <div class="text-sm text-gray-500">

                                    Tandai jika pertemuan mempunyai asesmen.

                                </div>

                            </div>

                        </label>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- FOOTER --}}
                {{-- ================================================= --}}

                <div class="flex flex-col md:flex-row justify-between md:items-center gap-5 mt-10 border-t pt-8">


                    <div class="text-sm text-gray-500">

                        Terakhir diperbarui:

                        <strong>

                            {{ optional(
                                $pertemuan->updated_at
                            )->format('d-m-Y H:i') }}

                        </strong>

                    </div>


                    <div class="flex gap-3">

                        <a
                            href="{{ route(
                                'modul-ajar.show',
                                $pertemuan->bab->modul->id
                            ) }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                            ← Kembali

                        </a>


                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-lg shadow">

                            💾 Simpan Pertemuan

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection