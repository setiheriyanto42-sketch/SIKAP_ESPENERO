@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="bg-white rounded-xl shadow-lg p-6">

        <div class="flex justify-between items-center mb-6">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">
                    📖 Tambah BAB
                </h1>

                <p class="text-gray-500">

                    {{ $modul->judul }}

                </p>

            </div>

            <a href="{{ route('modul-ajar.show',$modul->id) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg">

                ← Kembali

            </a>

        </div>

        <form
            action="{{ route('modul-bab.store') }}"
            method="POST">

            @csrf

            <input
                type="hidden"
                name="perencanaan_pembelajaran_id"
                value="{{ $modul->id }}">

            <div class="space-y-5">

                <div>

                    <label class="font-semibold">

                        Nama BAB

                    </label>

                    <input
                        type="text"
                        name="nama_bab"
                        class="w-full border rounded-lg p-3 mt-2"
                        placeholder="Contoh : Teks Deskripsi"
                        required>

                </div>

                <div>

                    <label class="font-semibold">

                        Materi Pokok

                    </label>

                    <textarea
                        name="materi_pokok"
                        rows="3"
                        class="w-full border rounded-lg p-3 mt-2"
                        placeholder="Materi yang akan dipelajari..."></textarea>

                </div>

                <div>

                    <label class="font-semibold">

                        Capaian Pembelajaran (CP)

                    </label>

                    <textarea
                        name="cp"
                        rows="4"
                        class="w-full border rounded-lg p-3 mt-2"></textarea>

                </div>

                <div>

                    <label class="font-semibold">

                        Tujuan Pembelajaran

                    </label>

                    <textarea
                        name="tujuan"
                        rows="4"
                        class="w-full border rounded-lg p-3 mt-2"></textarea>

                </div>

                <div class="grid grid-cols-2 gap-5">

                    <div>

                        <label class="font-semibold">

                            Jumlah Pertemuan

                        </label>

                        <input
                            type="number"
                            min="1"
                            value="6"
                            name="jumlah_pertemuan"
                            class="w-full border rounded-lg p-3 mt-2">

                    </div>

                    <div>

                        <label class="font-semibold">

                            Keterangan

                        </label>

                        <input
                            type="text"
                            name="keterangan"
                            class="w-full border rounded-lg p-3 mt-2">

                    </div>

                </div>

            </div>

            <div class="mt-8">

                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg">

                    💾 Simpan BAB

                </button>

            </div>

        </form>

    </div>

</div>

@endsection